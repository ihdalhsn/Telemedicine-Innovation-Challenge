
<?php

	  $get1=  array('param1'=>$_GET['param1'],'param2'=>$_GET['param2']);
		$jsondht11 = json_encode($get1);
		echo $jsondht11;
	  $nyimpenhasil = "hasil/data.json";
		$eksekusi = fopen($nyimpenhasil, 'a') or die("ga bisa buka file");
		fwrite($eksekusi,"\n".$jsondht11);
		fclose($eksekusi);




?>
