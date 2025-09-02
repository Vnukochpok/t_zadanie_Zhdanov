<?php
    //создание сессии, подключение к БД
    session_start();
    $conn=mysqli_connect("localhost", "root", "", "bd_test_zadanie");

    //беру логин из сессии для того, чтобы определить пользователя в БД, чьи данные я буду менять
    $login = $_SESSION['login'];

    //получение данных POST
    $new_username=$_POST['username'];
    $new_email=$_POST['email'];
    $new_number=$_POST['number'];
    $new_password=$_POST['password'];

    //скрипт для изменения данных пользователя, здесь пригодились данные из сессии
    $sql="UPDATE users SET name='$new_username', email='$new_email', number='$new_number', password='$new_password' WHERE email='$login' or number='$login';";

    //обновление данных в БД и сессиях, обновление данных в сессии нужно, чтобы далее пользователь мог заходить в профиль под новым логином
    if($conn->query($sql) === TRUE){
        echo "Данные о пользователе успешно обновлены!";
        $_SESSION['login']=$new_number;
        $_SESSION['password']=$new_password;
        header("Location: user_profile.php");
    }

?>