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
        $id = $_POST['id'];

    //================================================================
        if ($id != "") {
            $del = dd_q("DELETE FROM users WHERE id = ? ", [$id]);

            if($del){
                dd_return(true, "ลบสมาชิกสำเร็จ!!");
            }else{
                dd_return(false, "SQL ERROR โปรดติดต่อโปรแกรมเมอร์");
            }
                
        }else{

            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
    //================================================================
    }else{
        dd_return(false, "เข้าสู่ระบบก่อนครับ");
    }
}else{
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
 ?>
