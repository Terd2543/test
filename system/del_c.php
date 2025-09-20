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
            $del = dd_q("DELETE FROM box_type WHERE id = ? ", [$id]);
            $product = dd_q("SELECT * FROM box_product WHERE t_id =  ? ",[$id]);
            if($product->rowCount() >= 1){
                while($row = $product->fetch(PDO::FETCH_ASSOC)){
                    $del_stock = dd_q("DELETE FROM box_stock WHERE p_id = ? AND o_id = 0",[$row['id']]);
                    $del_product = dd_q("DELETE FROM box_product WHERE id = ? ",[$row['id']]);
                }
            }
            if($del){
                dd_return(true, "ลบหมวดหมู่ได้สำเร็จ!!");
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
