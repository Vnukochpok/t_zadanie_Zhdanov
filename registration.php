<?php
    $title="Регистрация";
    require("blocks/header.php");
?>

    <form action="reg_check.php" method="post">
        <input type="text" name="username" placeholder="Введите ваше имя" class><br>
        <input type="numeric" name="number" placeholder="Введите ваш номер телефона"><br>
        <input type="email" name="email" placeholder="Введите ваш адрес электронной почты"><br>
        <input type="password" name="password_1" placeholder="Введите пароль"><br>
        <input type="password" name="password_2" placeholder="Введите пароль повторно"><br>
        <input type="submit" value="Зарегистрироваться">
    </form>

<?php
    require("blocks/footer.php");
?>
