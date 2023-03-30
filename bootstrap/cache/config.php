<?php return array (
  'activitylog' => 
  array (
    'enabled' => true,
    'delete_records_older_than_days' => 365,
    'default_log_name' => 'default',
    'default_auth_driver' => NULL,
    'subject_returns_soft_deleted_models' => false,
    'activity_model' => 'Spatie\\Activitylog\\Models\\Activity',
    'table_name' => 'activity_log',
    'database_connection' => NULL,
  ),
  'app' => 
  array (
    'name' => 'Agent WL',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://agentwl.raymond',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:P4cWhX4xwrsEaakaE7YBt4Z9JrbfmDwH9JHfrNaJ1bA=',
    'cipher' => 'AES-256-CBC',
    'developer_tool_disable' => false,
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\AuthServiceProvider',
      25 => 'App\\Providers\\BroadcastServiceProvider',
      26 => 'App\\Providers\\ComposerServiceProvider',
      27 => 'App\\Providers\\EventServiceProvider',
      28 => 'App\\Providers\\HelperServiceProvider',
      29 => 'App\\Providers\\LocaleServiceProvider',
      30 => 'App\\Providers\\ObserverServiceProvider',
      31 => 'App\\Providers\\RouteServiceProvider',
      32 => 'PragmaRX\\Firewall\\Vendor\\Laravel\\ServiceProvider',
      33 => 'Jenssegers\\Agent\\AgentServiceProvider',
      34 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Firewall' => 'PragmaRX\\Firewall\\Vendor\\Laravel\\Facade',
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
      'Agent' => 'Jenssegers\\Agent\\Facades\\Agent',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'jwt',
        'provider' => 'members',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Domains\\Auth\\Models\\User',
        'table' => 'users',
      ),
      'members' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\MembersModel',
        'table' => 'members',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'boilerplate' => 
  array (
    'access' => 
    array (
      'captcha' => 
      array (
        'registration' => false,
        'login' => false,
      ),
      'middleware' => 
      array (
        'confirm' => 'password.confirm:frontend.auth.password.confirm',
        'verified' => 'verified:frontend.auth.verification.notice',
      ),
      'user' => 
      array (
        'admin_requires_2fa' => false,
        'change_email' => true,
        'only_roles' => false,
        'password_expires_days' => '180',
        'password_history' => '3',
        'permanently_delete' => false,
        'registration' => false,
        'single_login' => false,
      ),
      'role' => 
      array (
        'admin' => 'Administrator',
      ),
    ),
    'avatar' => 
    array (
      'size' => 80,
    ),
    'frontend_breadcrumbs' => true,
    'google_analytics' => 'UA-XXXXX-X',
    'locale' => 
    array (
      'status' => true,
      'languages' => 
      array (
        'ar' => 
        array (
          'name' => 'Arabic',
          'rtl' => true,
        ),
        'az' => 
        array (
          'name' => 'Azerbaijan',
          'rtl' => false,
        ),
        'zh' => 
        array (
          'name' => 'Chinese Simplified',
          'rtl' => false,
        ),
        'zh-TW' => 
        array (
          'name' => 'Chinese Traditional',
          'rtl' => false,
        ),
        'cs' => 
        array (
          'name' => 'Czech',
          'rtl' => false,
        ),
        'da' => 
        array (
          'name' => 'Danish',
          'rtl' => false,
        ),
        'de' => 
        array (
          'name' => 'German',
          'rtl' => false,
        ),
        'el' => 
        array (
          'name' => 'Greek',
          'rtl' => false,
        ),
        'en' => 
        array (
          'name' => 'English',
          'rtl' => false,
        ),
        'es' => 
        array (
          'name' => 'Spanish',
          'rtl' => false,
        ),
        'fa' => 
        array (
          'name' => 'Persian',
          'rtl' => true,
        ),
        'fr' => 
        array (
          'name' => 'French',
          'rtl' => false,
        ),
        'he' => 
        array (
          'name' => 'Hebrew',
          'rtl' => true,
        ),
        'id' => 
        array (
          'name' => 'Indonesian',
          'rtl' => false,
        ),
        'it' => 
        array (
          'name' => 'Italian',
          'rtl' => false,
        ),
        'ja' => 
        array (
          'name' => 'Japanese',
          'rtl' => false,
        ),
        'nl' => 
        array (
          'name' => 'Dutch',
          'rtl' => false,
        ),
        'no' => 
        array (
          'name' => 'Norwegian',
          'rtl' => false,
        ),
        'pt_BR' => 
        array (
          'name' => 'Brazilian Portuguese',
          'rtl' => false,
        ),
        'ru' => 
        array (
          'name' => 'Russian',
          'rtl' => false,
        ),
        'sv' => 
        array (
          'name' => 'Swedish',
          'rtl' => false,
        ),
        'th' => 
        array (
          'name' => 'Thai',
          'rtl' => false,
        ),
        'tr' => 
        array (
          'name' => 'Turkish',
          'rtl' => false,
        ),
        'uk' => 
        array (
          'name' => 'Ukrainian',
          'rtl' => false,
        ),
      ),
    ),
    'testing' => false,
  ),
  'broadcasting' => 
  array (
    'default' => 'pusher',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '7003e049734c1e0f19e9',
        'secret' => 'c176dcdcb7232fdf46c9',
        'app_id' => '1507303',
        'options' => 
        array (
          'cluster' => 'ap1',
          'encrypted' => true,
          'useTLS' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'agent_wl_cache',
  ),
  'cikatechMaster' => 
  array (
    'url_check_maintenance_agent' => 'https://cikatechmaster-old.cktch.top/api/status-maintenance-agent',
    'agent_ip' => '128.199.163.72',
    'agent_name' => 'Cikaslot',
    'secret_url' => 'Cikatech',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
      0 => '*',
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
      0 => '*',
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'agent_old',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'staging-database-do-user-8181229-0.b.db.ondigitalocean.com',
        'port' => '25060',
        'database' => 'agent_old',
        'username' => 'stagingcikatech',
        'password' => 'AVNS_bdf4EP2uIjuG6Rq9Qxl',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => false,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'dbMemberPanel' => 
      array (
        'driver' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge',
        'username' => 'forge',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'staging-database-do-user-8181229-0.b.db.ondigitalocean.com',
        'port' => '25060',
        'database' => 'agent_old',
        'username' => 'stagingcikatech',
        'password' => 'AVNS_bdf4EP2uIjuG6Rq9Qxl',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 
        array (
          0 => 'public',
          1 => 'public',
        ),
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'staging-database-do-user-8181229-0.b.db.ondigitalocean.com',
        'port' => '25060',
        'database' => 'agent_old',
        'username' => 'stagingcikatech',
        'password' => 'AVNS_bdf4EP2uIjuG6Rq9Qxl',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'cluster' => false,
      'clusters' => 
      array (
        'default' => 
        array (
          0 => 
          array (
            'scheme' => 'tcp',
            'host' => 'localhost',
            'password' => NULL,
            'port' => '6379',
            'database' => 0,
          ),
        ),
        'options' => 
        array (
          'cluster' => 'redis',
        ),
      ),
      'options' => 
      array (
        'parameters' => 
        array (
          'password' => NULL,
          'scheme' => 'tcp',
        ),
        'ssl' => 
        array (
          'verify_peer' => false,
        ),
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'public',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app/public',
        'url' => 'http://agentwl.raymond/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
      ),
    ),
    'links' => 
    array (
      'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\public\\storage' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app/public',
    ),
  ),
  'firewall' => 
  array (
    'enabled' => false,
    'blacklist' => 
    array (
    ),
    'whitelist' => 
    array (
    ),
    'responses' => 
    array (
      'blacklist' => 
      array (
        'code' => 403,
        'message' => NULL,
        'view' => NULL,
        'redirect_to' => 'https://youtube.com',
        'abort' => false,
      ),
      'whitelist' => 
      array (
        'code' => 403,
        'message' => NULL,
        'view' => NULL,
        'redirect_to' => NULL,
        'abort' => false,
      ),
    ),
    'redirect_non_whitelisted_to' => NULL,
    'cache_expire_time' => 0,
    'ip_list_cache_expire_time' => 0,
    'enable_log' => true,
    'log_stack' => NULL,
    'enable_range_search' => true,
    'enable_country_search' => false,
    'use_database' => true,
    'firewall_model' => '\\App\\Models\\AdminIpModel',
    'session_binding' => 'session',
    'geoip_database_path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\config/geoip',
    'attack_blocker' => 
    array (
      'enabled' => 
      array (
        'ip' => true,
        'country' => false,
      ),
      'cache_key_prefix' => 'firewall-attack-blocker',
      'allowed_frequency' => 
      array (
        'ip' => 
        array (
          'requests' => 50,
          'seconds' => 60,
        ),
        'country' => 
        array (
          'requests' => 3000,
          'seconds' => 120,
        ),
      ),
      'action' => 
      array (
        'ip' => 
        array (
          'blacklist_unknown' => true,
          'blacklist_whitelisted' => false,
        ),
        'country' => 
        array (
          'blacklist_unknown' => false,
          'blacklist_whitelisted' => false,
        ),
      ),
      'response' => 
      array (
        'code' => 403,
        'message' => NULL,
        'view' => NULL,
        'redirect_to' => NULL,
        'abort' => false,
      ),
    ),
    'notifications' => 
    array (
      'enabled' => true,
      'message' => 
      array (
        'title' => 'User agent',
        'message' => 'A possible attack on \'%s\' has been detected from %s',
        'request_count' => 
        array (
          'title' => 'Request count',
          'message' => 'Received %s requests in the last %s seconds. Timestamp of first request: %s',
        ),
        'uri' => 
        array (
          'title' => 'First URI offended',
        ),
        'blacklisted' => 
        array (
          'title' => 'Was it blacklisted?',
        ),
        'user_agent' => 
        array (
          'title' => 'User agent',
        ),
        'geolocation' => 
        array (
          'title' => 'Geolocation',
          'field_latitude' => 'Latitude',
          'field_longitude' => 'Longitude',
          'field_country_code' => 'Country code',
          'field_country_name' => 'Country name',
          'field_city' => 'City',
        ),
      ),
      'route' => '',
      'from' => 
      array (
        'name' => 'Laravel Firewall',
        'address' => 'firewall@mydomain.com',
        'icon_emoji' => ':fire:',
      ),
      'users' => 
      array (
        'model' => 'PragmaRX\\Firewall\\Vendor\\Laravel\\Models\\User',
        'emails' => 
        array (
          0 => 'admin@mydomain.com',
        ),
      ),
      'channels' => 
      array (
        'slack' => 
        array (
          'enabled' => true,
          'sender' => 'PragmaRX\\Firewall\\Notifications\\Channels\\Slack',
        ),
        'mail' => 
        array (
          'enabled' => true,
          'sender' => 'PragmaRX\\Firewall\\Notifications\\Channels\\Mail',
        ),
      ),
    ),
  ),
  'geoip' => 
  array (
    'log_failures' => true,
    'include_currency' => true,
    'service' => 'ipapi',
    'services' => 
    array (
      'maxmind_database' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\MaxMindDatabase',
        'database_path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app/geoip.mmdb',
        'update_url' => 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=&suffix=tar.gz',
        'locales' => 
        array (
          0 => 'en',
        ),
      ),
      'maxmind_api' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\MaxMindWebService',
        'user_id' => NULL,
        'license_key' => NULL,
        'locales' => 
        array (
          0 => 'en',
        ),
      ),
      'ipapi' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\IPApi',
        'secure' => true,
        'key' => NULL,
        'continent_path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app/continents.json',
        'lang' => 'en',
      ),
      'ipgeolocation' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\IPGeoLocation',
        'secure' => true,
        'key' => NULL,
        'continent_path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\app/continents.json',
        'lang' => 'en',
      ),
      'ipdata' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\IPData',
        'key' => NULL,
        'secure' => true,
      ),
      'ipfinder' => 
      array (
        'class' => 'Torann\\GeoIP\\Services\\IPFinder',
        'key' => NULL,
        'secure' => true,
        'locales' => 
        array (
          0 => 'en',
        ),
      ),
    ),
    'cache' => 'none',
    'cache_tags' => 
    array (
    ),
    'cache_expires' => 30,
    'default_location' => 
    array (
      'ip' => '127.0.0.0',
      'iso_code' => 'US',
      'country' => 'United States',
      'city' => 'New Haven',
      'state' => 'CT',
      'state_name' => 'Connecticut',
      'postal_code' => '06510',
      'lat' => 41.31,
      'lon' => -72.92,
      'timezone' => 'America/New_York',
      'continent' => 'NA',
      'default' => true,
      'currency' => 'USD',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'htmlminify' => 
  array (
    'default' => true,
  ),
  'jwt' => 
  array (
    'secret' => 'KKAk7XIpuXqDa45ickX71IGnxpvoXYYyx3keILG2m64Z13ynVaa475kkJodgK3oM',
    'keys' => 
    array (
      'public' => NULL,
      'private' => NULL,
      'passphrase' => NULL,
    ),
    'ttl' => 60,
    'refresh_ttl' => 20160,
    'algo' => 'HS256',
    'required_claims' => 
    array (
      0 => 'iss',
      1 => 'iat',
      2 => 'exp',
      3 => 'nbf',
      4 => 'sub',
      5 => 'jti',
    ),
    'persistent_claims' => 
    array (
    ),
    'lock_subject' => true,
    'leeway' => 0,
    'blacklist_enabled' => true,
    'blacklist_grace_period' => 0,
    'decrypt_cookies' => false,
    'providers' => 
    array (
      'jwt' => 'Tymon\\JWTAuth\\Providers\\JWT\\Lcobucci',
      'auth' => 'Tymon\\JWTAuth\\Providers\\Auth\\Illuminate',
      'storage' => 'Tymon\\JWTAuth\\Providers\\Storage\\Illuminate',
    ),
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\resources\\views/livewire',
    'layout' => 'layouts.app',
    'asset_url' => NULL,
    'app_url' => NULL,
    'middleware_group' => 'web',
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
    ),
    'manifest_path' => NULL,
    'back_button_cache' => false,
    'render_on_redirect' => false,
  ),
  'lockout' => 
  array (
    'enabled' => false,
    'allow_login' => true,
    'login_path' => 'login',
    'logout_path' => 'logout',
    'locked_types' => 
    array (
      0 => 'post',
      1 => 'put',
      2 => 'patch',
      3 => 'delete',
    ),
    'pages' => 
    array (
    ),
    'whitelist' => 
    array (
      'post' => 'password/confirm',
    ),
  ),
  'logging' => 
  array (
    'default' => 'daily',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\logs/laravel.log',
      ),
      'endpoint' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\logs/endpoint.log',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'smtp.mailtrap.io',
        'port' => '2525',
        'encryption' => NULL,
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
    ),
    'from' => 
    array (
      'address' => NULL,
      'name' => 'Agent WL',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'App\\Domains\\Auth\\Models\\Permission',
      'role' => 'App\\Domains\\Auth\\Models\\Role',
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' => 
    array (
      'model_morph_key' => 'model_id',
    ),
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => 
    array (
      'expiration_time' => 
      DateInterval::__set_state(array(
         'y' => 0,
         'm' => 0,
         'd' => 0,
         'h' => 24,
         'i' => 0,
         's' => 0,
         'f' => 0.0,
         'weekday' => 0,
         'weekday_behavior' => 0,
         'first_last_day_of' => 0,
         'invert' => 0,
         'days' => false,
         'special_type' => 0,
         'special_amount' => 0,
         'have_weekday_relative' => 0,
         'have_special_relative' => 0,
      )),
      'key' => 'spatie.permission.cache',
      'model_key' => 'name',
      'store' => 'default',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'suffix' => NULL,
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sentry' => 
  array (
    'dsn' => NULL,
    'environment' => NULL,
    'breadcrumbs' => 
    array (
      'logs' => true,
      'sql_queries' => true,
      'sql_bindings' => true,
      'queue_info' => true,
      'command_info' => true,
    ),
    'tracing' => 
    array (
      'queue_job_transactions' => false,
      'queue_jobs' => true,
      'sql_queries' => true,
      'sql_origin' => true,
      'views' => true,
      'default_integrations' => true,
    ),
    'send_default_pii' => false,
    'traces_sample_rate' => 0.0,
    'controllers_base_namespace' => 'App\\Http\\Controllers',
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'bitbucket' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'facebook' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'github' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'google' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'linkedin' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'twitter' => 
    array (
      'active' => false,
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'member' => 
    array (
      'url' => 'https://cikaslot.com',
    ),
    'api' => 
    array (
      'secret' => 'cikatech',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'agent_wl_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'timezone' => 
  array (
    'flash' => 'off',
    'overwrite' => true,
    'format' => 'l, F jS Y, g:i A T',
    'lookup' => 
    array (
      'server' => 
      array (
        0 => 'REMOTE_ADDR',
      ),
      'headers' => 
      array (
      ),
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\resources\\views',
    ),
    'compiled' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\framework\\views',
  ),
  'debugbar' => 
  array (
    'enabled' => true,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api\\storage\\debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => false,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'duration_background' => true,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => false,
        'show_copy' => false,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'timeline' => false,
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'laraguard' => 
  array (
    'listener' => 'DarkGhostHunter\\Laraguard\\Listeners\\EnforceTwoFactorAuth',
    'model' => 'DarkGhostHunter\\Laraguard\\Eloquent\\TwoFactorAuthentication',
    'input' => '2fa_code',
    'cache' => 
    array (
      'store' => NULL,
      'prefix' => '2fa.code',
    ),
    'recovery' => 
    array (
      'enabled' => true,
      'codes' => 10,
      'length' => 8,
    ),
    'safe_devices' => 
    array (
      'enabled' => false,
      'max_devices' => 3,
      'expiration_days' => 14,
    ),
    'confirm' => 
    array (
      'timeout' => 10800,
      'view' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@showConfirmForm',
      'action' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@confirm',
    ),
    'secret_length' => 20,
    'issuer' => NULL,
    'totp' => 
    array (
      'digits' => 6,
      'seconds' => 30,
      'window' => 1,
      'algorithm' => 'sha1',
    ),
    'qr_code' => 
    array (
      'size' => 400,
      'margin' => 4,
    ),
  ),
  'flare' => 
  array (
    'key' => NULL,
    'reporting' => 
    array (
      'anonymize_ips' => true,
      'collect_git_information' => false,
      'report_queries' => true,
      'maximum_number_of_collected_queries' => 200,
      'report_query_bindings' => true,
      'report_view_data' => true,
      'grouping_type' => NULL,
      'report_logs' => true,
      'maximum_number_of_collected_logs' => 200,
      'censor_request_body_fields' => 
      array (
        0 => 'password',
      ),
    ),
    'send_logs_as_events' => true,
    'censor_request_body_fields' => 
    array (
      0 => 'password',
    ),
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'light',
    'enable_share_button' => true,
    'register_commands' => false,
    'ignored_solution_providers' => 
    array (
      0 => 'Facade\\Ignition\\SolutionProviders\\MissingPackageSolutionProvider',
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
  ),
  'laravel-impersonate' => 
  array (
    'session_key' => 'impersonated_by',
    'session_guard' => 'impersonator_guard',
    'session_guard_using' => 'impersonator_guard_using',
    'default_impersonator_guard' => 'web',
    'take_redirect_to' => '/',
    'leave_redirect_to' => '/',
  ),
  'livewire-tables' => 
  array (
    'theme' => 'tailwind',
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper.php',
    'models_filename' => '_ide_helper_models.php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_external_builder_methods' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => 'C:\\Users\\Developer\\MEMBER-API\\agent-rest-api\\agent-rest-api/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'model_hooks' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
    'force_fqn' => false,
    'use_generics_annotations' => true,
    'additional_relation_types' => 
    array (
    ),
    'additional_relation_return_types' => 
    array (
    ),
    'post_migrate' => 
    array (
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
