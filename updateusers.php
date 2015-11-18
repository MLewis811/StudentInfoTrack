<?php

include 'mydb_funcs.php';    
include 'jmc_funcs.php';    
include 'canvas_funcs.php';    

$sql = "SELECT * FROM students";
$mydb_result = mydb_query($sql);


if ($mydb_result->num_rows > 0) {
    while($row = $mydb_result->fetch_assoc()) {
	if (empty($row["jmc_stu_ref_num"])) {
	   $sql = "SELECT * FROM 1516_students WHERE StudentID=" . $row["stu_id"];
	   $sturesult = jmc_query($sql);
	   while ($sturow = $sturesult->fetch_assoc()) {
	      echo $sturow["StuRefNum"] . " - " . $row["stu_id"] . "\n";
	      $sql = "UPDATE students SET jmc_stu_ref_num=" . $sturow["StuRefNum"] . " WHERE stu_id=" . $row["stu_id"];
	      mydb_query($sql);
	   }
	}
    }
}

$sql = "SELECT * FROM students ";
$mydb_result = mydb_query($sql);

if ($mydb_result->num_rows > 0) {
    while($row = $mydb_result->fetch_assoc()) {
	if (empty($row["canvas_stu_num"])) {
	   $sis_stu_id = $row["stu_first_name"] . "." . $row["stu_last_name"];
	   $sis_stu_id = strtolower($sis_stu_id);
	   echo $sis_stu_id . PHP_EOL;
           $js = get_canvas_user_by_sis_id($sis_stu_id);
           if (array_key_exists("error_report_id", $js))
              echo "User " . $sis_stu_id . " does not exist in Canvas.\n";
           else {
              $canv_stu_num = $js["id"];
              $sql = "UPDATE students SET canvas_stu_num=" . $canv_stu_num . " WHERE stu_id=" . $row["stu_id"];
              mydb_query($sql);
           }
	}
    }
}

?>
