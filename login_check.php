<?php

    //из примера кода на странице Яндекса был взят пример по проверки прохождения капчи, он был встроен в мой код
    define('SMARTCAPTCHA_SERVER_KEY', 'server-key');
    //методом POST получаю данные
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    require("connect_bd_php");
    
    //так же сразу проверяю наличие подключения к БД
    if ($conn->connect_error) {
        echo "Ошибка при подключении к БД";
        die();
    } else {
        //Данная функция и проверка токена были взяты из кода-примера от Яндекса
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

            //после проверки токена создаю sql запрос для проверки есть ли такой пользователь в базе данных и верно ли он ввел логин/пароль
            $sql = "SELECT * FROM users WHERE (email = '$login' OR number = '$login') AND password = '$password'";
            $row_sql = $conn->query($sql)->num_rows;
            //если в ответ получаю 1 строку, то пользователь найден в базе данных и можно переводить его на страницу профиля,
            //а также давать ему доступ для входа в профиль
            if ($row_sql = 1) {
                session_start();
                //при входе в профиль у меня происходит проверка на наличии в сессии данных, если данных нет, то профиль недоступен
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                header("Location: user_profile.php");
            
            } else if ($row_sql < 1) {
                echo "Пользователь не найден" . "<br>";
                echo "<a href='login.php'>Страница авторизации</a>";
            }
    }
    