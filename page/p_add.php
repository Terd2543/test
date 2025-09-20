<?php 
    function checktype($type){
        if ($type == "sys"){
            if(isset($_GET['type']) && $_GET['type'] == "gp")
            { 
                return "s_pagp.php"; 
            }else{ 
                return "s_padd.php"; 
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
    ?>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-plus"></i>&nbsp;เพิ่มสินค้า</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="t_id"><h4><i class="fa-solid fa-shapes"></i>&nbsp;หมวดหมู่</h4></label>
                    <select class="form-select form-select-lg" id="t_id">
                        <?php 
                        if(isset($_GET['type']) && $_GET['type'] == "gp")
                        { 
                            $q = dd_q("SELECT * FROM gp_type ORDER BY id DESC");
                        }else{ 
                            $q = dd_q("SELECT * FROM box_type ORDER BY id DESC");
                        }
                            
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo htmlspecialchars($row['name']);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-2 mt-2">
                    <label for="p_name"><h4><i class="fa-solid fa-box"></i>&nbsp;ชื่อสินค้า</h4></label>
                    <input type="text" class="form-control form-control-lg" id="p_name" placeholder="ชื่อสินค้า" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-solid fa-pen-to-square"></i>&nbsp;คำอธิบายสินค้า</h4></label> <br>
                    <textarea type="text" class="form-control form-control-lg" id="p_des" placeholder="คำอธิบาย..."></textarea>
                </div>
                <div class="mb-2 mt-2">
                    <label for="p_name"><h4><i class="fa-solid fa-coins"></i>&nbsp;ราคาสินค้า</h4></label>
                    <input type="number" class="form-control form-control-lg" id="p_price" placeholder="200" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="b_type"><h4><i class="fa-solid fa-cog"></i>&nbsp;ชนิดของสินค้า</h4></label>
                    <select class="form-select form-select-lg" id="b_type">
                        <option value="0">โหมดสุ่มมีเกลือ</option>
                        <option value="1">โหมดได้รหัสแน่นอน</option>
                    </select>
                </div>
                <div class="mt-2 mb-2">
                    <label for="formFileLg" class="form-label">
                        <h4><i class="fa-solid fa-image"></i>&nbsp;ภาพปกสินค้า ( jpg , png , gif , webp )</h4>
                    </label>
                    <input class="form-control " id="p_pimg" type="file">
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
            var files = $('#p_pimg')[0].files[0];
            formData.append('file', files );
            formData.append('name', $("#p_name").val() );
            formData.append('tid', $("#t_id").val() );
            formData.append('user', $("#p_user").val() );
            formData.append('b_type', $("#b_type").val() );
            formData.append('pass', $("#p_pass").val() );
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
                            window.location = "?page=<?php echo $_GET['page']; if(isset($_GET['type'])){echo $_GET['type']; }?>";
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