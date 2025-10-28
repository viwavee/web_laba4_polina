<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все заказы</title>
</head>
<body>
<h2>Все сохранённые заказы:</h2>
<ul>
<?php
if (file_exists("data.txt")) {
    $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) {
        echo "<li>Заказов пока нет</li>";
    } else {
        foreach ($lines as $line) {
            list($name, $count, $type, $card, $delivery) = explode(";", $line);
            $cardText = $card === 'yes' ? 'да' : 'нет';
            echo "<li>$name заказал $count букет(ов) ($type), открытка: $cardText, получение: $delivery</li>";
        }
    }
} else {
    echo "<li>Файл с заказами ещё не создан.</li>";
}
?>
</ul>

<a href="index.php">На главную</a>
</body>
</html>
