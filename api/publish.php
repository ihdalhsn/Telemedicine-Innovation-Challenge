<?php 
//publish.php
  require("phpMQTT.php");

  $host = " m13.cloudmqtt.com"; 
  $port =   17430;
  $username = " kuqkvnay"; 
  $password = "oO_jJyWQ5VCh"; 
  $message = "Hello CloudMQTT! by husna";

  //MQTT client id to use for the device. "" will generate a client id automatically
  $mqtt = new phpMQTT($host, $port, "ClientID".rand()); 

  if ($mqtt->connect(true,NULL,$username,$password)) {
    $mqtt->publish("topic",$message, 0);
    $mqtt->close();
  }else{
    echo "Fail or time out<br />";
  }
?>