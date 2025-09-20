<?php 
    function checktype($type){
        if ($type == "sys"){
            return "s_oagp.php"; 
        }else{
            if(isset($_GET['type']) && $_GET['type'] == "gp"){ 
                echo "del_pgp.php"; 
            }
            else{ 
                echo "del_p.php"; 
            } 
        }
    }
    if(isset($_GET['id'])){
        $f = dd_q("SELECT * FROM gp_order WHERE id = ? ",[$_GET['id']]);
        
        if($f->rowCount() == 1){
            $row = $f->fetch(PDO::FETCH_ASSOC);
            $get = dd_q("SELECT * FROM users WHERE id = ? ", [$row['uid']]);
            $user = $get->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .m-cent{
        margin: 0% auto;
    }
</style>
<div class="container-sm p-3 bg-white  rounded border mt-4 shadow">
    <div class="m-cent">
    <center><h2><i class="fa-solid fa-list"></i>&nbsp;รายการการสั่งซื้อ</h2></center>
        <hr>
        <div class="col-lg-6 mb-3 m-cent">
            <center><h4 class="badge bg-success text-white" style="font-size: 28px;">รายละเอียด</h4></center>
            <h5>หมายเลขคำสั่งซื้อ : <?php echo $row['id']?></h5>
            <h5>ชื่อรายการ : <?php echo $row['name']?></h5>
            <h5>ชื่อผู้ใช้ : <?php echo $row['user']?></h5>
            <h5>รหัสผ่าน : <?php echo $row['pass']?></h5>
            <h5>จากผู้ใช้ชื่อ : <?php echo $user['username']?></h5>
        </div>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <h4><i class="fa-solid fa-circle-check"></i>&nbsp;สถานะ</h4>
                    <select class="form-select form-select-lg" id="status">
                        <option value="1">สำเร็จ</option>
                        <option value="2">ไม่สำเร็จ</option>
                        <!-- <option value="3">เป็นได้แค่พี่น้อง</option> -->
                    </select>
                </div>
                <div class="mb-2 mt-2">
                    <label for="reason"><h4><i class="fa-solid fa-envelope"></i>&nbsp;หมายเหตุ</h4></label>
                    <input type="text" class="form-control form-control-lg" id="reason" placeholder="หมายเหตุ ถึงลูกค้า" >
                </div>
                <button class="btn btn-primary mb-2 mt-2 btn-lg" id="btn_regis"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
            </div>
        </div>
        <script type="text/javascript">

$("#btn_regis").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('reason', $("#reason").val() );
    formData.append('tid', "<?php echo $_GET['id']; ?>");
    formData.append('status'  , $("#status").val() );
    $('#btn_regis').attr('disabled', 'disabled');
    $.ajax({
        type: 'POST',
        url: 'system/<?php echo checktype("sys");?>',
        data:formData,
        contentType: false,
        processData: false,   
    }).done(function(res){
        
        result = res;
        console.log(result);
        if(res.status == "success"){
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page']; if(isset($_GET['type'])){echo "&type=".$_GET['type'];}?>";
            });
        }
        if(res.status == "fail"){
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: result.message
            });
            $('#btn_regis').removeAttr('disabled');
        }
    }).fail(function(jqXHR){
        console.log(jqXHR);
        //   res = jqXHR.responseJSON;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message
        })
        //console.clear();
        $('#btn_regis').removeAttr('disabled');
    });
});
</script>
        </div>
    </div>
</div>
<?php 
        }else{
            $found = "none";
        }
    }else{
        $found = "none";
    }
    if(isset($found)){
?>
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<div class="container-sm p-3 bg-white  rounded border mt-4">
    <center><h2><i class="fa-solid fa-list"></i>&nbsp;รายการการสั่งซื้อ</h2></center>
    <hr>
    <div class="table-responsive">
        <table class="table" id="order-table">
        <thead>
            <tr>
                <th scope="col">หมายเลขคำสั่งซื้อ</th>
                <th scope="col">ชื่อสินค้า</th>
                <th scope="col">ชื่อผู้ใช้</th>
                <th scope="col">รหัสผ่าน</th>
                <th scope="col">ราคา</th>
                <th scope="col">วันที่</th>
                <th scope="col">ชื่อลูกค้า</th>
                <th scope="col">สถานะ</th>
                <th scope="col">แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (isset($_GET['type']) && $_GET['type'] == "done"){
                    $q =  dd_q("SELECT * FROM gp_order WHERE status > 0 ORDER BY id DESC ");
                }else{
                    $q =  dd_q("SELECT * FROM gp_order WHERE status = 0 ORDER BY id DESC ");
                }
                while($row = $q->fetch(PDO::FETCH_ASSOC)){
                    $get = dd_q("SELECT * FROM users WHERE id = ? ", [$row['uid']]);
                    $user = $get->fetch(PDO::FETCH_ASSOC);
                
            ?>
            <tr>
                <th scope="row"><?php echo $row['id'];?></th>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['user'];?></td>
                <td><?php echo $row['pass'];?></td>
                <td><?php echo $row['price'];?></td>
                <td><?php echo $row['date'];?></td>
                <td><?php echo $user['username'];?></td>
                <td><?php 
                if($row['status'] == 0){
                    echo "<h4 class='badge bg-warning' style='font-size: 14px;'>ดำเนินการอยู่</h4>";
                }elseif ($row['status'] == 1) {
                    echo "<h4 class='badge bg-success' style='font-size: 14px;'>สำเร็จแล้ว</h4>";
                }elseif ($row['status'] == 2) {
                    echo "<h4 class='badge bg-danger' style='font-size: 14px;'>ไม่สำเร็จ</h4>";
                }
                ?></td>
                <td><a href="?page=gp_order&id=<?php echo $row['id'];?>"><button class="btn btn-success"><i class="fa-solid fa-truck"></i>&nbsp;ดำเนินการ</button></a></td>
            </tr>
            <?php 
                }
            ?>
        </tbody>
        </table>
    </div>
</div>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#order-table').DataTable();
    } );
</script>
<?php
    }
?>
