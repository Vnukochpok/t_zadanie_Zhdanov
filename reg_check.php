<?php

    $conn=mysqli_connect("localhost","root","","bd_test_zadanie");
    
    if($conn->connect_error){
        echo "Отсуствует подключение к базе данных";
        die();
    }
    else{
        $username = $_POST['username'];
        $number_tel=$_POST['number'];
        $email=$_POST['email'];
        $password_1=$_POST['password_1'];
        $password_2=$_POST['password_2'];
        
        $sql_check_user = "SELECT * FROM users WHERE email = '$email' OR number = '$number_tel'";
        $row_sql = $conn->query($sql_check_user)->num_rows;
        if($row_sql > 0){
            echo "Пользователь с таким email или номером телефона уже существует"."<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
            die();
        }
        else if(strlen($username)<=1){
            echo "Введите корректное имя!"."<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        }
        else if($password_1 != $password_2){
            echo "Пароли не совпадают!"."<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        }
        else if(strlen($password_1) < 8){
            echo "Используйте более надежный пароль!"."<br>";
            echo "<a href='registration.php'>Вернуться на страницу регистрации<a>";
        }
        else{
            $sql_add_user = "INSERT INTO users (name, number, email, password)
                            VALUES ('$username', '$number_tel', '$email', '$password_1');";
            if($conn->query($sql_add_user)===TRUE){
                echo "Успешная регистрация"."<br>";
                echo "<a href='index.php'>Вернуться на главную страницу<a>";
            }
        }
    }
    