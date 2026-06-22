<?php

/**
 * Fatal Error Handler
 *
 * This file handles PHP errors, warnings, and fatal errors before the framework
 * is fully initialized. It provides error logging and display for both development
 * and production environments.
 *
 * Loading Context:
 *   - Loaded AFTER config/settings.php ($settings array available)
 *   - Loaded AFTER DEV constant is defined
 *   - Loaded BEFORE Registry initialization
 *
 * Limitations:
 *   - Can access $settings array and DEV constant
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright 2015 - 2030 Geoffrey Okongo
 * @category Core
 * @package Core\Exceptions
 * @link https://github.com/glivers/rachie
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 2.0.1
 */ 

// ===========================================================================
// CONFIGURATION ACCESS
// ===========================================================================

// Make $settings available to all functions in this file
// $settings is loaded in bootstrap.php before this file is included
$settings;

// ===========================================================================
// ERROR TYPE MAPPING
// ===========================================================================

// Map error codes to human-readable names
$ERROR_TYPES = array(
	E_ERROR             => 'E_ERROR',
	E_WARNING           => 'E_WARNING',
	E_PARSE             => 'E_PARSE',
	E_NOTICE            => 'E_NOTICE',
	E_CORE_ERROR        => 'E_CORE_ERROR',
	E_CORE_WARNING      => 'E_CORE_WARNING',
	E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
	E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
	E_USER_ERROR        => 'E_USER_ERROR',
	E_USER_WARNING      => 'E_USER_WARNING',
	E_USER_NOTICE       => 'E_USER_NOTICE',
	E_STRICT            => 'E_STRICT',
	E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
	E_DEPRECATED        => 'E_DEPRECATED',
	E_USER_DEPRECATED   => 'E_USER_DEPRECATED'
);

// ===========================================================================
// PHP ERROR CONFIGURATION
// ===========================================================================

// Disable PHP's native error logging (we handle it ourselves)
ini_set('log_errors', 'Off');

// ini_set('error_log', dirname(dirname(dirname(__FILE__))) . '/vault/logs/error.log');

