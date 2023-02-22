<?php

use JetBrains\PhpStorm\NoReturn;

class User
{



    private ?PDO $conn;
    private string $table_name = "user";
    public int $id;
    public string $username;
    public string $city;

    public  string $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET name=:name, city=:city, username=:username";

        $stmt = $this->conn->prepare($query);


        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->username = htmlspecialchars(strip_tags($this->username));


        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":username", $this->username);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}


