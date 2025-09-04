<?php

    //создание сессии, подключение к БД
    session_start();
    require("connect_bd.php");

    //беру логин из сессии для того, чтобы определить пользователя в БД, чьи данные я буду менять
    $oldLogin = $_SESSION['login'];

    //получение данных POST
    $newEmail = $_POST['email'];
    $newNumber = $_POST['number'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    if ($newEmail == "" || $newNumber == "" || $newUsername == "" || $newPassword == "") {
        echo "Заполните все поля и введите все данные!";
        echo "<a href='user_profile.php'>Профиль</a>";
        die();
    }
    //проверка на существования пользователя с такими же данные в БД
    $sqlCheckUser = "SELECT * FROM users WHERE email = '$newEmail' OR number = '$newNumber' OR name='$newUsername'";
        //записываю в переменную количество полученных строк, от запроса
        $sqlRow = $conn->query($sqlCheckUser)->num_rows;

        //соответственно, если строк >0, то пользователь уже есть в БД
        if ($sqlRow > 0) {
            echo "Пользователь с таким email, номером телефона или логином уже существует" . "<br>";
            echo "<a href='user_profile.php'>Вернуться в личный кабинет<a>";
            die();
        } else if (strlen($newUsername) <= 1) { 
            echo "Введите корректное имя!" . "<br>";
            echo "<a href='user_profile.php'>Вернуться в личный кабинет<a>";
            die();
        } else if (is_numeric($newNumber) === false) {
            echo "Вы ввели номер телефона с буквами" . "<br>";
            echo "<a href='user_profile.php'>Вернуться в личный кабинет<a>";
            die();
        } else {
            //скрипт для изменения данных пользователя, здесь пригодились данные из сессии
            $sql = "UPDATE users SET name = '$newUsername', email = '$newEmail', number = '$newNumber', password = '$newPassword' WHERE email = '$oldLogin' or number = '$oldLogin';";

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
        }
        

    

