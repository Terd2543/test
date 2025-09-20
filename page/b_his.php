<div class="container-sm">
    <div class="card-body bg-white rounded border shadow ">
        <center><h2><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;ประวัติการเติมเงิน</h2></center>
        <hr>
            <div class="d-grid gap2">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อผู้ใช้</th>
                            <th scope="col">รายการ</th>
                            <th scope="col">จำนวนเงิน</th>
                            <th scope="col">เวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $i = 1;
                            $f = dd_q("SELECT * FROM boxlog ORDER BY date DESC");
                            while($row = $f->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td><?php echo htmlspecialchars($row['username']);?></td>
                            <td><?php echo $row['category'];?></td>
                            <td><?php echo number_format($row['price']);?> ฿</td>
                            <td><?php echo $row['date'];?></td>
                        </tr>
                        <?php $i++;} ?>
                        </tbody>
                    </table>
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