// Define fatal error types
define('E_FATAL', E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

// Set error reporting level
define('ERROR_REPORTING', E_ALL | E_STRICT);

// Register error handler (catches non-fatal errors)
set_error_handler('error_handler');

// Register exception handler for caught and uncaught \Exceptions
set_exception_handler('exception_handler');

// Register shutdown function (catches fatal errors)
register_shutdown_function('shutdown_handler');

// ===========================================================================
// SHUTDOWN HANDLER - Catches fatal errors
// ===========================================================================

/**
 * Shutdown handler - catches fatal errors that would otherwise kill the script
 *
 * This function is called when PHP shuts down, either normally or due to a fatal error.
 * It checks if the shutdown was caused by a fatal error and passes it to the error handler.
 *
 * @return void
 */
function shutdown_handler()
{
	// Get the last error that occurred
	$error = error_get_last();

	// Check if it was a fatal error
	if ($error && ($error['type'] & E_FATAL)){

		$exception 	= new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
		exception_handler($exception);
	}
}

/**
 * Exception handler for both caught and uncaught exceptions
 * 
 * @param Object \Throwable object
 */
function exception_handler(\Throwable $exception)
{
	global $settings, $ERROR_TYPES;

	// Detect the path accessed during error
	$path   	= $_SERVER['REQUEST_URI'] ?? 'CLI';
	
	// Get application root path from settings
	$root = $settings['root'];

	// Build stack trace for context
	$trace 		= $exception->getTraceAsString();
	$context 	= substr($trace, 0, (strpos($trace, "#10")) ? strpos($trace, "#10") - 2 : 2000);
	$context 	= preg_replace('/\n/', ' ', $context);

	$file 		= $exception->getFile();
	$line 		= $exception->getLine();
	$classname	= get_class($exception);
	$message 	= $exception->getMessage();
	
	// Get human-readable error type name
	// $type = isset($ERROR_TYPES[$number]) ? $ERROR_TYPES[$number] : 'UNKNOWN_ERROR';
	// $severity 	= $exception->getSeverity();

	// Compose error message for both display and logging
	$timestamp  	= "[" . date("d-M-Y H:i:s") . "]";
	$errorMessage 	= sprintf("[%s] [%s] %s in %s on line (%s) STACK TRACE: %s",
					    $classname, $path, $message, $file, $line, $context);

	// Remove absolute path and .php extension for cleaner display
	$errorMessage = str_replace([$root, '.php'], '', $errorMessage);

	// Compose error message for log file (plain text, no HTML)
	$errorLogged  = $timestamp . " " . $errorMessage;

	// Get error log file path from settings
	$logFile = $root . '/' . $settings['error_log'];

	// Write error to log file
	error_log($errorLogged . PHP_EOL, 3, $logFile);

	// Display error based on environment
	displayError($errorMessage, $settings);
}

// ===========================================================================
// ERROR HANDLER - Processes and displays errors
// ===========================================================================

/**
 * Error handler - processes all PHP errors and displays them appropriately
 *
 * This function handles all errors (fatal and non-fatal), logs them to the error log,
 * and displays them based on the environment (development vs production).
 *
 * @param int $errNo Error number (E_ERROR, E_WARNING, etc.)
 * @param string $errMsg Error message
 * @param string $errFile File where error occurred
 * @param int $errLine Line number where error occurred
 * @return void
 */
function error_handler($type, $message, $file, $line)
{
	// If error_reporting() return 0, the developer intentionally muted this line with @
	if(!(error_reporting() & $type)) return false;

	// Therow a new error exception mapping the arguments accordingly
	throw new \ErrorException($message, 0, $type, $file, $line);	
}

// ===========================================================================
// ERROR DISPLAY - Shows errors based on environment
// ===========================================================================

/**
 * Display error message based on environment and request type
 *
 * - Development: Shows detailed error with stack trace
 * - Production: Shows generic error page (hides sensitive details)
 * - Console: Outputs plain text error message
 * - Web: Loads HTML error page template
 *
 * Safety:
 *   - Checks if error template exists before including
 *   - Falls back to plain HTML if template missing or broken
 *   - Prevents blank page if error handler itself fails
 *
 * @param string $showError HTML-formatted error message for display
 * @param string $logError Plain text error message
 * @return void
 */
function displayError($message, $settings)
{
	// Clear any output buffers to prevent partial rendering
	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	$title 	= $settings['title'];

	header_remove();
    header('Content-Type: text/html; charset=utf-8');
    header('HTTP/1.1 500 Internal Server Error');

	//set HTTP 500 error code (works in both web and CLI/testing)
	http_response_code(500);

	// Path to error page template
	$template = __DIR__ . '/View.php';
	$customTpl= $settings['root'] . '/application/views/500.php';

	// For Roline CLI just echo the entire error message
	// if($isConsole) echo $message;
	if(defined('ROLINE_INSTANCE')) echo $message;
	
	// PRODUCTION ENVIRONMENT - Hide detailed errors
	else if(DEV == false){
		
		// Web: Show generic error page
		$hideError 	= true;

		// Try to load template, fallback to plain HTML if missing
		if (file_exists($customTpl)) include $customTpl;
		else if (file_exists($template)) include $template;
		else
		{

// Fallback: simple HTML error page

echo <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <title>500 Internal Server Error</title>
            <style>
                body { font-family: sans-serif; background: #f8fafc; color: #1e293b; padding: 40px; text-align: center; }
                .card { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border-top: 4px solid #ef4444; text-align: left; }
                h1 { font-size: 24px; margin-top: 0; color: #0f172a; }
                pre { background: #f1f5f9; padding: 15px; border-radius: 4px; font-size: 13px; overflow-x: auto; white-space: pre-wrap; }
            </style>
        </head>
        <body>
            <div class="card">
                <h1>An Application Error Occurred</h1>
                <p><strong>Message:</strong> The application encountered an error. Please contact the administrator:</p>
            </div>
        </body>
        </html>
HTML;
    	}
	}

	// DEVELOPMENT ENVIRONMENT - Show detailed errors
	else {
		// Web: Show detailed error page
		$hideError = false;

		// Try to load template, fallback to plain HTML if missing
		if (file_exists($customTpl)) include $customTpl;
		else if (file_exists($template)) include $template;
		else
		{
			
// Fallback: show error directly with warning about missing template

echo <<<HTML
	<!DOCTYPE html>
	<html>
	<head>
		<title>500 Internal Server Error</title>
		<style>
			body { font-family: sans-serif; background: #f8fafc; color: #1e293b; padding: 40px; text-align: center; }
			.card { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border-top: 4px solid #ef4444; text-align: left; }
			h1 { font-size: 24px; margin-top: 0; color: #0f172a; }
			pre { background: #f1f5f9; padding: 15px; border-radius: 4px; font-size: 13px; overflow-x: auto; white-space: pre-wrap; }
		</style>
	</head>
	<body>
		<div class="card">
			<h1>Internal Server Error</h1>
			<p><strong>Message:</strong> Error template missing: {$template}</p>
			<pre>{$message}</pre>
		</div>
	</body>
	</html>
HTML;
    	}				
	}

	// Stop code execution completely
	exit(1);
}
