
<?php 
    function checktype($type){
        if ($type == "sys"){
            if(isset($_GET['type']) && $_GET['type'] == "id")
            { 
                return "s_ceid.php"; 
            }
            elseif(isset($_GET['type']) && $_GET['type'] == "gp"){
                return "s_cegp.php"; 
            }else{ 
                return "s_cedit.php"; 
            }
        }else{
            if(isset($_GET['type']) && $_GET['type'] == "id"){ 
                echo "del_cid.php"; 
            }
            elseif(isset($_GET['type']) && $_GET['type'] == "gp"){
                return "del_cgp.php"; 
            }else{ 
                echo "del_c.php"; 
            } 
        }
    }
    if(isset($_GET['id'])){
        if (isset($_GET['type']) && $_GET['type'] == "id") {
            $f = dd_q("SELECT * FROM id_type WHERE id = ? ",[$_GET['id']]);
        }elseif (isset($_GET['type']) && $_GET['type'] == "gp") {
            $f = dd_q("SELECT * FROM gp_type WHERE id = ? ",[$_GET['id']]);
        }
        else{
            $f = dd_q("SELECT * FROM box_type WHERE id = ? ",[$_GET['id']]);
        }
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
        <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขหมดวหมู่</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="txt_w_pic"><h4><i class="fa-solid fa-image"></i>&nbsp;ลิงค์รูปภาพ</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_w_pic" placeholder="ลิงค์รูปภาพ"  value="<?php echo $row['img_link'];?>">
                </div>
                <div class="mb-2 mt-2">
                    <label for="txt_w_name"><h4><i class="fa-solid fa-shapes"></i>&nbsp;ชื่อหมวดหมู่</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_w_name" placeholder="ชื่อหมวดหมู่" value="<?php echo $row['name'];?>">
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
            formData.append('txt_w_pic'  , $("#txt_w_pic").val() );
            formData.append('txt_w_name'  , $("#txt_w_name").val() );
            formData.append('txt_w_id'  ,"<?php echo $_GET['id'];?>" );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/<?php echo checktype("sys"); ?>',
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
                        window.location = "?page=<?php echo $_GET['page'];if (isset($_GET['type'])){
                echo "&type=".$_GET['type'];
            }?>";
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
    <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขหมวดหมู่</h2></center>
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
                if (isset($_GET['type']) && $_GET['type'] == "id") {
                    $q = dd_q("SELECT * FROM id_type",[]);
                }elseif (isset($_GET['type']) && $_GET['type'] == "gp") {
                    $q = dd_q("SELECT * FROM gp_type ",[]);
                }else{
                    $q = dd_q("SELECT * FROM box_type",[]);
                }
                $i = 1; 
                while($row = $q->fetch(PDO::FETCH_ASSOC)){

                
            ?>
            <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $row['name'];?></td>
                <td><a href="?page=c_edit&id=<?php echo $row['id'];if (isset($_GET['type'])){
                echo "&type=".$_GET['type'];
            }?>"><button class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไข</button></a></td>
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
                    url: 'system/<?php echo checktype("del");?>',
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
                                window.location = "?page=c_edit";
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
                    res = jqXHR.responseJSON;
                    
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
