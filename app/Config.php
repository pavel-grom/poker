<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 16:29
 */

namespace App;


class Config
{
    /**
     * @var array $data
     * */
    private $data;

    /**
     * @var self $instance
     * */
    private static $instance;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->data = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
    }

    /**
     * @return Config
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * @return null
     */
    private function __clone()
    {
        return null;
    }
}