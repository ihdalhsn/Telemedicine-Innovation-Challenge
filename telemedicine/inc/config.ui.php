<?php
session_start();
//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_self",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/
if(!empty($_SESSION['level'])) {
if($_SESSION['level']=="pasien") {
	$page_nav = array(
		"dashboard" => array(
			"title" => "Dashboard",
			"icon" => "fa-home",
			"sub" => array(
				"monitoring" => array(
					"title" => "Monitoring",
					"url" => APP_URL."/monitoring.php?deviceid=".$_SESSION['deviceid']
				)
			)
		)

	);
}else if($_SESSION['level']=="dokter") {
	$page_nav = array(
		"dashboard" => array(
			"title" => "Dashboard",
			"icon" => "fa-home",
			"sub" => array(
				"listpasien" => array(
					"title" => "ListPasien",
					"url" => APP_URL."/datapasien.php"
				),
				"monitoring" => array(
					"title" => "Monitoring",
					"url" => APP_URL."/monitoring.php"
				)
			)
		)

	);
}
}

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>
