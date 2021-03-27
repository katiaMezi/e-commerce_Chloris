<?php

class Cnx
{

 private static $dsn = 'mysql:host=localhost;dbname=jardinsdechloris';
 private static $user = 'root';
 private static $pass = '';

 private static $cnx = null;

 public static function connect()
    {
        try
        {
            self::$cnx = new PDO (self::$dsn, self::$user, self::$pass); 
        }
        catch(PDOException $e) 
        {
            echo 'Erreur de connexion à la base de données';
        }
        return self::$cnx;
    }

 public static function disconnect()
    {
        self::$cnx = null;
    }
 
}

Cnx::connect();