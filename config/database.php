<?php
require '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();
class Database
{
    private ?string $host;
    private ?string $db_name;
    private ?string $username;
    private ?string $password;
    public ?PDO $conn = null;

    public function __construct()
    {
        $this->host = $_ENV['MYSQL_HOST'];
        $this->db_name = $_ENV['DATABASE_NAME'];
        $this->username = $_ENV['MYSQL_USER'];
        $this->password = $_ENV['MYSQL_PASSWORD'];
    }

    public function getConnection(): ?PDO
    {
        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");

        }
        catch (PDOException $exception)
        {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}