<?php

namespace repositories;

use models\City;
use PDOStatement;
use PDO;

class СityRepository
{
    private ?City $city;
    public ?PDO $conn;
    public string $table_name = "city";

    public function __construct(City $city, PDO $db)
    {
        $this->conn = $db;
        $this->city = $this->dateToHTMLChars($city);
    }

    private function dateToHTMLChars(City $city): City
    {
        $city->cityName = htmlspecialchars(strip_tags($city->cityName));
        $city->cityId = htmlspecialchars(strip_tags($city->cityId));

        return $city;

    }

    public function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY city_id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET city_name=:name";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->city->cityName);

        if ($stmt->execute())
        {
            return true;
        }

        return false;
    }

    public function updateOnId(string $id): bool
    {
        $this->city->cityId = $id;
        $this->city = $this->dateToHTMLChars($this->city);

        $query = "UPDATE " . $this->table_name . " SET city_name=:name
                                                   WHERE city_id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->city->cityName);
        $stmt->bindParam(":id", $this->city->cityId);

        return $stmt->execute();
    }

    public function deleteOnId(string $id): bool
    {
        $this->city->cityId = $id;
        $this->city = $this->dateToHTMLChars($this->city);

        $this->city->cityName = htmlspecialchars(strip_tags($this->city->cityName));

        $query = "DELETE FROM " . $this->table_name . " WHERE city_id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->city->cityId);

        return $stmt->execute();
    }

}