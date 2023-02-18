<?php

class User
{

    private ?PDO $conn;
    private string $table_name = "user";
    public int $id;
    public string $name;
    public string $city_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET name=:name, city_id=:city_id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->city_id = htmlspecialchars(strip_tags($this->city_id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":city_id", $this->city_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}


