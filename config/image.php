<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Storage Configuration
    |--------------------------------------------------------------------------
    |
    | IMAGE_DISK_PATH: Fiziksel dosya depolama yolu (storage/app/public altında)
    | IMAGE_BASE_URL: Görsellere erişim için base URL
    |
    */

    'disk_path' => env('IMAGE_DISK_PATH', storage_path('app/public')),

    'base_url' => env('IMAGE_BASE_URL', env('APP_URL').'/storage'),

];
