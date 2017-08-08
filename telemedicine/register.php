<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Register";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page");
include("inc/header.php");


$result = mysqli_query($mysqli, "SELECT * FROM data_dokter order by id_dokter desc");

if( isset($_POST['submit']) )
{
  $namapasien = $_POST['nama_pasien'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $deviceid = $_POST['device_id'];
  $alamat = $_POST['alamat'];
  $jeniskelamin = $_POST['jenis_kelamin'];
  $dokter = $_POST['dokter'];


  mysqli_query($mysqli, "INSERT INTO data_pasien(nama_pasien, email, password, device_id , alamat , jenis_kelamin , id_dokter) VALUES('$namapasien', '$email', md5('$pass'),'$deviceid','$alamat','$jeniskelamin','$dokter')")
    or die(mysqli_error($mysqli));

		echo '<script type="text/javascript">window.location.href="index.php?terdaftar";</script>';
		die();

}
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
		<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
		<header id="header">
			<!--<span id="logo"></span>-->

			<div id="logo-group">
				<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

				<!-- END AJAX-DROPDOWN -->
			</div>

			<span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Sudah punya akun?</span> <a href="<?php echo APP_URL; ?>" class="btn btn-danger">Masuk</a> </span>

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 hidden-xs hidden-sm">
						<h1 class="txt-color-red login-header-big">Rhythm</h1>
						<div class="hero">

							<div class="pull-left login-desc-box-l">
								<h4 class="paragraph-header">Your Arythmia Personal Care</h4>
							</div>

							<img src="<?php echo ASSETS_URL; ?>/img/demo/iphoneview.png" alt="" class="pull-right display-image" style="width:210px">

						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">About Rhythm</h5>
								<p>
									Your Arythmia Personal Care
								</p>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h5 class="about-heading">About Rhythm</h5>
								<p>
								Your Arythmia Personal Care
							</p>
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="well no-padding">

							<form action="" id="form-register-pasien" class="smart-form client-form" method="post">
								<header>
									Buat akun baru
								</header>

								<fieldset>
									<section>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="nama_pasien" placeholder="Nama Pasien">
											<b class="tooltip tooltip-bottom-right">Dibutuhkan untuk melengkapi data pasien</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<input type="email" name="email" placeholder="Email address">
											<b class="tooltip tooltip-bottom-right">Dibutuhkan untuk masuk ke aplikasi ini</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" placeholder="Password" id="password">
											<b class="tooltip tooltip-bottom-right">Jangan lupa password anda</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="passwordConfirm" placeholder="Confirm password">
											<b class="tooltip tooltip-bottom-right">Jangan lupa password anda</b> </label>
									</section>

								</fieldset>

								<fieldset>
									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="text" name="device_id" placeholder="Device ID">
											<b class="tooltip tooltip-bottom-right">Dibutuhkan untuk mensingkronkan aplikasi dengan alat</b> </label>
									</section>
									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="text" name="alamat" placeholder="Alamat">
											<b class="tooltip tooltip-bottom-right">Dibutuhkan untuk verifikasi data</b> </label>
									</section>

									<section>
										<label class="select">
											<select name="jenis_kelamin">
												<option value="0" selected="" disabled="">Jenis Kelamin</option>
												<option value="Laki-laki">Laki-laki</option>
												<option value="Perempuan">Perempuan</option>
											</select> <i></i> </label>
									</section>

									<section>
										<label class="select">
											<select name="dokter">
											<option value="0" selected="" disabled="">Dokter</option>
												<?php
												while($res = mysqli_fetch_array($result)) {
												echo "<option value=\"$res[id_dokter]\">$res[nama_dokter]</option>";
											} ?>
											</select> <i></i> </label>
									</section>

								</fieldset>
								<footer>
									<button name="submit" type="submit" class="btn btn-primary">
										Buat akun
									</button>
								</footer>
							</form>

						</div>
					</div>
				</div>
			</div>

		</div>


<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S)
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();


	// Validation
	$(function() {
		// Validation
		$("#form-register-pasien").validate({

			// Rules for form validation
			rules : {
				nama_pasien : {
					required : true
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					required : true,
					minlength : 3,
					maxlength : 20,
					equalTo : '#password'
				},
				device_id : {
					required : true
				},
				alamat : {
					required : true
				},
				jenis_kelamin : {
					required : true
				},
				dokter : {
					required : true
				}
			},

			// Messages for form validation
			messages : {
				login : {
					required : 'Please enter your login'
				},
				email : {
					required : 'Mohon untuk memasukan email anda',
					email : 'Mohon untuk memasukan email yang valid'
				},
				password : {
					required : 'Mohon untuk memasukan kata sandi anda'
				},
				passwordConfirm : {
					required : 'Mohon untuk masukan kata sandi anda lagi',
					equalTo : 'kata sandi anda tidak cocok'
				},
				device_id : {
					required : 'Mohon untuk memasukan device id anda'
				},
				nama_pasien : {
					required : 'Mohon untuk memasukan nama anda'
				},
				alamat : {
					required : 'Mohon untuk memasukan alamat anda'
				},
				jenis_kelamin : {
					required : 'Mohon untuk memilih jenis kelamin anda'
				},
				dokter : {
					required : 'Mohon untuk memilih dokter anda'
				}
			},

			// Ajax form submition
			submitHandler : function(form) {
				$(form).ajaxSubmit({
					success : function() {
						$("#form-register-pasien").addClass('submited');
					}
				});
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

	});
</script>

<?php
	//include footer
	include("inc/google-analytics.php");
?>
