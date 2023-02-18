<?php

require '../vendor/autoload.php';


class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function getConnection(): ?PDO
    {

        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();
        $this->db_name = $_ENV['DATABASE_NAME'];
        $this->host = $_ENV['MYSQL_HOST'];
        $this->username = $_ENV['MYSQL_USER'];
        $this->password = $_ENV['MYSQL_PASSWORD'];

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

