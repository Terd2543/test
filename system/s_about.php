<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message) {
    if ($status) {
        $json = ['status'=> 'success','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }else{
        $json = ['status'=> 'fail','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_SESSION['admin'])) {
    $name = $_POST['s_name'];
    $des   = $_POST['s_des'];
    if ($name != "" AND $des != "" ) {
        $des = preg_replace('~\R~u', "\n", $des);
    //================================================================
        $upt = dd_q("UPDATE setting SET name = ? , des = ? ", [
           $name,
           $des 
        ]);
        if($upt){
            dd_return(true, "บันทึกสำเร็จ");
        }else{
            dd_return(false, "SQL ผิดพลาด โปรดติดต่อโปรแกรมเมอร์");
        }
    //================================================================
    }else{
        dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
    }
    }
        dd_return(false, "เข้าสู่ระบบก่อนดำเนินการครับ ");
    }
dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
 ?>
