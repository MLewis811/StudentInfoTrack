<?php

include 'canvas_funcs.php';
include 'mydb_funcs.php';



$sql = "SELECT * FROM students WHERE canvas_stu_num IS NOT NULL";
$mydb_student = mydb_query( $sql );
if ($mydb_student->num_rows > 0) {
while ($student_row = $mydb_student->fetch_assoc()) {
$js = get_canvas_enrollments_by_user_id( $student_row["canvas_stu_num"] );
$stu_id = $student_row["stu_id"];

for ($i = 0; $i < count($js); $i++)
{
   // echo $i . " - " . $js[$i]["sis_section_id"] . PHP_EOL;

   $sql = "SELECT * FROM canvas_classes WHERE canvas_sis_section_id=\"" . $js[$i]["sis_section_id"] . "\"";
   $mydb_result = mydb_query( $sql );

   if ($mydb_result->num_rows > 0) {
      while($class_row = $mydb_result->fetch_assoc()) {
	$sql = "SELECT * FROM canvas_schedules WHERE stu_id=" . $stu_id . " AND canvas_section_id=" . $class_row["canvas_section_id"];
	$mydb_schedrecord = mydb_query( $sql );
	if ($mydb_schedrecord->num_rows == 0) {
	   $sql = "INSERT INTO canvas_schedules (stu_id, canvas_section_id) VALUES (" . $stu_id . "," . $class_row["canvas_section_id"] . ")";
	   $mydb_insert = mydb_query( $sql );
	   // echo $sql . PHP_EOL;
        }
      }
   }

}
}
}

// Here endeth the main function

?>
