<?php
error_reporting(E_ERROR);
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
function randtext($range){
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ123456789';
    $start = rand(1,(strlen($char)-$range));
    $shuffled = str_shuffle($char);
    return substr($shuffled,$start,$range);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_SESSION['admin'])) {
    $name = $_POST['name'];
    $des   = $_POST['des'];
    $tid   = $_POST['tid'];
    $user   = $_POST['user'];
    $pass   = $_POST['pass'];
    $price   = (int) $_POST['price'];
    if ($name != "" AND $des != ""  AND $user != "" AND $pass != "" AND $_FILES['file']['size'] > 0  AND $price != "" AND $tid  != "") {
    //================================================================
        // <----- preview image ------>
        $allowed = array('jpeg', 'png', 'jpg' , 'webp' , 'gif');
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            dd_return(false, "ไฟล์รูปภาพเท่านั้น");
        }else{
            $newfile = randtext(3).time().randtext(5).".".$ext;
            $basename = basename($newfile);
            if (copy($_FILES['file']['tmp_name'],"../../img/box_img/{$basename}")){
                $basename =$basename;
            }else{
                dd_return(false, "ย้ายรูปไม่สำเร็จ");
            }
        }
        // <----- preview image ------>
        // <----- details image ------>
        $in = dd_q("INSERT INTO id_product (name,des,price,user,pass,img,t_id) VALUES ( ? , ? , ? , ? , ? , ? , ? )",[
            $name,
            $des,
            $price,
            $user,
            $pass,
            $basename,
            $tid
        ]);
        if($in){
            dd_return(true, "เพิ่มสินค้าสำเร็จ");
        }else{
            dd_return(false, "SQL ผิดพลาดโปรติดต่อโปรแกรมเมอร์");

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
