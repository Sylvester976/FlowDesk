<?php

// Add this to config/services.php

return [

    // ... existing services (mail, etc) ...

    /*
    |──────────────────────────────────────────────────────────
    | User Service
    |──────────────────────────────────────────────────────────
    | Central identity provider. FlowDesk delegates auth to
    | this service and falls back to local if unavailable.
    */
    'user_service' => [
        'url'        => env('USER_SERVICE_URL', ''),
        'api_key'    => env('USER_SERVICE_API_KEY', ''),
        'timeout'    => env('USER_SERVICE_TIMEOUT', 5),
        'public_key' => env('USER_SERVICE_PUBLIC_KEY', ''),
        'fallback'   => env('USER_SERVICE_FALLBACK', true), // fall back to local auth if down
    ],

];
