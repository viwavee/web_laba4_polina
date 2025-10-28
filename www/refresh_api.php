<?php
session_start();
require_once 'ApiClient.php';

$url = "https://api.unsplash.com/photos/random?query=flowers&count=1&client_id=aw5SDknRpmJC0YiEw0kTqshwKuZiwBdEW70QtNQzvvQ";
$cacheTtl = 300; // 5 минут
$api = new ApiClient();

header('Content-Type: application/json');

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTtl) {
    $cached = json_decode(file_get_contents($cacheFile), true);
    echo json_encode(['photos' => $cached]);
} else {
    $apiData = $api->request($url);
    if (isset($apiData['error'])) {
        echo json_encode(['error' => $apiData['error']]);
    } else {
        file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
        echo json_encode(['photos' => $apiData]);
    }
}
