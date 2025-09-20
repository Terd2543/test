
<?php 
    if(isset($_GET['id'])){
        $f = dd_q("SELECT * FROM users WHERE id = ? ",[$_GET['id']]);
        if($f->rowCount() == 1){
            $row = $f->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .m-cent{
        margin: 0% auto;
    }
</style>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-plus"></i>&nbsp;แก้ไขสต็อก</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="user"><h4><i class="fa-solid fa-envelope"></i>&nbsp;ชื่อผู้ใช้</h4></label>
                    <input type="text" class="form-control form-control-lg "   value="<?php echo htmlspecialchars($row['username']);?>" disabled>
                </div>
                <div class="mb-2 mt-2">
                    <label for="password"><h4><i class="fa-solid fa-lock"></i>&nbsp;รหัสผ่าน</h4></label>
                    <input type="text" class="form-control form-control-lg" id="password" placeholder="รหัสผ่านใหม่ หากไม่ต้องการแก้ให้เว้นว่างไว้" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="point"><h4><i class="fa-solid fa-coins"></i>&nbsp;ยอดเงิน</h4></label>
                    <input type="text" class="form-control form-control-lg" id="point" value="<?php echo $row['point'];?>" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="user"><h4><i class="fa-solid fa-sack-dollar"></i>&nbsp;ยอดการเติมทั้งหมด</h4></label>
                    <input type="text" class="form-control form-control-lg" value="<?php echo $row['total'];?>" disabled >
                </div>
                <button class="btn btn-primary mb-2 mt-2 btn-lg" id="btn_regis"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

        $("#btn_regis").click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('id'  , "<?php echo htmlspecialchars($_GET['id']);?>");
            formData.append('pass'  , $("#password").val() );
            formData.append('point'  , $("#point").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/u_edit.php',
                data:formData,
                contentType: false,
                processData: false,   
            }).done(function(res){
                result = res;
                console.log(result);
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: result.message
                }).then(function() {
                        window.location = "?page=<?php echo htmlspecialchars($_GET['page']);?>";
                });
            }).fail(function(jqXHR){
                console.log(jqXHR);
                res = jqXHR.responseJSON;
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
    <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขสมาชิก</h2></center>
    <hr>
    <div class="table-responsive">
        <table class="table" id="member-table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">ชื่อผู้ใช้</th>
            <th scope="col">Points</th>
            <th scope="col">ยอดการเติมทั้งหมด</th>
            <th scope="col">รหัส6หลัก</th>
            <th scope="col">แก้ไข</th>
            <th scope="col">ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $q =  dd_q("SELECT * FROM users ORDER BY id DESC");
                $i = 1; 
                while($row = $q->fetch(PDO::FETCH_ASSOC)){

                
            ?>
            <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo htmlspecialchars($row['username']);?></td>
                <td><?php echo $row['point'];?></td>
                <td><?php echo $row['total'];?></td>
                <td><?php echo $row['pin'];?></td>
                <td><a href="?page=u_edit&id=<?php echo $row['id'];?>"><button class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไข</button></a></td>
                <td><button class="btn btn-danger" onclick="del_cate('<?php echo $row['id'];?>')"><i class="fa-solid fa-trash"></i>&nbsp;ลบ</button></td>
            </tr>
            <?php 
                    $i++;
                }
            ?>
        </tbody>
        </table>
    </div>
</div>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#member-table').DataTable();
    } );
</script>
<script type="text/javascript">
    
    function del_cate(id){
        Swal.fire({
            title: 'ยืนยันที่จะลบ?',
            text: "คุณแน่ใจหรอที่จะลบสินค้านี้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบเลย'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id',id);
                $.ajax({
                    type: 'POST',
                    url: 'system/del_u.php',
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
                                window.location = "?page=u_edit";
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
            }
        })
    }
</script>
<?php
    }
?>
