<?php

abstract class Dbcon{
    protected $username;
    protected $serverName;
    protected $password;
    protected $database;
    protected $conn;

    protected function connection($serverName = 'localhost', $username = 'root', $password = '', $database = 'CedCab')
    {
        $this->serverName = $serverName;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
    }

    abstract function abst();
}