<?php
session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Данные формы
$username = trim($_POST['username'] ?? '');
$count = $_POST['count'] ?? '';
$type = $_POST['type'] ?? '';
$delivery = $_POST['delivery'] ?? '';
$card = isset($_POST['card']) ? 'yes' : 'no';

$errors = [];
if (empty($username)) $errors[] = "Введите имя";
if (empty($count) || !is_numeric($count) || $count <= 0) $errors[] = "Количество должно быть числом > 0";
if (empty($type)) $errors[] = "Выберите вид букета";
if (empty($delivery)) $errors[] = "Выберите способ получения";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сохраняем форму в сессию
$_SESSION['username'] = htmlspecialchars($username);
$_SESSION['count'] = htmlspecialchars($count);
$_SESSION['type'] = htmlspecialchars($type);
$_SESSION['card'] = $card;
$_SESSION['delivery'] = htmlspecialchars($delivery);

// Сохраняем в файл
$line = "$username;$count;$type;$card;$delivery\n";
file_put_contents("data.txt", $line, FILE_APPEND | LOCK_EX);

// Cookie с последним заказом
setcookie("last_order", date('Y-m-d H:i:s'), time() + 3600, "/");

$url = "https://api.unsplash.com/photos/random?query=flowers&count=1&client_id=aw5SDknRpmJC0YiEw0kTqshwKuZiwBdEW70QtNQzvvQ";

$cacheFile = 'api_cache.json';
$cacheTtl = 300; // 5 минут

$api = new ApiClient();

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTtl) {
    $cached = json_decode(file_get_contents($cacheFile), true);
    $_SESSION['api_data'] = $cached;
} else {
    $apiData = $api->request($url);
    if (isset($apiData['error'])) {
        $_SESSION['api_error'] = "API недоступно: " . $apiData['error'];
    } else {
        file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
        $_SESSION['api_data'] = $apiData;
        unset($_SESSION['api_error']);
    }
}

header("Location: index.php");
exit();
