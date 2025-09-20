<?php
    $s = dd_q("SELECT * FROM setting");
    $s_info = $s->fetch(PDO::FETCH_ASSOC); 
?>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-gear"></i>&nbsp;การตั้งค่าทั่วไป</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-solid fa-wallet"></i>&nbsp;เบอร์วอเล็ท ใส่เฉพาะตัวเลข!!</h4></label>
                    <input type="text" class="form-control form-control-lg" id="wallet" placeholder="09xxxxxxxx" value="<?php echo $s_info['wallet']; ?>">
                </div>
                <div class="mb-2 mt-2">
                    <label for="s_name"><h4><i class="fa-brands fa-youtube"></i>&nbsp;ลิงค์คลิปสอนเติมเงิน</h4></label> <br>
                    <label for="s_name"><span class="text-danger">*&nbsp;ไม่ต้องใส่เต็มลิงค์ใส่แค่ส่วนหลัง https://www.youtube.com/watch?v= </span></label>
                    <label for="s_name"><span class="text-danger">เช่น&nbsp;ลิงค์ https://www.youtube.com/watch?v=dQw4w9WgXcQ <br> ใส่แค่ dQw4w9WgXcQ </span></label>
                    <label for="s_name"><span class="text-danger">เช่น&nbsp;ลิงค์ https://youtu.be/dQw4w9WgXcQ ใส่แค่ dQw4w9WgXcQ </span></label>
                    
                    <input type="text" class="form-control form-control-lg" id="link" placeholder="dQw4w9WgXcQ" value="<?php echo $s_info['yt']; ?>">
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
            formData.append('phone', $("#wallet").val() );
            formData.append('link'  , $("#link").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_vdo.php',
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
                            window.location = "?page=setting";
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