<?php
session_start();
require_once 'UserInfo.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная — Заказ цветов</title>
</head>
<body>
    <h1>Главная страница «Заказ цветов»</h1>

    <?php if (isset($_SESSION['errors'])): ?>
        <ul style="color:red;">
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        <h3>Последний заказ:</h3>
        <ul>
            <li>Имя: <?= $_SESSION['username'] ?></li>
            <li>Количество букетов: <?= $_SESSION['count'] ?></li>
            <li>Вид букета: <?= $_SESSION['type'] ?></li>
            <li>Открытка: <?= $_SESSION['card'] === 'yes' ? 'да' : 'нет' ?></li>
            <li>Способ получения: <?= $_SESSION['delivery'] ?></li>
        </ul>
    <?php else: ?>
        <p>Заказов пока нет. <a href="form.html">Сделать заказ</a></p>
    <?php endif; ?>

    <hr>

    <h3>Информация о пользователе:</h3>
    <?php
    $info = UserInfo::getInfo();
    foreach ($info as $k => $v) {
        echo htmlspecialchars($k) . ': ' . htmlspecialchars($v) . '<br>';
    }
    ?>

    <?php if (isset($_COOKIE['last_order'])): ?>
        <p><strong>Последний заказ:</strong> <?= htmlspecialchars($_COOKIE['last_order']) ?></p>
    <?php endif; ?>

    <?php
    if (isset($_SESSION['api_data'])) {
        echo "<hr><h3>Красивые цветы от Unsplash:</h3>";

        $data = $_SESSION['api_data'];
        if (is_array($data)) {
            echo '<div style="display:flex; gap:10px;">';
            foreach ($data as $photo) {
                $url = htmlspecialchars($photo['urls']['small'] ?? '');
                if ($url) {
                    echo "<img src='$url' width='200' style='border-radius:10px;'>";
                }
            }
            echo '</div>';
        } else {
            echo "<p>Не удалось загрузить изображения.</p>";
        }
    }
    ?>

    <p><a href="form.html">Сделать новый заказ</a> | <a href="view.php">Посмотреть все заказы</a></p>
</body>
</html>
