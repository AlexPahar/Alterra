<?php

class PDO_CONNECT
{
    private PDO $dbConnect;

    public function __construct(string $host, string $db, string $user, string $pass, string $charset = "utf8")
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->dbConnect = new PDO($dsn, $user, $pass, $opt);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public function addTableItem(string $table, $post)
    {
        $allowed = array("name", "phone");
        $sql = "INSERT INTO {$table} SET " . $this->pdoSet($allowed, $values, $post);
        $stm = $this->dbConnect->prepare($sql);
        $stm->execute($values);
        unset($values);
    }

    private function pdoSet($allowed, &$values, $source = array())
    {
        $set = '';
        $values = array();
        if (!$source) $source = &$_POST;
        foreach ($allowed as $field) {
            if (isset($source[$field])) {
                $set .= "`" . str_replace("`", "``", $field) . "`" . "= :$field, ";
                $values[$field] = $source[$field];
            }
        }
        return substr($set, 0, -2);
    }

    public function deleteTableItem(string $id, string $table)
    {
        if (empty($id) || empty($table))
            return false;

        $sql = "DELETE FROM {$table} WHERE id= ?";
        $stm = $this->dbConnect->prepare($sql);
        $stm->execute([$id]);
    }

    public function getQueryList(string $table, array $params)
    {
        $prm = implode(",", $params);
        $list = $this->dbConnect->query("SELECT {$prm} FROM {$table}");
        return $list;
    }
}