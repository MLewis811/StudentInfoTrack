<?php

$mydb_server = '10.0.1.66';
$mydb_username = 'root';
$mydb_password = 'pi';
$mydb_dbname = 'SIS_INFO';


function mydb_query($sql) {
  global $mydb_server, $mydb_username, $mydb_password, $mydb_dbname;
  $mydb_conn = mysqli_init();
  mysqli_real_connect($mydb_conn, $mydb_server, $mydb_username, $mydb_password, $mydb_dbname, 3306);
  // Check connection
  if ($mydb_conn->connect_error) {
      die("Connection failed: " . $mydb_conn->connect_error);
  }

  $result = $mydb_conn->query($sql);

  $mydb_conn->close();

  return $result;
}

?>
