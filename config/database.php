<?php

class Database
{
    private static $conn;

    public static function getConnection()
    {
        if (!self::$conn) {
            $host = 'localhost';
            $dbname = 'erp_montink';
            $usuario = 'root';
            $senha = '';

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
