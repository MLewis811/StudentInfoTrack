<?php

$jmc_servername = "hudsoncommunityschool.onlinejmc.com";
$jmc_username = "datauser";
$jmc_password = "YgDEUFRb";
$jmc_dbname = "webjmc";

function jmc_query($sql) {
   global $jmc_servername, $jmc_username, $jmc_password, $jmc_dbname;
   $jmc_conn = mysqli_init();
   $jmc_conn->ssl_set('jmc',null,null,null,null);
   echo "HEY!!! - " . $sql . PHP_EOL;
   mysqli_real_connect($jmc_conn, $jmc_servername, $jmc_username, $jmc_password, $jmc_dbname, 3306, null, MYSQLI_CLIENT_SSL);
   // Check connection
   if ($jmc_conn->connect_error) {
       die("Connection failed: " . $jmc_conn->connect_error);
   }

   $result = $jmc_conn->query($sql);

   $jmc_conn->close();

   return $result;
}

?>

