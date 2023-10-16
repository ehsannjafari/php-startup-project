<?php
namespace Database;

use PDO;
use PDOException;

class Database{
    private $connection;
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    private $dbHost = ِDB_HOST;
    private $dbName = DB_NAME;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;

    function __construct(){
        try {
            $this->connection = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}",$this->dbUsername, $this->dbPassword, $this->options);
            echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

}