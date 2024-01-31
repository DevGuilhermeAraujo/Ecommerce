<?php

class Conexao
{
    private $host = "localhost";
    private $port = "3306";
    private $user = "root";
    private $pass = "";
    private $dbName = "ecommercebelezarosa";
    private $pdo = null;

    public $errorCode = 0;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=$this->dbName;host=$this->host;port=$this->port", $this->user, $this->pass);
        } catch (Exception $e) {
            $this->errorCode = $e->getCode();
        }
    }

    public function executar($sql, $fullObject = false, $autoExec = true)
    {
        $stmt = $this->pdo->prepare($sql);
        if ($autoExec || !$fullObject)
            $stmt->execute();
        if ($fullObject) {
            return $stmt;
        } else {
            $result = $stmt->fetchAll();
            return $result;
        }
    }
}
