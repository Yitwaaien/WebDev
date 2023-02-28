<?php

namespace repositories;

use models\UserHasCity;
use PDO;

class UserHasCityRepository
{
    private ?UserHasCity $userHasCity;
    public ?PDO $conn;
    public string $table_name = "user_has_city";
    public function __construct(UserHasCity $userHasCity, PDO $db)
    {
        $this->conn = $db;
        $this->userHasCity = $this->dateToHTMLChars($userHasCity);
    }

    private function dateToHTMLChars(UserHasCity $userHasCity): UserHasCity
    {
        $userHasCity->userId = htmlspecialchars(strip_tags($userHasCity->userId));
        $userHasCity->userId = htmlspecialchars(strip_tags($userHasCity->userId));

        return $userHasCity;
    }

    public function create(): bool
    {
        $query = "INSERT INTO " . $this->table_name . " SET user_user_id=:userId,
                                                            city_city_id=:cityId";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":userId", $this->userHasCity->userId);
        $stmt->bindParam(":cityId", $this->userHasCity->cityId);

        return $stmt->execute();
    }

    public function delete(): bool
    {
        $this->userHasCity = $this->dateToHTMLChars($this->userHasCity);

        $query = "DELETE FROM " . $this->table_name . " WHERE user_user_id=:userId AND
                                                              city_city_id=:cityId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":userId", $this->userHasCity->userId);
        $stmt->bindParam(":cityId", $this->userHasCity->cityId);

        return $stmt->execute();
    }
}