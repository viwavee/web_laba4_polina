<?php
session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// Получаем данные из формы
$username = trim($_POST['username'] ?? '');
$count = $_POST['count'] ?? '';
$type = $_POST['type'] ?? '';
$delivery = $_POST['delivery'] ?? '';
$card = isset($_POST['card']) ? 'yes' : 'no';

$errors = [];

// Проверки
if (empty($username)) $errors[] = "Введите имя";
if (empty($count) || !is_numeric($count) || $count <= 0) $errors[] = "Количество должно быть числом > 0";
if (empty($type)) $errors[] = "Выберите вид букета";
if (empty($delivery)) $errors[] = "Выберите способ получения";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сохраняем в сессию
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

// --- Работа с API Unsplash ---
//$client_id = "aw5SDknRpmJC0YiEw0kTqshwKuZiwBdEW70QtNQzvvQ"; // 🔑 ← сюда вставь свой ключ с Unsplash
$url = "https://api.unsplash.com/photos/random?query=flowers&count=1&client_id=aw5SDknRpmJC0YiEw0kTqshwKuZiwBdEW70QtNQzvvQ";

$api = new ApiClient();
$apiData = $api->request($url);
$_SESSION['api_data'] = $apiData;

header("Location: index.php");
exit();
