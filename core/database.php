<?php

class Database
{

    protected $connection;

    public function getConnection() {
        $this->connection;
    }

    public function openConnection() 
    {
        $host = getenv('DB_HOST');
        $db_name = getenv('DB_NAME');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        try {
            $this->connection = new PDO("mysql:host=".$host.";dbname=".$db_name,$username,$password);

        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            exit;
        }

        return $this->connection;
    }
}