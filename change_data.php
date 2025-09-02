<?php
    session_start();
    $conn=mysqli_connect("localhost", "root", "", "bd_test_zadanie");

    $login = $_SESSION['login'];

    $new_username=$_POST['username'];
    $new_email=$_POST['email'];
    $new_number=$_POST['number'];
    $new_password=$_POST['password'];

    $sql="UPDATE users SET name='$new_username', email='$new_email', number='$new_number', password='$new_password' WHERE email='$login' or number='$login';";

    if($conn->query($sql) === TRUE){
        echo "Данные о пользователе успешно обновлены!";
        $_SESSION['login']=$new_number;
        $_SESSION['password']=$new_password;
        header("Location: user_profile.php");
    }

?>