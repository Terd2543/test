<?php
    $s = dd_q("SELECT logo FROM setting");
    $s_info = $s->fetch(PDO::FETCH_ASSOC); 
?>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-image"></i>&nbsp;อัพโหลดโลโก้</h2></center>
        <hr>
        <div class="mt-2 mb-2">
            <div class="col-lg-6" style="margin: 0% auto;">
                <img src="../img/<?php echo $s_info['logo'];?>" alt="" srcset="" class="container-fluid">
            </div>
        </div>
        <div class="col-lg-6" style="margin: 0% auto;">
            <label for="formFileLg" class="form-label">อัพโหลดโลโก้ ( jpg , png , gif , webp )</label>
            <input class="form-control " id="logo" type="file">
            <div class="d-grid gap2">
                <button class="btn btn-primary mb-2 mt-2 btn-lg" id="btn_regis"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript">

        $("#btn_regis").click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            var files = $('#logo')[0].files[0];
            formData.append('file', files);
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_logo.php',
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
                            window.location = "?page=logo";
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