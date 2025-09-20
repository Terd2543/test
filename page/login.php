<style>
    label{
        margin-bottom: 7px;
    }
</style>
<div class="conatiner-sm">
    <div class="col-lg-4 position-absolute top-50 start-50 translate-middle" >
        <div class="card-body shadow  rounded border text-white"style="margin: 0% auto;">
            <center style="margin-bottom: 2em;">
                <h2 ><i class="fa-solid fa-lock"></i>&nbsp;Admin Login</h2>
            </center>
            <div class="text-secondary">
                <div class="mb-2 mt-2">
                    <label for="username"><i class="fa-solid fa-user"></i>&nbsp;Username</label>
                    <input type="text" class="form-control form-control-lg bg-dark text-white" id="username">
                </div>
                <div class="mb-3 mt-2">
                    <label for="username"><i class="fa-solid fa-key"></i>&nbsp;Password</label>
                    <input type="password" class="form-control form-control-lg bg-dark text-white" id="password">
                </div>
                <center>
                <div id="capcha" class="g-recaptcha" data-theme="light" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                </center>
                <div class="mt-4">
                    <div class="d-grid gap2">
                        <button id="btn_regis" class="btn btn-lg btn-light"><i class="fa-solid fa-right-to-bracket"></i>&nbsp;Log In</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
</script>
<script type="text/javascript">

    var onloadCallback = function() {
    grecaptcha.render('capcha', {
        'sitekey' : '<?php echo $conf['sitekey'];?>'
    });
    };
    $("#btn_regis").click(function(e) {
          e.preventDefault();
          var formData = new FormData();
          formData.append('user', $("#username").val());
          formData.append('pass', $("#password").val());
          captcha = grecaptcha.getResponse();
          formData.append('captcha', captcha);
          $('#btn_regis').attr('disabled', 'disabled');
          $.ajax({
              type: 'POST',
              url: 'system/login.php',
              data:formData,
              contentType: false,
              processData: false,
          }).done(function(res){
              
              result = res;
              console.log(result);
              grecaptcha.reset();
              if(res.status == "success"){
                  Swal.fire({
                      icon: 'success',
                      title: 'สำเร็จ',
                      text: result.message
                  }).then(function() {
                          window.location = "?page=home";
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
              grecaptcha.reset();
              Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  text: res.message
              })
              //console.clear();
              $('#btn_regis').removeAttr('disabled');
          });
    });
    $(function(){
        function rescaleCaptcha(){
            var width = $('.g-recaptcha').parent().width();
            var scale;
            if (width < 302) {
            scale = width / 302;
            } else{
            scale = 1.0; 
            }

            $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
            $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
            $('.g-recaptcha').css('transform-origin', '0 0');
            $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
        }

    rescaleCaptcha();
    $( window ).resize(function() { rescaleCaptcha(); });

    });
</script>