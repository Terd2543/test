<?php
    $s = dd_q("SELECT name,des FROM setting");
    $s_info = $s->fetch(PDO::FETCH_ASSOC); 
?>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-info"></i>&nbsp;เกี่ยวกับร้านค้า</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-solid fa-shop"></i>&nbsp;ชื่อร้านค้า</h4></label>
                    <input type="text" class="form-control form-control-lg" id="s_name" placeholder="ชื่อร้านค้าของคุณ" value="<?php echo $s_info['name']; ?>">
                </div>
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-solid fa-pen-to-square"></i>&nbsp;คำอธิบายร้านค้า</h4></label> <br>
                    <small>หากต้องการขึ้นบรรทัดใหม่ให้พิม <?php echo htmlspecialchars("<br>"); ?> </small>
                    <textarea type="text" class="form-control form-control-lg" id="s_des" placeholder="บริการขายรหัสเกมฟีฟายราคาถูก <br>
และยังมีบริการสุ่มรหัสเกมที่น่าสนใจอีกด้วย"> <?php echo htmlspecialchars($s_info['des']);?></textarea>
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
            formData.append('s_name', $("#s_name").val() );
            formData.append('s_des'  , $("#s_des").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_about.php',
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
                            window.location = "?page=about";
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