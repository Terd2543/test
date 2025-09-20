<?php 
    $st = dd_q("SELECT * FROM box_product");
    while($row = $st->fetch(PDO::FETCH_ASSOC)){
        $id = dd_q("SELECT * FROM box_stock WHERE p_id  = ? ", [$row['id']]);
        if($id->rowCount() == 0){
?>
    <div class="container-sm">
        <div class="card-body rounded border border-danger shadow " style="background-color: #EECDC6; border-radius: 20px!important;">
            <center><h4 class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;<b>[ สินค้า : <?php echo $row['name'];?> ] สต็อกหมดโปรดเพิ่มโดยเร็วที่สุด!!&nbsp;<i class="fa-solid fa-triangle-exclamation"></i></b></h4></center>
        </div>
    </div>
<?php 
        }
    }
?>