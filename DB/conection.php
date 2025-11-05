<?php
class Database
{
    private $hostname = "sql100.yzz.me";
    private $database = "yzzme_40342464_free_fire";
    private $username = "yzzme_40342464";
    private $password = "DidierR2025Z";
    private $charset = "utf8";

    public function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
}
?>