<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="http://localhost/diskominfosan/public/assets/logo.png">

  <!-- Vendor CSS Files -->
  <link href="/assets/bizland/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/bizland/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="/assets/bizland/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/bizland/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="/assets/bizland/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="/assets/bizland/vendor/aos/aos.css" rel="stylesheet">
  <!-- daterange picker -->
  <link rel="stylesheet" href="/assets/adminlte3/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/assets/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Template Main CSS File -->
  <link href="/assets/bizland/css/style.css" rel="stylesheet">
  <!-- Icon Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


  <!-- WEBCAM -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js">
  <!-- =======================================================
  * Template Name: BizLand - v1.1.0
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <!-- fitur rechaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    function onSubmit(token) {
      document.getElementById("loginForm").submit();
    }
  </script>
</head>

<body>
  <main id="main">

    <!-- ======= Pendaftaran ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2><span>Daftar Akun</span></h2>
          <p>Aplikasi Pendaftaran Magang Mahasiswa - DISKOMINFOSAN</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
            <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1" style="width: 400px; height: 400px;" loop autoplay></lottie-player>
          </div>

          <div class="col-lg-6">
            <form id="formPendaftaran" role="form" class="php-email-form">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="icofont-users-alt-5"></i></span>
                </div>
                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" autofocus />
                <p class="text-danger">*</p>
              </div>
              <small id="nama_error" class="form-text text-danger mb-3"></small>

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="icofont-email"></i></span>
                </div>
                <input type="text" class="form-control" name="email" placeholder="Email" />
              </div>
              <small id="email_error" class="form-text text-danger mb-3"></small>

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i id="show-password" class="icofont-eye-blocked"></i></span>
                </div>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
              </div>
              <p class="text-danger mt-2">**Password Minimal 8 Karakter</p>
              <small id="password_error" class="form-text text-danger mb-3"></small>

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i id="show-confirmpassword" class="icofont-eye-blocked"></i></span>
                </div>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" />
              </div>
              <small id="confirm_password_error" class="form-text text-danger mb-3"></small>

              <div class="text-center mb-2">
                <button class="col-lg" type="submit" id="btn-pendaftaran">Daftar</button>
              </div>
              <p class="mb-2 text-center">
                <a href="<?php echo base_url('login'); ?>">Sudah punya akun? Silahkan Login!</a>
              </p>
            </form>
          </div>

        </div>

      </div>
    </section>

  </main>
  <!-- Vendor JS Files -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <script src="/assets/bizland/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/bizland/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/bizland/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="/assets/bizland/vendor/php-email-form/validate.js"></script>
  <script src="/assets/bizland/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="/assets/bizland/vendor/counterup/counterup.min.js"></script>
  <script src="/assets/bizland/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="/assets/bizland/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/assets/bizland/vendor/venobox/venobox.min.js"></script>
  <script src="/assets/bizland/vendor/aos/aos.js"></script>
  <!-- Sweetalert 2 -->
  <script src="/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="/assets/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- InputMask -->
  <script src="/assets/adminlte3/plugins/moment/moment.min.js"></script>
  <script src="/assets/adminlte3/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- date-range-picker -->
  <script src="/assets/adminlte3/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/assets/adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Template Main JS File -->
  <script src="/assets/bizland/js/main.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>

  <script>
    $(document).ready(function() {

      //Show Password
      $('#show-password').on('click', function() {
        if ($(this).hasClass('icofont-eye-blocked')) {
          $('#password').attr('type', 'text');
          $(this).removeClass('icofont-eye-blocked');
          $(this).addClass('icofont-eye');
        } else {
          $('#password').attr('type', 'password');
          $(this).removeClass('icofont-eye');
          $(this).addClass('icofont-eye-blocked');
        }
      });
      //-------------------------------------------------------------------

      //Show Confirm Password
      $('#show-confirmpassword').on('click', function() {
        if ($(this).hasClass('icofont-eye-blocked')) {
          $('#confirm_password').attr('type', 'text');
          $(this).removeClass('icofont-eye-blocked');
          $(this).addClass('icofont-eye');
        } else {
          $('#confirm_password').attr('type', 'password');
          $(this).removeClass('icofont-eye');
          $(this).addClass('icofont-eye-blocked');
        }
      });
      //-------------------------------------------------------------------

      //Submit pendaftaran user
      $('#btn-pendaftaran').on('click', function() {
        const formPendaftaran = $('#formPendaftaran');

        $.ajax({
          url: "pendaftaran/daftarAkun",
          method: "POST",
          data: formPendaftaran.serialize(),
          dataType: "JSON",
          success: function(data) {
            //Data Error
            if (data.error) {
              if (data.daftar_akun_error['nama'] != '') $('#nama_error').html(data.daftar_akun_error['nama']);
              else $('#nama_error').html('');

              if (data.daftar_akun_error['email'] != '') $('#email_error').html(data.daftar_akun_error['email']);
              else $('#email_error').html('');

              if (data.daftar_akun_error['password'] != '') $('#password_error').html(data.daftar_akun_error['password']);
              else $('#password_error').html('');

              if (data.daftar_akun_error['confirm_password'] != '') $('#confirm_password_error').html(data.daftar_akun_error['confirm_password']);
              else $('#confirm_password_error').html('');
            }

            //Pendaftaran Sukses
            if (data.success) {
              formPendaftaran.trigger('reset');
              $('#nama_error').html('');
              $('#email_error').html('');
              $('#password_error').html('');
              $('#confirm_password_error').html('');
              Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil!',
                showConfirmButton: false,
                timer: 1500
              });
              window.location.replace(data.link);
            }

          }

        });

      });
      //-------------------------------------------------------------------

    });
  </script>
</body>

</html>