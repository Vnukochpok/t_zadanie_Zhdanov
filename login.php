<?php
    $title="Вход";
    require("blocks/header.php");
?>
    
    <!-- По аналогии с регистрацией добавил поля для авторизации пользователя -->
    <form action="login_check.php" method="post">
        <input type="text" name="login" placeholder="Введите email или номер телефона"><br>
        <input type="password" name="password" placeholder="Введите пароль"><br>
        <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
        <!-- Здесь же добавил капчу (код взял из инструкции по установке капчиЮ) -->
        <div style="width:100px; height:80px;" id="captcha-container" class="smart-captcha" 
        data-sitekey="client_key">
        <input type="hidden" name="smart-token" value="">
        </div>
        <input type="submit" placeholder="Войти">
    </form>

<?php
    require("blocks/footer.php");
?>