<?php
    
$servername = "hudsoncommunityschool.onlinejmc.com";
//$servername = "10.0.1.66";
$username = "datauser";
$password = "YgDEUFRb";
$dbname = "webjmc";

// Create connection
$conn = mysqli_init();
$conn->ssl_set('jmc',null,null,null,null);

//$conn = $mysqli->real_connect($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL);
mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sch.StuRefNum, sch.Courses, sch.Sections, sec.TermCode, crs.CourseName, sec.Period FROM 1516_schedulegrades sch JOIN 109_1516_coursesections sec ON sch.Courses = sec.CourseNum AND sch.Sections = sec.SectionID AND sec.IsInUse = 1 LEFT JOIN 109_1516_courses crs ON sch.Courses = crs.CourseNum WHERE sec.TermCode = 2 ORDER BY sch.StuRefNum";
$schedresult = $conn->query($sql);


if ($schedresult->num_rows > 0) {
   // output data of each row
   while($row = $schedresult->fetch_assoc()) {
      echo "Student #: " . $row["StuRefNum"]. " - Class: " . $row["Courses"]. " " . $row["Sections"] . " - " . $row["CourseName"] . "\n";
   }
}

$conn->close();

?>
