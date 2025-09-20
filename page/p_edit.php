<?php 
    function checktype($type){
        if ($type == "sys"){
            if(isset($_GET['type']) && $_GET['type'] == "gp")
            { 
                return "s_pegp.php"; 
            }else{ 
                return "s_pedit.php"; 
            }
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
        if(isset($_GET['type']) && $_GET['type'] == "gp")
        { 
            $f = dd_q("SELECT * FROM gp_product WHERE id = ? ",[$_GET['id']]);
        }else{ 
            $f = dd_q("SELECT * FROM box_product WHERE id = ? ",[$_GET['id']]);

        }
        
        if($f->rowCount() == 1){
            $row = $f->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .m-cent{
        margin: 0% auto;
    }
</style>
<div class="container-sm p-3 bg-white  rounded border mt-4 shadow">
    <div class="m-cent">
    <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขสินค้า</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="p_name"><h4><i class="fa-solid fa-box"></i>&nbsp;ชื่อสินค้า</h4></label>
                    <input type="text" class="form-control form-control-lg" id="p_name" placeholder="ชื่อสินค้า" value="<?php echo $row['name']; ?>">
                </div>
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-solid fa-pen-to-square"></i>&nbsp;คำอธิบายสินค้า</h4></label> <br>
                    <textarea type="text" class="form-control form-control-lg" id="p_des" placeholder="คำอธิบาย..."><?php echo $row['des']; ?></textarea>
                </div>
                <div class="mb-2 mt-2">
                    <label for="p_name"><h4><i class="fa-solid fa-coins"></i>&nbsp;ราคาสินค้า</h4></label>
                    <input type="number" class="form-control form-control-lg" id="p_price" placeholder="200" value="<?php echo $row['price']; ?>">
                </div>
                <div class="mt-2 mb-2">
                    <label for="b_type"><h4><i class="fa-solid fa-cog"></i>&nbsp;ชนิดของสินค้า</h4></label>
                    <select class="form-select form-select-lg" id="b_type">
                    <?php 
                        if($row['type'] == "1"){
                    ?>
                        <option value="1">โหมดได้รหัสแน่นอน</option>
                        <option value="0">โหมดสุ่มมีเกลือ</option>
                        <?php 
                        }else{
                            ?>
                            <option value="0">โหมดสุ่มมีเกลือ</option>
                            <option value="1">โหมดได้รหัสแน่นอน</option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div class="mt-2 mb-2">
                    <label for="formFileLg" class="form-label">
                        <h4><i class="fa-solid fa-image"></i>&nbsp;ภาพสินค้า ( jpg , png , gif , webp )</h4>
                    </label>
                    <input class="form-control " id="p_dimg" type="file">
                </div>
                <button class="btn btn-primary mb-2 mt-2 btn-lg" id="btn_regis"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
            </div>
        </div>
        <script type="text/javascript">

$("#btn_regis").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    var files = $('#p_dimg')[0].files[0];
    formData.append('file', files );
    formData.append('name', $("#p_name").val() );
    formData.append('b_type', $("#b_type").val() );
    formData.append('tid', "<?php echo $_GET['id']; ?>");
    formData.append('des'  , $("#p_des").val() );
    formData.append('price'  , $("#p_price").val() );
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
<div class="container-sm p-3 bg-white  rounded border mt-4">
    <center><h2><i class="fa-solid fa-pen-to-square"></i>&nbsp;แก้ไขสินค้า</h2></center>
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
            if(isset($_GET['type']) && $_GET['type'] == "gp")
            { 
                $q =  dd_q("SELECT * FROM gp_product ORDER BY id DESC");
            }else{ 
                $q =  dd_q("SELECT * FROM box_product ORDER BY id DESC");
    
            }
                
                $i = 1; 
                while($row = $q->fetch(PDO::FETCH_ASSOC)){

                
            ?>
            <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $row['name'];?></td>
                <td><a href="?page=p_edit&id=<?php echo $row['id'];if (isset($_GET['type'])){
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
            }
        })
    }
</script>
<?php
    }
?>
