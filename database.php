<?php

header("Content-Type: application/json");

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

$sql = "SELECT id, title, descriptio, thumbnail_url, duration, genres, age, uploaded_at, video_url, director, cast, visibility FROM Videos";
$result = mysqli_query($conn, $sql);

$videos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $img = file_get_contents($row["thumbnail_url"]);
    $row["thumbnail_url"] = base64_encode($img);
    $videos[] = $row;
}

echo json_encode($videos);

mysqli_close($conn);
