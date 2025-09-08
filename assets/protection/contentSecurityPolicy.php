<?php

// Content Security Policy selon architecture security-first
$cspDirectives = [
    'default-src' => "'self'",
    'script-src' => "'self' 'unsafe-inline' cdn.jsdelivr.net kit.fontawesome.com ka-f.fontawesome.com",
    'style-src' => "'self' 'unsafe-inline' cdn.jsdelivr.net kit.fontawesome.com ka-f.fontawesome.com", 
    'font-src' => "'self' cdn.jsdelivr.net kit.fontawesome.com ka-f.fontawesome.com *.fontawesome.com",
    'img-src' => "'self' data: cdn.jsdelivr.net",
    'connect-src' => "'self' kit.fontawesome.com ka-f.fontawesome.com"
];

// Construction du header CSP sur une seule ligne
$csp = "Content-Security-Policy: ";
$policies = [];
foreach ($cspDirectives as $directive => $sources) {
    $policies[] = $directive . ' ' . $sources;
}
$csp .= implode('; ', $policies) . ';';

header($csp);