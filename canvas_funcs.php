<?php

// Get the Canvas Authorization Token.
// We need to strip the last char, because of... reasons, I guess?
// It might be a '/r', I suppose. I should really look at that sometime.
$fp = fopen("canvas.token", "r");
$tok = substr(fgets($fp),0,-1);
fclose($fp);

$options = array(
                "Authorization: Bearer " . $tok
        );

function get_canvas_user_by_sis_id( $sis_id ) {
   $url = "https://hudsonpiratepride.instructure.com/api/v1/users/sis_user_id:" . $sis_id;

   $js = get_canvas_response( $url );

   return $js;
}

function get_canvas_enrollments_by_user_id( $user_id ) {
   $url = "https://hudsonpiratepride.instructure.com/api/v1/users/" . $user_id . "/enrollments";

   $js = get_canvas_response( $url );

   return $js;
}

function get_canvas_assignments_by_course_id( $course_id ) {
   $url = "https://hudsonpiratepride.instructure.com/api/v1/courses/" . $course_id . "/assignments";
    
    echo $url . PHP_EOL;

   $js = get_canvas_response( $url );

   return $js;
}

function get_canvas_response( $url ) {
   global $options;

   $next_url = $url;
   $js = array();
   while( !empty($next_url) )
   {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $next_url );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
      curl_setopt($ch, CURLOPT_HEADER, true);
      $resp = curl_exec($ch);
      curl_close($ch);

      if (!empty($resp)) {
         // echo $resp;
         $headers = get_headers_from_curl_response($resp);
         $next_url = get_next_url_from_link($headers[Link]);
         $js = array_merge($js, json_decode(get_json_from_curl_response($resp), true));
      } else
         $next_url = '';
   }

   return $js;
}


function get_json_from_curl_response($response)
{
   return substr($response, strpos($response, "\r\n\r\n"));
}

function get_headers_from_curl_response($response)
{
    $headers = array();

    $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

    foreach (explode("\r\n", $header_text) as $i => $line)
        if ($i === 0)
            $headers['http_code'] = $line;
        else
        {
            list ($key, $value) = explode(': ', $line);

            $headers[$key] = $value;
        }

    return $headers;
}

function get_next_url_from_link($link)
{
   $next_url = "";

   foreach (explode(",", $link) as $i => $line)
   {
        //echo "\$link[$i] => $line.\n";
        if (endsWith($line, "rel=\"next\""))
        {
           $next_url = substr($line, strpos($line, "<")+1);
           $next_url = substr($next_url, 0, strpos($line, ">")-1);
        }
   }
   // echo "Next = $next_url\n";


   return $next_url;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}


?>
