<?php 
    function checktype(){
        if(isset($_GET['type']) && $_GET['type'] == "id")
        { 
            return "s_caid.php"; 
        }
        elseif(isset($_GET['type']) && $_GET['type'] == "gp"){
            return "s_cagp.php"; 
        }else{ 
            return "s_cadd.php"; 
        }
    }
?>
<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-plus"></i>&nbsp;เพิ่มหมวดหมู่</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="txt_w_pic"><h4><i class="fa-solid fa-image"></i>&nbsp;ลิงค์รูปภาพ</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_w_pic" placeholder="ลิงค์รูปภาพ" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="txt_w_name"><h4><i class="fa-solid fa-shapes"></i>&nbsp;ชื่อหมวดหมู่</h4></label>
                    <input type="text" class="form-control form-control-lg" id="txt_w_name" placeholder="ชื่อหมวดหมู่" >
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
            formData.append('txt_name'  , $("#txt_w_name").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/<?php echo checktype();?>',
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
                        window.location = "?page=<?php echo $_GET['page']; if (isset($_GET['type'])){
                echo "&type=".$_GET['type'];
            }
                ?>";
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