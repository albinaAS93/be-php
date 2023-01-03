<?php

    class City
    {
        protected $pdo;

        function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        function selectAll()
        {
            $sql = "SELECT cities.id, cities.name FROM cities;";
            $stmt = $this->pdo->openConnection()->prepare($sql);
            $stmt->execute();

            if ($stmt->execute()) {
                $rows = array();
                while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                return false;
            }
        }

        function create(array $data)
        {
            $sql = "INSERT INTO cities (name) VALUES (:name);";
            $stmt = $this->pdo->openConnection()->prepare($sql);
            $param = array('name' => $data['name']);
            if ($stmt->execute($param)) {
                return true;
            }
        }

        function update(array $data)
        {
            $sql = "UPDATE cities SET name = :name WHERE id = :id;";
            $stmt = $this->pdo->openConnection()->prepare($sql);
            $param = array('id' => $data['id'], 'name' => $data['name']);
            if ($stmt->execute($param)) {
                return true;
            }
        }

        function delete(array $data)
        {
            $sql = "DELETE FROM cities WHERE id = :id;";
            $stmt = $this->pdo->openConnection()->prepare($sql);
            $param = array('id' => $data['id']);
            if ($stmt->execute($param)) {
                return true;
            }
        }
    }