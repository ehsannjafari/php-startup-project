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
            // echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function select($sql, $value = null){
        try {
            $stmt = $this->connection->prepare($sql);
            if($value == null){
                $stmt->execute();
            } else{
                $stmt->execute($value);
            }
            $result = $stmt;

            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // insert('users',['username', 'email', 'password'],['ehsan','ehsan@gmail.com', '123456'])
    public function insert($table, $fields, $values){
        try {
            $sql = "INSERT INTO" . $table . "(" . implode(', ', $fields) . ", created_at ) VALUES ( :" . implode(', :', $fields) . ", now() );";
            echo $sql;die;
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_combine($fields, $values));
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // update('users', 2, ['username', 'email', 'password'], ['ehsan','ehsan@gmail.com','12345'])
    public function update($table, $id, $fields, $values){
        $sql = "UPDATE " . $table . " SET ";
        foreach(array_combine($fields,$values) as $field => $value){
            if($value){
                $sql .= " `". $field ."` = ? ,";
            } else{
                $sql .= " `". $field ."` = NULL ,";
            }
        }
        $sql .= " updated_at = now()";
        $sql .= "WHERE id = ?";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge(array_filter(array_values($values)), [$id]));
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // delete('users', 2)
    public function delete($table, $id){
        $sql = "DELETE FROM ". $table . " WHERE id = ?";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    // createTable
    public function createTable($sql){
        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }


}