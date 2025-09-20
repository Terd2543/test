<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'a_func.php';

    function dd_return($status, $message) {
        $json = ['message' => $message];
        if ($status) {
            http_response_code(200);
            die(json_encode($json));
        }else{
            http_response_code(400);
            die(json_encode($json));
        }
    }

    //////////////////////////////////////////////////////////////////////////

    header('Content-Type: application/json; charset=utf-8;');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['admin'])) {

        if ($_POST['id'] != "" AND $_POST['prize_name'] != "" AND $_POST['percent'] != "" ) {
            $q_1 = dd_q('SELECT * FROM admin WHERE id = ?', [$_SESSION['admin']]);
            if ($q_1->rowCount() >= 1) {
                //==============================================================//
                    $stock_arr = explode("\n" , $_POST['prize_name']);
                    foreach ($stock_arr as $key => $value) {
                        if($value != ""){
                            $q_2 = dd_q('INSERT INTO box_stock (username,password,p_id,o_id) VALUES ( ? , ? , ? , 0 ) ', [
                                $value,
                                $_POST['percent'],
                                $_POST['id']
                            ]);
                        }else{
                            continue;
                        }
                        
                    }
                    
                    if ($q_2 == true) {
                        dd_return(true, "เพิ่มสินค้าเข้าสต็อกสำเร็จ!!");
                    }else{
                        dd_return(false, "เกิดข้อผิดพลาด");
                    }
                //==============================================================//
            }else{
                dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
                session_destroy();
            }
        }else{
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
        }else{
        dd_return(false, "เข้าสู่ระบบก่อน");
        }
    }else{
        dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
    }
?>
