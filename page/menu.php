<?php 
    $d = dd_q("SELECT SUM(amount) AS sum_val FROM topup_his WHERE date >  DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $topup = $d->fetch(PDO::FETCH_ASSOC);
    $d = dd_q("SELECT * FROM boxlog WHERE date >  DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $box = $d->rowCount();
    $d = dd_q("SELECT * FROM users");
    $usr = $d->rowCount();
        
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-sm">
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card">
            <center><h5 class="card-header bg-light text-dark">฿ ยอดการเปิดกล่องในเดือนนี้</h5></center>
                <div class="card-body bg-light text-dark bg-gradient">
                    <center>
                        <h2 data-target="<?php echo $box;?>" id="count"></h2>
                        <h2>รายการ</h2>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card">
            <center><h5 class="card-header bg-light text-dark bg-gradient">฿ ยอดการเติมเงินในเดือนนี้</h5></center>
                <div class="card-body bg-light text-dark bg-gradient">
                    <center>
                        <h2 data-target="<?php echo $topup['sum_val']; ?>" id="count"></h2>
                        <h2>บาท</h2>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card">
            <center><h5 class="card-header bg-light text-dark bg-gradient"><i class="fa-solid fa-user"></i>&nbsp;จำนวนผู้ใช้</h5></center>
                <div class="card-body bg-light text-dark bg-gradient">
                    <center>
                        <h2 data-target="<?php echo $usr;?>" id="count"></h2>
                        <h2>คน</h2>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="system/countup.js"></script>