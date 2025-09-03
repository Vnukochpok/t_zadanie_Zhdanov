<?php

    //создаю подключение к БД
    require("connect_bd_php");
    
    //сразу проверяю есть ли данное подключение
    if ($conn->connect_error) {
        echo "Отсуствует подключение к базе данных";
        die();
    } else {
        //методом POST принимаю данные от пользователя
        $email = $_POST['email'];
        $username = $_POST['username'];
        $number_tel = $_POST['number'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

        //запрос для проверки существования в БД пользователя с таким же email или номером телефона
        $sql_check_user = "SELECT * FROM users WHERE email = '$email' OR number = '$number_tel'";
        //записываю в переменную количество полученных строк, от запроса
        $row_sql = $conn->query($sql_check_user)->num_rows;

        //соответственно, если строк >0, то пользователь уже есть в БД
        if ($row_sql > 0) {
            echo "Пользователь с таким email или номером телефона уже существует" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
            die();
        //проверки на введенные данные: реальное имя, равен ли первый пароль второму, и проверка на длину пароля
        } else if (strlen($username) <= 1) { 
            echo "Введите корректное имя!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else if ($password_1 != $password_2) {
            echo "Пароли не совпадают!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else if (strlen($password_1) < 8) {
            echo "Используйте более надежный пароль!" . "<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        } else {
            $sql_add_user = "INSERT INTO users (name, number, email, password)
                            VALUES ('$username', '$number_tel', '$email', '$password_1');";

            //проверка, если sql запрос выполняется корректно, то сразу же пользователь добавляется в БД и появляется вывод об успешной регистрации
            if ($conn->query($sql_add_user) === true) {
                echo "Успешная регистрация" . "<br>";
                echo "<a href='index.php'>Вернуться на главную страницу<a>";
            } else {
                echo "Произошла ошибка при выполнении запроса";
                echo "<a href='index.php'>Вернуться на главную страницу<a>";
            }

        }
    }
    