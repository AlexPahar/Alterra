<?php

class Database
{
    private string $host = "localhost";
    private string $database = "alterra";
    private string $username = "root";
    private string $password = "root";
    public PDO $conn;

    public function getConnection(): PDO
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}