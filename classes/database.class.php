<?php
class Database {
       private static $server="localhost";
    private static $username="root";
    private static $password="mylife77";
    private static $db="mydb";
    private static $cnn;

    public static function open(){
        self::$cnn=mysqli_connect(self::$server,self::$username,self::$password,self::$db);
        mysqli_set_charset(self::$cnn,"utf8");
    }

    public static function close(){
        mysqli_close(self::$cnn);
    }

    public static function query($sql){
        self::open();
        $result=mysqli_query(self::$cnn,$sql);
        self::close();
        return $result;
    }
}