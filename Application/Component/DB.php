<?php

namespace Application\Component;

class DB {

    protected $conn;

    public function __construct($conf) {
        $host = isset($conf['port']) ? $conf['host'] . ':' . $conf['port'] : $conf['host'];
        $this->conn = new \mysqli($host, $conf['user'], $conf['pass'], $conf['name']);
        if ($this->conn->connect_errno) {
            throw new \Exception($this->conn->connect_errno);
        }
        $this->conn->set_charset("utf8");
    }

    public function exec($query)
    {
        $this->conn->real_query($query);
    }

    public function select($query, $class)
    {
        $result = $this->conn->query($query);
        return $result->fetch_object($class);
    }

}