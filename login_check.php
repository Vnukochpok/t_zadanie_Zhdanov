<?php
    define('SMARTCAPTCHA_SERVER_KEY', 'server-key');
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    $conn=mysqli_connect("localhost", "root", "", "bd_test_zadanie");
    
    if($conn->connect_error){
        echo "Ошибка при подключении к БД";
        die();
    }
    else{
        function check_captcha($token) {
            $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
            $args = [
            "secret" => SMARTCAPTCHA_SERVER_KEY,
            "token" => $token,
            ];
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_POST, true);    
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch); 
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode !== 200) {
                echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
               return true;
            }
 
            $resp = json_decode($server_output);
            return $resp->status === "ok";
        }

        $token = $_POST['smart-token'];
            if (check_captcha($token)) {
                echo "Passed\n";
            } else {
               echo "Robot\n";
            }
            $sql="SELECT * FROM users WHERE (email='$login' OR number='$login') AND password='$password'";
            $row_sql=$conn->query($sql)->num_rows;
            if($row_sql > 0){
                session_start();
                $_SESSION['login']=$login;
                $_SESSION['password']=$password;
                header("Location: user_profile.php");
            
            }
            else if($row_sql < 1){
                echo "Пользователь не найден<br>";
                echo "<a href='login.php'>Страница авторизации</a>";
            }
    }
    