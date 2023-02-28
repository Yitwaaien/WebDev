<?php

namespace repositories;

use models\User;
use PDOStatement;
use PDO;

class UserRepository
{
    private ?User $user;
    public ?PDO $conn;
    public string $table_name = "user";

    public function __construct(User $user, PDO $db)
    {
        $this->conn = $db;
        $this->user = $this->dateToHTMLChars($user);
    }

    private function dateToHTMLChars(User $user): User
    {

        $user->name = htmlspecialchars(strip_tags($user->name));
        $user->username = htmlspecialchars(strip_tags($user->username));;

        return $user;

    }

    public function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY user_id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }

    public function getUsersCitys(int $id): bool|PDOStatement
    {
        $query = "SELECT new_schema.city.city_name as city_name
                    FROM ((new_schema.user
                                INNER JOIN new_schema.user_has_city ON new_schema.user.user_id  = new_schema.user_has_city.user_user_id)
                                INNER JOIN new_schema.city          ON new_schema.user_has_city.city_city_id = new_schema.city.city_id)
                   WHERE new_schema.user.user_id =:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        return $stmt;
    }

    public function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET user_name=:name,
                                                            user_username=:username";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->user->name);
        $stmt->bindParam(":username", $this->user->username);

        return $stmt->execute();
    }

    public function updateOnId(int $id): bool
    {
        $this->user->id = $id;

        $query = "UPDATE " . $this->table_name . " SET user_name=:name,
                                              user_username=:username
                                              WHERE user_id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->user->name);
        $stmt->bindParam(":username", $this->user->username);
        $stmt->bindParam(":id", $this->user->id);

        return $stmt->execute();

    }

    public function deleteOnId(int $id): bool
    {
        $this->user->id = $id;

        $query = "DELETE FROM " . $this->table_name . " WHERE user_id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->user->id);

        return $stmt->execute();

    }

}