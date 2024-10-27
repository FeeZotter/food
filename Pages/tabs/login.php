<main>
    <form action="/login" method="post">
        <fieldset>
            <legend>Login<?php if(Session::isLogin()) echo(" to another account"); ?></legend>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Not Alias" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="*************" required>
            <input type="submit" value="Login">
        </fieldset>
    </form>
</main>
<script src='food/js/login.js'></script>