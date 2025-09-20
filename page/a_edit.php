<div class="container-sm mt-4">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-gear"></i>&nbsp;เปลี่ยนรหัสผ่านแอดมิน</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="txt_p_old"><h4><i class="fa-solid fa-asterisk"></i>&nbsp;รหัสผ่านเก่า</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_p_old" placeholder="รหัสผ่านเก่า" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="txt_p_new"><h4><i class="fa-solid fa-asterisk"></i>&nbsp;รหัสผ่านใหม่</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_p_new" placeholder="รหัสผ่านใหม่" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="txt_p_con"><h4><i class="fa-solid fa-asterisk"></i>&nbsp;รหัสผ่านใหม่อีกครั้ง</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_p_con" placeholder="รหัสผ่านใหม่อีกครั้ง" >
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
            console.log($("#txt_p_old").val());
            console.log($("#txt_p_new").val());
            console.log($("#txt_p_con").val());

            formData.append('old_p'  , $("#txt_p_old").val() );
            formData.append('new_p'  , $("#txt_p_new").val() );
            formData.append('con_p'  , $("#txt_p_con").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_aedit.php',
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
                        window.location = "?page=<?php echo $_GET['page'];?>";
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