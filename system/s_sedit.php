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

        if ($_POST['id'] != "" AND $_POST['percent'] != "" AND $_POST['prize_name'] != "") {
            $q_1 = dd_q('SELECT * FROM admin WHERE id = ?', [$_SESSION['admin']]);
            if ($q_1->rowCount() >= 1) {
                //==============================================================//
                    $upt = dd_q("UPDATE box_stock SET username = ? , password = ? WHERE id = ? ",[
                        $_POST['prize_name'],
                        $_POST['percent'],
                        $_POST['id'],
                    ]);
                    if ($upt == true) {
                        dd_return(true, "แก้ไขสต็อกสำเร็จ!!");
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
