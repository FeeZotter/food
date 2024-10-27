<main>
    <form id="loginForm" action="/login" method="post">
        <fieldset>
            <legend>Login<?php if(Session::isLogin()) echo(" to another account"); ?></legend>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="<?php echo UniversalLibrary::getNameRegex(); ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="<?php echo UniversalLibrary::getPassRegex(); ?>" required>
            <input type="submit" value="Login">
        </fieldset>
    </form>
    <p>Password: Minimum 12 and maximum 50 characters, at least one uppercase letter, one lowercase letter, one number and one special character</p>
</main>
<script src='food/js/login.js'></script>