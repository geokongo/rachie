<?php 

/**
 * Returns the current security configuration for your application.
 * 
 * Security configuration includes your settings for CSP (Content-Security-Policy)
 * CORS (Cross-Origin-Resource-Sharing), and IP Blacklists.
 * 
 * Used by \Rackage\Security; to set the correct headers
 */
return [

    /**
     * Set Content Security Policy headers
     *
     * CSP helps prevent XSS attacks by controlling which resources
     * the browser can load (scripts, styles, images, etc.).
     *
     * Default policy is restrictive - only allows resources from same origin.
     * Customize by passing policy directives as array.
     *
     * Examples:
     * 
     *   // Allow external scripts and styles
     *       'script-src'   => "'self' https://cdn.example.com",
     *       'style-src'    => "'self' 'unsafe-inline' https://fonts.googleapis.com"
     *
     *   // Allow inline scripts (less secure, use sparingly)
     *       'script-src' => "'self' 'unsafe-inline'"
     *
     * Common directives:
     *   - default-src: Fallback for all resource types
     *   - script-src:  JavaScript sources
     *   - style-src:   CSS sources
     *   - img-src:     Image sources
     *   - connect-src: AJAX/WebSocket sources
     *   - font-src:    Font sources
     *   - frame-ancestors: Who can embed this page in iframe
     */
    'Content-Security-Policy' => [
        'enabled'    => true,
        'report-only'=> false, // Set to true during development to log errors instead of blocking
        'directives' => [
            'default-src'   => "'self'",
            // Allows standard inline scripts (like analytics/trackers)  and eval()
            'script-src'    => "'self' 'unsafe-inline' 'unsafe-eval' https:",

             // Allows frameworks like Tailwind or Bootstrap via CDN
            'style-src'     => "'self' 'unsafe-inline' https:",

            // Allows hot-linking from any secure site or Base64 images
            'img-src'       => "'self' data: https:",

             // Allows Google Fonts out of the box
            'font-src'      => "'self' data: https:",

            // Allows AJAX/Fetch requests to external APIs
            'connect-src'   => "'self' https:",
            'base-uri'      => "'self'",
            'form-action'   => "'self'"
        ],        
    ],    
    
    /**
     * Set CORS headers for cross-origin requests
     *
     * CORS (Cross-Origin Resource Sharing) allows controlled access
     * to resources from different domains.
     *
     * Examples:
     *   // Allow specific origins
     *  'origins' => ['https://app.example.com', 'https://mobile.example.com']
     *
     *   // Allow all origins (use with caution!)
     *  'origins' => ['*']
     *
     */
    'Cross-Origin-Resource-Sharing' => [
        'origins' => [
            '*',
            // 'https://app.example.com', 
            // 'https://mobile.example.com',
        ],
        'options' => [
            'methods'       => 'GET, POST, PUT, DELETE, OPTIONS',
            'headers'       => 'Content-Type, Authorization, X-CSRF-TOKEN, X-Requested-With',
            'credentials'   => true,
            'max_age'       => 86400
        ]
    ],
    'IP-Blacklist' => [
        // '192.168.0.1',
        // '10.10.10.10',
    ],
    // Whether to allow others to load your application inside iframes
    // 'sameorigin' only your domain 'deny' no domain, 'allow' all domains
    'framing_policy'   => 'sameorigin', 
    
    // Send root domain only to external site
    'referrer_policy'  => 'strict-origin-when-cross-origin', 
    // Send full URL to external site
    // 'referrer_policy'  => 'no-referrer-when-downgrade',   
];