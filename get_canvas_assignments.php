<?php
    
    include 'canvas_funcs.php';
    
//    var_dump($argv);
    
    $canvas_course_num = $argv[1];
    date_default_timezone_set("America/Chicago");
    
    $js = get_canvas_assignments_by_course_id( $canvas_course_num );
    
    for ($i = 0; $i < count($js); $i++)
    {
        echo $i;
        echo " - ";
        echo $js[$i]["name"];
        echo " - ";
//        echo $js[$i]["created_at"];
//        echo " - ";
//        echo $js[$i]["updated_at"];
//        echo " - ";
//        echo $js[$i]["due_at"];
//        echo " - ";

        $createDate = date_create( $js[$i]["created_at"] );
        $dueDate = date_create( $js[$i]["due_at"] );
        $interval = date_diff($createDate, $dueDate);
        $numhours = $interval->h + $interval->days*24;
        echo $numhours;
//        echo $interval->format('%R');
//        echo $interval->days . " d " . $interval->hour . " h";
        echo PHP_EOL;
//        var_dump( $interval );

    }
    
    
    // Here endeth the main function
    
    ?>
