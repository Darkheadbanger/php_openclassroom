<?php

header(
    "Content-Security-Policy: " .
        "default-src 'self'; " .
        "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
        "font-src 'self' https://fonts.gstatic.com; " .
        "img-src 'self' data:; " .
        "connect-src 'self'"
);
