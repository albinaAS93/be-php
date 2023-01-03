<?php

class Flight
{
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function selectAll()
    {
        $sql = "
            SELECT
                flights.id,
                c1.name as departure,
                c2.name as arrival,
                flights.availableSeats
            FROM flights
            LEFT JOIN cities c1 ON c1.id = flights.departure
            LEFT JOIN cities c2 ON c2.id = flights.arrival
            ORDER BY flights.availableSeats ASC;"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);
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

    function selectByCity(array $data)
    {
        $sql = "
            SELECT
                flights.id,
                c1.name as departure,
                c2.name as arrival,
                flights.availableSeats
            FROM flights
            LEFT JOIN cities c1 ON c1.id = flights.departure
            LEFT JOIN cities c2 ON c2.id = flights.arrival
            WHERE c1.name = :name OR c2.name = :name
            ;"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);
        $param = array('name' => $data['name']);

        if ($stmt->execute($param)) {
            $rows = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
    }

    function selectBySeats(array $data)
    {
        $sql = "
            SELECT
                flights.id,
                c1.name as departure,
                c2.name as arrival,
                flights.availableSeats
            FROM flights
            LEFT JOIN cities c1 ON c1.id = flights.departure
            LEFT JOIN cities c2 ON c2.id = flights.arrival
            HAVING flights.availableSeats >= :seats
            ;"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);
        $param = array('seats' => $data['availableSeats']);
        if ($stmt->execute($param)) {
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
        $sql = "
            INSERT INTO flights (departure, arrival, availableSeats) 
            VALUES (:departure, :arrival, :availableSeats)"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);

        $param = array(
            'departure' => $data['departure'],
            'arrival' => $data['arrival'],
            'availableSeats' => $data['availableSeats']
        );

        if ($stmt->execute($param)) {
            return true;
        }
    }

    function update(array $data)
    {
        $sql = "
            UPDATE flights 
            SET availableSeats = :seats 
            WHERE id = :id"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);
        $param = array('id' => $data['id'], 'seats' => $data['availableSeats']);

        if ($stmt->execute($param)) {
            return true;
        }
    }

    function delete(int $id)
    {
        $sql = "
            DELETE FROM flights
            WHERE id = :id"
        ;

        $stmt = $this->pdo->openConnection()->prepare($sql);
        $param = array('id' => $id);
        
        if ($stmt->execute($param)) {
            return true;
        }

        return false;
    }
}