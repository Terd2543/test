<?php 
    if(isset($_GET['type']) && $_GET['type'] == "multi"){
?>
    <div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-plus"></i>&nbsp;เพิ่มสต็อก</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="row justify-content-center justify-content-lg-between">
                <div class="col-lg">
                    <a href="?page=s_add&type=single " class="btn btn-primary w-100">
                        เพิ่มรหัสทีละรหัส
                    </a>
                </div>
                <div class="col-lg">
                    <a href="?page=s_add&type=multi " class="btn btn-primary w-100">
                        เพิ่มรหัสทีละหลายรหัส
                    </a>
                </div>
                
            </div>
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="p_id"><h4><i class="fa-solid fa-box"></i>&nbsp;สินค้า</h4></label>
                    <select class="form-select form-select-lg" id="p_id">
                        <?php 
                            $q = dd_q("SELECT * FROM box_product ORDER BY id DESC");
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo htmlspecialchars($row['name']);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-2 mt-2 d-none">
                    <label for="user"><h4><i class="fa-solid fa-circle-question"></i>&nbsp;เปอร์เซ็นต์การออก</h4></label>
                    <input type="text" class="form-control form-control-lg" id="percentage" placeholder="มากที่สุด 100 % ใส่แค่ตัวเลข" value="100">
                </div>
                <div class="mb-2 mt-2">
                    <label for="user"><h4 class="mb-0"><i class="fa-solid fa-envelope"></i>&nbsp;ใส่สินค้า (ขึ้นบรรทัดใหม่นับเป็นสินค้าใหม่ทันที)</h4></label> <br>
                    <small>ขณะนี้นับสินค้าได้ <span id="count_stock">0</span> ชิ้น</small>
                    <textarea id="prize_name" class="form-control" rows="15" onkeyup="count_line()"></textarea>
                </div>
                <button class="btn btn-primary mb-2 mt-2 btn-lg" id="btn_regis"><i class="fa-solid fa-floppy-disk"></i>&nbsp;บันทึก</button>
            </div>
        </div>
    </div>
</div>
<script>
    function count_line(){
        var text = $("#prize_name").val();
        const myArray = text.split("\n");
        document.getElementById("count_stock").innerHTML = myArray.length - 1; 
    }
</script>
<script type="text/javascript">

        $("#btn_regis").click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('id'  , $("#p_id").val() );
            formData.append('percent'  , $("#percentage").val() );
            formData.append('prize_name'  , $("#prize_name").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_smulti.php',
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
<?php
    }else{
?>
    <div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-circle-plus"></i>&nbsp;เพิ่มสต็อก</h2></center>
        <hr>
        <div class="col-lg-6" style="margin: 0% auto;">
            <div class="row justify-content-center justify-content-lg-between">
                <div class="col-lg">
                    <a href="?page=s_add&type=single " class="btn btn-primary w-100">
                        เพิ่มรหัสทีละรหัส
                    </a>
                </div>
                <div class="col-lg">
                    <a href="?page=s_add&type=multi " class="btn btn-primary w-100">
                        เพิ่มรหัสทีละหลายรหัส
                    </a>
                </div>
                
            </div>
            <div class="d-grid gap2">
                <div class="mb-2 mt-2">
                    <label for="p_id"><h4><i class="fa-solid fa-box"></i>&nbsp;สินค้า</h4></label>
                    <select class="form-select form-select-lg" id="p_id">
                        <?php 
                            $q = dd_q("SELECT * FROM box_product ORDER BY id DESC");
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo htmlspecialchars($row['name']);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-2 mt-2">
                    <label for="user"><h4><i class="fa-solid fa-circle-question"></i>&nbsp;เปอร์เซ็นต์การออก</h4></label>
                    <input type="text" class="form-control form-control-lg" id="percentage" placeholder="มากที่สุด 100 % ใส่แค่ตัวเลข" >
                </div>
                <div class="mb-2 mt-2">
                    <label for="user"><h4><i class="fa-solid fa-envelope"></i>&nbsp;ของรางวัลที่ลูกค้าได้รับ</h4></label>
                    <input type="text" class="form-control form-control-lg" id="prize_name" placeholder="username : password" >
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
            formData.append('id'  , $("#p_id").val() );
            formData.append('percent'  , $("#percentage").val() );
            formData.append('prize_name'  , $("#prize_name").val() );
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/s_sadd.php',
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
<?php
    }
?>