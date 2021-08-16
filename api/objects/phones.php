<?php

class Phones
{
    protected PDO $conn;
    private string $table_name = "phones";

    public int $id;
    public string $name;
    public string $phone;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    private function checkById(): bool
    {
        $query = "SELECT id FROM {$this->table_name} WHERE id= :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if (!empty($stmt->fetch())) {
            return true;
        }

        return false;
    }

    private function checkByPhone(): bool
    {
        $query = "SELECT id FROM {$this->table_name} WHERE phone= :phone";
        $stmt = $this->conn->prepare($query);

        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $stmt->bindParam(":phone", $this->phone);
        $stmt->execute();

        if (!empty($stmt->fetch())) {
            return true;
        }

        return false;
    }

    public function read(): bool|PDOStatement
    {
        $query = "SELECT id,name,phone FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete(): bool
    {
        if (!$this->checkById()) {
            return false;
        }

        $query = "DELETE FROM {$this->table_name} WHERE id= :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function create(): bool
    {
        if ($this->checkByPhone()) {
            return false;
        }

        $query = "INSERT INTO {$this->table_name} SET name=:name, phone=:phone;";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}