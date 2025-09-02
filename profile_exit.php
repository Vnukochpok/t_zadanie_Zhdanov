<?php
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    session_destroy();
    echo "Вы успешно вышли из профиля<br>";
    echo "<a href='index.php'>Главная страница</a>";
?>