<?php

/**
 *
 * @property string siteName
 * @property string bannersPath
 * @property App $site
 * @property PDO $db
 */
class App
{
    private static $instance;

    /**
     * @var mixed
     */
    public $config;

    public $db;


    /**
     *
     */
    public function __construct()
    {
        $this->config = require_once BASE_PATH . '/config/main.php';
        $this->dbConnect();
    }

    private function dbConnect()
    {
        $connect = str_replace([':hostname', ':dbname', ':port'],
            [$this->config['db']['host'], $this->config['db']['dbname'], $this->config['db']['port']],
            'mysql:host=:hostname;dbname=:dbname;port=:port'
        );
        $this->db = new PDO($connect, $this->config['db']['user'],
            $this->config['db']['password']);
    }


    public function onRequest(){
        if(in_array(substr($_SERVER['SCRIPT_NAME'], 1), ['index.php', 'index1.php', 'index2.php'])){
            VisitorHelper::updateOrCreate();
        }
    }


    /**
     * @param $name
     *
     * @return mixed|void
     */
    public function __get($name)
    {
        if(isset($this->config[$name])){
            return $this->config[$name];
        }
    }

    /**
     * @return \App
     */
    public static function site()
    {
        if (!isset(self::$instance)) {
            self::$instance = new App();
            self::$instance->onRequest();
        }

        return self::$instance;
    }

    /**
     * @return mixed|string|void
     */
    public function getTitle()
    {
        $title = $this->siteName;
        if (!empty($this->config['pages'][$_SERVER['SCRIPT_NAME']])) {
            $title .= ' - ' . $this->config['pages'][$_SERVER['SCRIPT_NAME']];
        } else {
            $title .= ' - ' .substr($_SERVER['SCRIPT_NAME'], 1);
        }


        return $title;
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

}