<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Settings
    |--------------------------------------------------------------------------
    */
    'app_name' => env('APP_NAME', 'Fleet Maintenance'),
    'version' => '1.0.0',
    'pagination' => env('APP_PAGINATION', 15),
    'timezone' => env('APP_TIMEZONE', 'Asia/Baku'),
    'locale' => env('APP_LOCALE', 'az'),

    /*
    |--------------------------------------------------------------------------
    | Role Names
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'admin' => env('ROLE_ADMIN', 'admin'),
        'bus' => env('ROLE_BUS', 'bus'),
        'complaint' => env('ROLE_COMPLAINT', 'complaint'),
        'warehouse' => env('ROLE_WAREHOUSE', 'warehouse'),
        'directorate' => env('ROLE_DIRECTORATE', 'directorate'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Colors
    |--------------------------------------------------------------------------
    */
    'status_colors' => [
        'gözləmədə' => 'warning',
        'işdə' => 'primary',
        'həll olundu' => 'success',
        'aktiv' => 'success',
        'passiv' => 'danger',
        'temir' => 'warning',
    ],

    /*
    |--------------------------------------------------------------------------
    | Complaint Types
    |--------------------------------------------------------------------------
    */
    'complaint_types' => [
        'qezali' => '🚗 Qəzalı',
        'nasazliq' => '⚠️ Nasazlıq',
        'texniki_xidmet' => '🔧 Texniki Xidmət',
    ],
];
