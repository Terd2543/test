<?php 
  require_once("system/a_func.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Admin Page </title>
    <!-- Boxiocns CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7899b79184.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"> </script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
   </head>
<body style="background-color: #E4E9F7;" <?php if(!isset($_SESSION['admin'])){
  echo "class='bg-dark'"; 
}?>>
  <?php 
    if(isset($_SESSION['admin'])){
  ?>
  <div class="sidebar close">
    <div class="logo-details">
      <i class='bx bx-code-alt'></i>
      <span class="logo_name">Admin Page</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="?page=menu">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">หน้าแดชบอร์ด</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">หมวดหมู่ทั่วไป</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-collection' ></i>
            <span class="link_name">ทั่วไป</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">ทั่วไป</a></li>
          <li><a href="?page=setting">การตั้งค่าทั่วไป</a></li>
          <li><a href="?page=about">เกี่ยวกับร้านค้า</a></li>
          <li><a href="?page=logo">โลโก้ร้านค้า</a></li>
        </ul>
      </li>
      <!--  -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-history' ></i>
            <span class="link_name">ประวัติ</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="" href="?page=b_his">ประวัติการสั่งซื้อ</a></li>
          <li><a href="?page=t_his">ประวัติการเติมเงิน</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-user' ></i>
            <span class="link_name">สมาชิก</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="" href="?page=u_edit">แก้ไขสมาชิก</a></li>
        </ul>
      </li>
      <!--  -->
      <!--  -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-solid fa-box"></i>
            <span class="link_name">สินค้า</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a href="?page=c_add">[C] เพิ่มหมวดหมู่</a></li>
          <li><a href="?page=c_edit">[C] แก้ไขหมวดหมู่</a></li>
          <li><a href="?page=p_add">[B] เพิ่มสินค้า</a></li>
          <li><a href="?page=p_edit">[B] แก้ไขสินค้า</a></li>
          <li><a href="?page=s_add">[S] เพิ่มสต็อก</a></li>
          <li><a href="?page=s_edit">[S] แก้ไขสต็อก</a></li>
        </ul>
      </li>
      <!--  -->
      <li>
        <div class="iocn-link">
          <a href="#">
          <i class='bx bx-code-alt'></i>
            <span class="link_name">แอดมิน</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a href="?page=a_edit">เปลี่ยนรหัสผ่าน</a></li>
        </ul>
      </li>
      <li>
        <a href="?page=menu">
          <i class='bx bx-log-out' id="log_out" ></i>
          <span class="link_name">ออกจากระบบ</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">ออกจากระบบ</a></li>
        </ul>
      </li>
      <li class="profile">
         <div class="profile-details">
           <!--<img src="profile.jpg" alt="profileImg">-->
           <div class="name_job">

            <span class="text-white ms-2">Admin</span>
           </div>
         </div>
     </li>

  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Admin Panel</span>
    </div>
      <?php 
            if(isset($_GET['page']) && $_GET['page'] == "menu"){
              require_once('page/menu.php');
              require_once('page/stock.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "about"){
              require_once('page/stock.php');
              require_once('page/about.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "logo"){
              require_once('page/stock.php');
              require_once('page/logo.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "setting"){
              require_once('page/stock.php');
              require_once('page/setting.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "u_edit"){
              require_once('page/stock.php');
              require_once('page/u_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "t_his"){
              require_once('page/menu.php');
              require_once('page/stock.php');
              require_once('page/t_his.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "b_his"){
              require_once('page/menu.php');
              require_once('page/stock.php');
              require_once('page/b_his.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "p_add"){
              require_once('page/stock.php');
              require_once('page/p_add.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "p_edit"){
              require_once('page/stock.php');
              require_once('page/p_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "c_add"){
              require_once('page/stock.php');
              require_once('page/c_add.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "c_edit"){
              require_once('page/stock.php');
              require_once('page/c_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "s_add"){
              require_once('page/stock.php');
              require_once('page/s_add.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "s_edit"){
              require_once('page/stock.php');
              require_once('page/s_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "a_edit"){
              require_once('page/stock.php');
              require_once('page/a_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "id_edit"){
              require_once('page/stock.php');
              require_once('page/id_edit.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "id_add"){
              require_once('page/stock.php');
              require_once('page/id_add.php');
            }elseif(isset($_GET['page']) && $_GET['page'] == "logout"){
              session_destroy();
              require_once('page/login.php');
            }else{
              require_once('page/menu.php');
              require_once('page/stock.php');
            }
        ?>
  </section>
  <?php  
    }else{
      require_once('page/login.php');
    }
  ?>


  <script src="script.js"></script>

</body>
</html>