<?php

    //создание сессии, подключение к БД
    session_start();
    require("connect_bd_php");

    //беру логин из сессии для того, чтобы определить пользователя в БД, чьи данные я буду менять
    $login = $_SESSION['login'];

    //получение данных POST
    $newEmail = $_POST['email'];
    $newNumber = $_POST['number'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    //скрипт для изменения данных пользователя, здесь пригодились данные из сессии
    $sql = "UPDATE users SET name = '$newUsername', email = '$newEmail', number = '$newNumber', password = '$newPassword' WHERE email = '$login' or number = '$login';";

    //обновление данных в БД и сессиях, обновление данных в сессии нужно, чтобы далее пользователь мог заходить в профиль под новым логином
    if ($conn->query($sql) === true) {
        echo "Данные о пользователе успешно обновлены!";
        $_SESSION['login'] = $newNumber;
        $_SESSION['password'] = $newPassword;
        header("Location: user_profile.php");
    } else {
        echo "Данные не были обновлены, произошла ошибка" . "<br>";
        echo "<a href='index.php'>Главная страница</a>" . "<br>";
        echo "<a href='user_profile.php'>Профиль</a>";
    }
