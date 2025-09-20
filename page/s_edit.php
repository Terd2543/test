
<?php 
    if(isset($_GET['id'])){
        $f = dd_q("SELECT * FROM box_stock WHERE id = ? ",[$_GET['id']]);
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
                    <label for="user"><h4><i class="fa-solid fa-circle-question"></i>&nbsp;เปอร์เซ็นต์การออก</h4></label>
                    <input type="text" class="form-control form-control-lg" id="percentage" placeholder="มากที่สุด 100 % ใส่แค่ตัวเลข" value="<?php echo $row['password'];?>">
                </div>
                <div class="mb-2 mt-2">
                    <label for="user"><h4><i class="fa-solid fa-envelope"></i>&nbsp;ชื่อรางวัลที่ลูกค้าได้รับ</h4></label>
                    <input type="text" class="form-control form-control-lg" id="prize_name" placeholder="ชื่อสินค้า" value="<?php echo $row['username'];?>">
                    <h4 class="mt-3">หลังจากนั้นลูกค้าจะติดต่อเพจเพื่อรับรหัส</h4>
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
            formData.append('percent'  , $("#percentage").val() );
            formData.append('prize_name'  , $("#prize_name").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_sedit.php',
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
<div class="container-sm p-3 bg-white  rounded border mt-4">
    <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขสต็อก</h2></center>
    <select class="form-select" onchange="select_product()" id="sel_pd">
        <?php 
            if(isset($_GET['pid'])){
                $get_p = dd_q("SELECT * FROM box_product WHERE id = ? ", [$_GET['pid']]);
                if($get_p->rowCount() >= 1){
                    $p_info = $get_p->fetch(PDO::FETCH_ASSOC);
        ?>
            <option selected><?php echo $p_info['name'];?></option>
            <option ></option>
        <?php 
            }else{
                ?>
                    <option selected>เลือกสินค้าที่ต้องการแก้ไข</option>
                }
        <?php 
            }
            }else{
        ?>
            <option selected>เลือกสินค้าที่ต้องการแก้ไข</option>
        <?php
            }
        ?>
        <?php 
            $find_p = dd_q("SELECT * FROM box_product ORDER BY id DESC");
            while($pd = $find_p->fetch(PDO::FETCH_ASSOC)){
        ?>
        <option value="<?php echo $pd['id'];?>"><?php echo $pd['name'];?></option>
        <?php 
            }
        ?>
    </select>
    <hr>
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">ชื่อสินค้า</th>
            <th scope="col">แก้ไข</th>
            <th scope="col">ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(isset($_GET['pid'])){
                    $q =  dd_q("SELECT * FROM box_stock WHERE p_id = ? ORDER BY id DESC",[$_GET['pid']]);
                }else{
                    $q =  dd_q("SELECT * FROM box_stock ORDER BY id DESC");
                }
                $i = 1; 
                while($row = $q->fetch(PDO::FETCH_ASSOC)){

                
            ?>
            <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $row['username'];?></td>
                <td><a href="?page=s_edit&id=<?php echo $row['id'];?>"><button class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไข</button></a></td>
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
<script type="text/javascript">
    function select_product(){
        var sel_pd = $("#sel_pd").val();
        window.location.href = "?page=s_edit&pid="+sel_pd;
    }
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
                    url: 'system/del_s.php',
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
                                window.location = "?page=s_edit";
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
