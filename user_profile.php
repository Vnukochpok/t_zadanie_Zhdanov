<?php

    $title = "Личный кабинет";
    require("blocks/header.php");
    
    //создание сессии, подлючение к БД, а также получение данных из сессии
    session_start();
    require("connect_bd_php");
    $userlogin = $_SESSION['login'];
    $userpassword = $_SESSION['password'];

    //проверка на наличие в сесси данных, если данных в сессии нет, то пользователь не сможет войти в профиль
    if ($_SESSION['login'] == "" || $_SESSION['password'] == "") {
        header("Location: index.php");
    } else {
        //вывод информации о пользователе
        $sql = "SELECT * FROM users WHERE (email='$userlogin' OR number='$userlogin') AND password = '$userpassword'";
        $sql_res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($sql_res) == 1) {
            $user_data = mysqli_fetch_assoc($sql_res);
            echo "Имя пользователя: " . $user_data['name'] . "<br>";
            echo "Email пользователя: " . $user_data['email'] . "<br>";
            echo "Телефон пользователя: " . $user_data['number'] . "<br>";
            echo "Пароль пользователя: " . $user_data['password'] . "<br>";
        } else {
            echo "Произошла ошибка в БД";
            echo "<a href='user_profile.php'>Вернуться в профиль</a>";
        }

        echo "<br>Для смены данных введите новую информацию и нажмите кнопку 'Отправить'";
    }

?>
    <!-- Поля для изменения информации о пользователе, данные передаются на обработку в отдельный файл -->
    <form action="change_data.php" method="post">
        <input type="text" name="username" placeholder="Новое имя";><br>
        <input type="email" name="email" placeholder="Новый email";><br>
        <input type="numeric" name="number" placeholder="Новый номер телефона";><br>
        <input type="password" name="password" placeholder="Новый пароль";><br><br>
        <input type="submit" placeholder="Подтвердить"><br><br>
    </form>
    <!-- кнопка для выхода из профиля/завершения сессии -->
    <form action="profile_exit.php" method="post">
        <input type="submit" value="Выйти из профиля">
    </form>

<?php
    
    require("blocks/footer.php");
?>