<?php

/**
 * Class DB: конфигурация базы данных
 */
class DB{

    const DB = "test";
    const HOST = "localhost";
    const USER = "root";
    const PASS = "";

    /**
     * Open a Connection to MYSQL PDO example
     * @return void
     */
    public static function connToMYSQL() {

        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $db = self::DB;

        try {
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            // Change character set to utf8 for PHP < 5.3.6
            // $conn->exec("set names utf8");
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully (MySQL PDO)<br>";
            return $conn;
        }
        catch (PDOException $e) {
            echo "Connection failed (PDO): " . $e->getMessage(). "<br>";
        }

    }

}