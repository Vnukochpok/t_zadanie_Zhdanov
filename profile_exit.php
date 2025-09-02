<?php
    session_start();
    //удаление данных в сессии, завершение сессии
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    session_destroy();
    echo "Вы успешно вышли из профиля<br>";
    echo "<a href='index.php'>Главная страница</a>";
?>