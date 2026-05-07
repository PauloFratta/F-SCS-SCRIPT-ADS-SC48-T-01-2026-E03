<?php

class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            $host   = 'sql209.infinityfree.com'; // confirma o host no painel
            $dbname = 'if0_41832603_ecomapa';     // nome do seu banco
            $user   = 'if0_41832603';
            $pass   = 'HvA4Oy8lRP4U';               // senha que definiu no painel

            self::$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$conn;
    }
}