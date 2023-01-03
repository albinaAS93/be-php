<?php

class User {

    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function create(array $data)
    {
        $sql = "
            INSERT INTO users (name, username, password) 
            VALUES (:name, :username, :password);
        ";

        $stmt = $this->pdo->openConnection()->prepare($sql);

        // $hash =  password_hash($data['password'], PASSWORD_DEFAULT);

        $param = array(
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => hash("sha1", $data['password'])
        );

        if ($stmt->execute($param)) {
            return true;
        }
    }

    function selectAll()
    {
        $sql = "
            SELECT users.name, users.username, users.password
            FROM users;
        ";

        $stmt = $this->pdo->openConnection()->prepare($sql);

        $stmt->execute();

        if ($stmt->execute()) {
            $rows = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return $stmt;
        }
    }

    function login(array $data)
    {
        $sql = "
            SELECT username, password 
            FROM users 
            WHERE username = :username and password = :password
        ";

        $stmt = $this->pdo->openConnection()->prepare($sql);
    
        $param = array(
            'username' => $data['username'],
            'password' => hash("sha1", $data['password'])
        );

        if ($data['password']) {

            $stmt->execute($param);

            if ($stmt->execute($param)) {
                $rows = array();
                while ((($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false)) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                return false;
            }        
        }
    }
}