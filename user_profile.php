<?php

    $title = "Личный кабинет";
    require("blocks/header.php");
    
    //создание сессии, подлючение к БД, а также получение данных из сессии
    session_start();
    require("connect_bd.php");
    $userLogin = $_SESSION['login'];
    $userPassword = $_SESSION['password'];

    //проверка на наличие в сесси данных, если данных в сессии нет, то пользователь не сможет войти в профиль
    if ($_SESSION['login'] == "" || $_SESSION['password'] == "") {
        header("Location: index.php");
    } else {
        //вывод информации о пользователе
        $sql = "SELECT * FROM users WHERE (email='$userLogin' OR number='$userLogin') AND password = '$userPassword'";
        $sqlRes = mysqli_query($conn, $sql);

        if (mysqli_num_rows($sqlRes) == 1) {
            $userData = mysqli_fetch_assoc($sqlRes);
            echo "Имя пользователя: " . $userData['name'] . "<br>";
            echo "Email пользователя: " . $userData['email'] . "<br>";
            echo "Телефон пользователя: " . $userData['number'] . "<br>";
            echo "Пароль пользователя: " . $userData['password'] . "<br>";
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