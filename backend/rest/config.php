<?php 
// Set the reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));


class Config {
    public static function DB_NAME() {
        return Config::get_env("DB_NAME", "lms");
    }

    public static function DB_PORT() {
        return Config::get_env("DB_PORT", 3306);
    }

    public static function DB_USER() {
        return Config::get_env("DB_USER", 'root');
    }

    public static function DB_PASSWORD() {
        return Config::get_env("DB_PASSWORD", '?Password123');
    }

    public static function DB_HOST() {
        return Config::get_env("DB_HOST", '127.0.0.1');
    }

    public static function JWT_SECRET() {
        return Config::get_env("JWT_SECRET", 'G1}WQ/a?j,m40v,81!JDb*-j0?Aejm');
    }

    public static function get_env($name, $default) {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
}


// Database access credentials
define('DB_NAME', 'lms');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASSWORD', 'password');
define('DB_HOST', '127.0.0.1'); // localhost

// JWT Secret
define('JWT_SECRET', 'G1}WQ/a?j,m40v,81!JDb*-j0?Aejm');