<?php 
/**
 * Store PHP Session configuration
 * 
 * Use this to set session duration and other configuration necessary
 * for running secure PHP sessions for persitent cookies.
 * It links the server's session logic with the browser's cookie storage.
 * 
 */
return array(

    /**
     * The duration the cookie should last in seconds. 
     * Setting it to 0 makes the cookie a "session cookie" that expires when the browser is closed
     */ 
    'cookie_lifetime'  => 60 * 60 * 24 * 14, 

    /**
     * The duraation the sessions lasts in seconds.
     * It affects how long the Cookie session lasts on the server. Should have the same value as cookie_lifetime
     */
    'gc_maxlifetime'    => 60 * 60 * 24 * 14,

    /**
     * The path on the server where the cookie will be available. 
     * Using '/' makes it available for all paths on the domain.     * 
     */ 
    'cookie_path'      => '/',

    /**
     * The cookie's domain. To make it accessible across all subdomains 
     * (e.g., www.example.com and news.example.com), prefix the domain with a dot, like '.example.com'
     */
    'cookie_domain'    => '',

    /**
     * If true, the cookie will only be sent over secure (HTTPS) connections
     */
    'cookie_secure'    => true,

    /**
     * If true, the cookie cannot be accessed by client-side scripts 
     * (like JavaScript), which helps mitigate XSS attacks
     */
    'cookie_httponly'  => true,

    /**
     * The value should be 'Lax' or 'Strict'. This provides protection against
     * Cross-Site Request Forgery (CSRF) attacks.
     */
    'cookie_samesite'  => true
);