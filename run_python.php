<?php 
  echo "This script will run python file";
  echo "\n";
  // Execute python script
  // $pyscript = 'C:/xampp/htdocs/tic-api/python/testing.py';
  $pyscript = 'C:/xampp/htdocs/tic-api/python/algorithm.py';
  $python   = 'C:/Python27/python.exe';
  $command  = escapeshellcmd($python.' '.$pyscript);
  $output   = shell_exec($command);
  echo $output;

  //Create csv file from list of data 
  $list = array (
    array('-0.234'),
    array('1.2983'),
    array('-0.293'),
    array('2.383')
  );

  $fp = fopen('python/data/ecg_data.csv', 'w');

  foreach ($list as $fields) {
      fputcsv($fp, $fields);
  }

  fclose($fp);

?>