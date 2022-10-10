<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/uploads',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),

            // 基于基础的身份验证设置...
            'username' => env('SFTP_USERNAME'),

            // 使用加密密码进行基于 SSH 密钥的身份验证的设置...
            'privateKey' => env('SFTP_PRIVATE_KEY'),

            'password' => env('SFTP_PASSWORD'),
            // 可选的 SFTP 设置
            'port' => env('SFTP_PORT', 22),
            'root' => env('SFTP_ROOT', ''),
            'url' => env('SFTP_URL'),
            'timeout' => 30,
            'throw' => false,
        ],

        'ftp' => [
            'driver' => 'ftp',
            'host' => env('FTP_HOST'),
            'username' => env('FTP_USERNAME'),
            'password' => env('FTP_PASSWORD'),

            // 可选的 FTP 设置
            'port' => env('FTP_PORT', 21),
            'root' => env('FTP_ROOT'),
            'url' => env('FTP_URL'),
            'passive' => env('FTP_IS_PASSIVE', true),
            'ssl' => true,
            'timeout' => 30,
            'throw' => false,
        ],

        'oss' => [
            'driver' => 'oss',
            'root' => '',
            'access_key_id' => env('OSS_ACCESS_KEY_ID'),
            'access_key_secret' => env('OSS_ACCESS_KEY_SECRET'),
            'bucket' => env('OSS_BUCKET'),
            'endpoint' => env('OSS_ENDPOINT'),
            'is_cname' => env('OSS_IS_CNAME', false),
            'security_token' => env('OSS_SECURITY_TOKEN'),
            'throw' => false,
        ],

        'cos' => [
            'driver' => 'cos',

            'app_id' => env('COS_APP_ID'),
            'secret_id' => env('COS_SECRET_ID'),
            'secret_key' => env('COS_SECRET_KEY'),
            'region' => env('COS_REGION', 'ap-guangzhou'),

            'bucket' => env('COS_BUCKET'),  // 不带数字 app_id 后缀

            // 可选，如果 bucket 为私有访问请打开此项
            'signed_url' => false,

            // 可选，是否使用 https，默认 false
            'use_https' => true,

            // 可选，自定义域名
            'domain' => env('COS_DOMAIN', 'emample-12340000.cos.test.com'),

            // 可选，使用 CDN 域名时指定生成的 URL host
            'cdn' => env('COS_CDN'),

            'prefix' => env('COS_PATH_PREFIX'), // 全局路径前缀

            'guzzle' => [
                'timeout' => env('COS_TIMEOUT', 60),
                'connect_timeout' => env('COS_CONNECT_TIMEOUT', 60),
            ],

            'throw' => false,
        ],

        'qiniu' => [
            'driver' => 'qiniu',
            'access_key' => env('QINIU_ACCESS_KEY', 'xxxxxxxxxxxxxxxx'),
            'secret_key' => env('QINIU_SECRET_KEY', 'xxxxxxxxxxxxxxxx'),
            'bucket' => env('QINIU_BUCKET', 'test'),
            'domain' => env('QINIU_DOMAIN', 'xxx.clouddn.com'), // or host: https://xxxx.clouddn.com
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('uploads') => storage_path('app/public'),
    ],

];
