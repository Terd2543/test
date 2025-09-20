<?php 
    session_start();
    $host = "localhost";
    // user database
    $db_user = "xdnvxyz_dreammyshop";
    // รหัส database
    $db_pass = "dreammyshop";
    // ชื่อ database
    $db = "xdnvxyz_dreammyshop";
    //connect to database
    $conn = new PDO("mysql:host=$host;dbname=$db",$db_user,$db_pass);
    $conn->exec("set names utf8mb4");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //end connect to database
    //function query
    function dd_q($str, $arr = []) {
        global $conn;
        try {
            $exec = $conn->prepare($str);
            $exec->execute($arr);
        } catch (PDOException $e) {
            return false;
        }
        return $exec;
    }
    //end function query

    //function check login
    function check_login(){
        if(!isset($_SESSION['id'])){
            return false;
        }else{
            return true;
        }
    }
    $conf['sitekey'] = "6LcXhlMkAAAAALW9ShpI946SqC7G0FiDSlMHzjZz";
    $conf['secretkey'] = "6LcXhlMkAAAAAMXH7O38Dlb-m4L12JUT80O0opP3";
    
?>