<?php


$servername = "127.0.0.1";
$username = "root";
$password = "þor";
$dbname = "video";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => mysqli_connect_error()]);
    exit;
}

$sql = "SELECT id, title, thumbnail_url, FROM Videos";
$result = mysqli_query($conn, $sql);

$videos = [];

header("Content-Type: image/png");
while ($row = mysqli_fetch_assoc($result)) {
    $videos[] = $row["title"].$row["thumbnail_url"];
}

echo json_encode($videos);

mysqli_close($conn);
