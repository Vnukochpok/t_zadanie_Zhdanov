<?php

    //создаю подключение к БД
    require("connect_bd.php");
    
    //сразу проверяю есть ли данное подключение
    if ($conn->connect_error) {
        echo "Отсуствует подключение к базе данных";
        die();
    } else {
        //методом POST принимаю данные от пользователя
        $email = $_POST['email'];
        $username = $_POST['username'];
        $numberTel = $_POST['number'];
        $password1 = $_POST['password_1'];
        $password2 = $_POST['password_2'];

        //запрос для проверки существования в БД пользователя с таким же email или номером телефона
        $sqlCheckUser = "SELECT * FROM users WHERE email = '$email' OR number = '$numberTel' OR name='$username'";
        //записываю в переменную количество полученных строк, от запроса
        $sqlRow = $conn->query($sqlCheckUser)->num_rows;


        //соответственно, если строк >0, то пользователь уже есть в БД
        if ($sqlRow > 0) {
            echo "Пользователь с таким email, номером телефона или логином уже существует" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
            die();
        //проверки на введенные данные: реальное имя, равен ли первый пароль второму, и проверка на длину пароля
        } else if (strlen($username) <= 1) { 
            echo "Введите корректное имя!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else if ($password1 != $password2) {
            echo "Пароли не совпадают!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else if (strlen($password1) < 8) {
            echo "Используйте более надежный пароль!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else if (is_numeric($numberTel) === false) {
            echo "Вы ввели номер телефона с буквами" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else {
            $sqlAddUser = "INSERT INTO users (name, number, email, password)
                            VALUES ('$username', '$numberTel', '$email', '$password1');";

            //проверка, если sql запрос выполняется корректно, то сразу же пользователь добавляется в БД и появляется вывод об успешной регистрации
            if ($conn->query($sqlAddUser) === true) {
                echo "Успешная регистрация" . "<br>";
                echo "<a href='index.php'>Вернуться на главную страницу<a>";
            } else {
                echo "Произошла ошибка при выполнении запроса";
                echo "<a href='index.php'>Вернуться на главную страницу<a>";
            }

        }
    }
    