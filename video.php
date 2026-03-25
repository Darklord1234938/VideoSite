<?php

header("Content-Type: application/json");

$servername = "127.0.0.1";
$username = "root";
$password = "þor";
$dbname = "video";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$title = "";
if(isset($_POST["title"])){$title = $_POST["title"];}

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => mysqli_connect_error()]);
    exit;
}

$sql = "SELECT id, video_url, visibility FROM Videos WHERE title = '$title' ";
$result = mysqli_query($conn, $sql);

$videos = [];

$path = $result["video_url"];
$size = filesize($path);
$length = $size;
$start = 0;
$end = $size - 1;

if (isset($_SERVER['HTTP_RANGE'])) {
    $range = $_SERVER['HTTP_RANGE'];
    list(, $range) = explode('=', $range, 2);
    if (strpos($range, ',') !== false) {
        header('HTTP/1.1 416 Requested Range Not Satisfiable');
        exit;
    }
    if ($range == '-') {
        $start = $size - substr($range, 1);
    } else {
        $range = explode('-', $range);
        $start = $range[0];
        $end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size - 1;
    }
    $length = $end - $start + 1;
    header('HTTP/1.1 206 Partial Content');
} else {
    header('HTTP/1.1 200 OK');
}

header("Content-Type: video/mp4");
header("Accept-Ranges: bytes");
header("Content-Length: $length");
header("Content-Range: bytes $start-$end/$size");

$fp = fopen($path, 'rb');
fseek($fp, $start);
$bufferSize = 8192;
while(!feof($fp) && ($pos = ftell($fp)) <= $end) {
    if ($pos + $bufferSize > $end) {
        $bufferSize = $end - $pos + 1;
    }
    echo fread($fp, $bufferSize);
    flush();
}
fclose($fp);
exit;

echo json_encode("");

mysqli_close($conn);

