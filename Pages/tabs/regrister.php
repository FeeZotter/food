<main>
    <form action="/regrister" method="post">
        <fieldset>
            <legend>Regrister new Account</legend>
            <label for="name">Name:</label> <br>
            <input type="text" id="name" name="name" placeholder='Private name for login' required> <br>
            <label for="alias">Alias:</label> <br>
            <input type="text" id="alias" name="alias" placeholder='Public name' required> <br>
            <label for="password">Password:</label> <br>
            <input type="password" id="password" name="password" placeholder='password' required> <br>
            <label for="key">Key:</label> <br>
            <input type="text" id="key" name="key" maxlength='32' placeholder='unlocks unlimited preferences'> <br>
            <input type="submit" value="Regrister">
        </fieldset>
    </form>
    <p>NOTE: There is <b>no email communication</b> that can help you, so its easy that the <b>password is lost</b></p>

    <script src='food/js/regrister.js'></script>
</main>