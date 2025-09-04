<?php

    //создание сессии, подключение к БД
    session_start();
    require("connect_bd.php");

    //беру логин из сессии для того, чтобы определить пользователя в БД, чьи данные я буду менять
    $login = $_SESSION['login'];

    //получение данных POST
    $newEmail = $_POST['email'];
    $newNumber = $_POST['number'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    //скрипт для изменения данных пользователя, здесь пригодились данные из сессии
    $sql = "UPDATE users SET name = '$newUsername', email = '$newEmail', number = '$newNumber', password = '$newPassword' WHERE email = '$login' or number = '$login';";

    //обновление данных в БД и сессиях, это нужно, чтобы далее пользователь мог заходить в профиль под новым логином
    try {
        $conn->query($sql);
        echo "Данные о пользователе успешно обновлены!";
        $_SESSION['login'] = $newNumber;
        $_SESSION['password'] = $newPassword;
        header("Location: user_profile.php");
    } catch (Exception $e) {
        echo "Данные не были обновлены, произошла ошибка: " . $e->getMessage() . "<br>";
    } finally {
        echo "<a href='index.php'>Главная страница</a>" . "<br>";
        echo "<a href='user_profile.php'>Профиль</a>";
    }

