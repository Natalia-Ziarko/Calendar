<?php
define('_SERVER_NAME', 'localhost');
define('_SERVER_URL', 'http://'._SERVER_NAME);
define('_APP_ROOT', '/calendar');
define('_APP_URL', _SERVER_URL._APP_ROOT);
define("_ROOT_PATH", dirname(__FILE__));

class Config extends \ArrayObject {
    public $db_type;
    public $db_server;
    public $db_name;
    public $db_user;
    public $db_pass;
    public $db_charset;
}

$conf = new Config();

$conf->db_type = 'mysql';
$conf->db_server = 'localhost';
$conf->db_name = 'sports_events_calendar';
$conf->db_user = 'root';
$conf->db_pass = 'root';
$conf->db_charset = 'utf8';

class Database {
    private static $db;
    private static $config;

    public static function init($config) {
        self::$config = $config;
    }

    public static function connectDB() {
        if (!isset(self::$db)) {
            try {
                $dsn = self::$config->db_type . ':host=' . self::$config->db_server . ';dbname=' . self::$config->db_name . ';charset=' . self::$config->db_charset;

                self::$db = new PDO($dsn, self::$config->db_user, self::$config->db_pass);

                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (PDOException $e) {
                die('Connection with database failed:<br>' . $e->getMessage());
            }
        }
        return self::$db;
    }
}

Database::init($conf);
$db = Database::connectDB();