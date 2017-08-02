<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
	<!--<span id="logo"></span>-->

	<div id="logo-group">
		<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

		<!-- END AJAX-DROPDOWN -->
	</div>

	<span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Tidak punya akun?</span> <a href="<?php echo APP_URL; ?>/register.php" class="btn btn-danger">Buat Akun</a> </span>

</header>

<div id="main" role="main">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<h1 class="txt-color-red login-header-big">Rhythm</h1>
				<div class="hero">

					<div class="pull-left login-desc-box-l">
						<h4 class="paragraph-header">Your Arythmia Personal Care</h4>
					</div>

					<img src="<?php echo ASSETS_URL; ?>/img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

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
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<?php
				if(!empty($_SESSION['level'])) {
					if($_SESSION['level']=="pasien") {
						echo '<script type="text/javascript">window.location.href="monitoring.php";</script>';
					}else if($_SESSION['level']=="dokter") {
						echo '<script type="text/javascript">window.location.href="datapasien.php";</script>';
					}
				}

				if(isset($_POST['submit'])) {
					$user = mysqli_real_escape_string($mysqli, $_POST['email']);
					$pass = mysqli_real_escape_string($mysqli, $_POST['password']);


						$result = mysqli_query($mysqli, "SELECT * FROM data_pasien WHERE email='$user' AND password=md5('$pass')")
									or die("Could not execute the select query.");

						$result2 = mysqli_query($mysqli, "SELECT * FROM data_dokter WHERE email='$user' AND password=md5('$pass')")
												or die("Could not execute the select query.");


						$row = mysqli_fetch_assoc($result);
						$row2 = mysqli_fetch_assoc($result2);

						if(is_array($row) && !empty($row)) {
							$_SESSION['namapasien'] = $row['nama_pasien'];
							$_SESSION['idpasien'] = $row['id_pasien'];
							$_SESSION['deviceid'] = $row['device_id'];
							$_SESSION['level'] = "pasien";
							echo '<script type="text/javascript">window.location.href="monitoring.php?deviceid='.$_SESSION['deviceid'].'";</script>';
						}else if(is_array($row2) && !empty($row2)) {
							$_SESSION['namadokter'] = $row2['nama_dokter'];
							$_SESSION['iddokter'] = $row2['id_dokter'];
							$_SESSION['level'] = "dokter";
							echo '<script type="text/javascript">window.location.href="datapasien.php";</script>';
						}else{?>
							<div class="alert alert-danger fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-check"></i>
								<strong>Error</strong> Email / password anda salah , mohon untuk login kembali.
							</div>

					<?php	}
				}

				?>

				<?php
				if(isset($_GET["terdaftar"])){
				?>
				<div class="alert alert-success fade in">
					<button class="close" data-dismiss="alert">
						×
					</button>
					<i class="fa-fw fa fa-check"></i>
					<strong>Berhasil</strong> Akun telah dibuat silahkan login.
				</div>

				<?php }?>
				<div class="well no-padding">
					<form action="" id="login-form" method="post" class="smart-form client-form">
						<header>
							Masuk
						</header>

						<fieldset>

							<section>
								<label class="label">E-mail</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="email" name="email">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Mohon masukkan email/username andae</b></label>
							</section>

							<section>
								<label class="label">Kata sandi</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Mohon masukkan kata sandi anda</b> </label>
								<div class="note">
									<a href="<?php echo APP_URL; ?>/forgotpassword.php">Lupa password?</a>
								</div>
							</section>

						</fieldset>
						<footer>
							<button name="submit" type="submit" class="btn btn-primary">
								Masuk
							</button>
						</footer>
					</form>

				</div>

			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S)
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				}
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
