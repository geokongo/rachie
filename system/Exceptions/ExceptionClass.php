<?php namespace Exceptions;

/**
 * Base Exception Handler
 *
 * All application exceptions extend this class.
 * Provides unified error handling with logging, dev/prod modes, and custom error pages.
 *
 * Features:
 *   - Error logging to file (vault/logs/error.log)
 *   - Development mode: Shows detailed error messages with stack traces
 *   - Production mode: Shows generic error page, hides sensitive details
 *   - Custom error page templates
 *   - Stack trace formatting and path sanitization
 *
 * Usage:
 *   class DatabaseException extends \Exceptions\ExceptionClass {}
 *   class RouteException extends \Exceptions\ExceptionClass {}
 *
 *   throw new DatabaseException("Connection failed");
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright 2015 - 2030 Geoffrey Okongo
 * @category Core
 * @package Core\Exceptions
 * @link https://github.com/glivers/rachie
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 2.0.1
 */
 
class ExceptionClass extends \Exception {}
