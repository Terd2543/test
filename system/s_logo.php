

    
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
      if ($_FILES['file']['size'] > 0) {
          //================================================================
            $allowed = array('jpeg', 'png', 'jpg' , 'webp' , 'gif');
            $filename = $_FILES['file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                dd_return(false, "ไฟล์รูปภาพเท่านั้น");
            }else{
                function randtext($range){
                    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ123456789';
                    $start = rand(1,(strlen($char)-$range));
                    $shuffled = str_shuffle($char);
                    return substr($shuffled,$start,$range);
                }
                $newfile = randtext(3).time().randtext(5).".".$ext;
                $basename = basename($newfile);
                if (copy($_FILES['file']['tmp_name'],"../../img/{$basename}")){
                    $basename =$basename;
                }else{
                    dd_return(false, "ย้ายรูปไม่สำเร็จ");
                }
            }
            $upt = dd_q("UPDATE setting SET logo = ?", [
                $basename,
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
