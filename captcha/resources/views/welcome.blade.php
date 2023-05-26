<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>
            Pagina di login
        </title>
        <meta name="description" content="Pagina per effettuare il login">
        <meta name="keywords" content="Login, Captcha">
        <meta name="author" content="Catch Em All">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="src/main.css">
        <script src="POW/main.js"></script>
    </head>
    <body onload="pow()">
	<p id="currentPath"></p>
        <h1>
            <span lang="en">Login</span>
        </h1>
        <form method="POST" action="">
            <fieldset class="credentials">
                <legend>Credenziali</legend>
                <label for ="username">Username</label>
                <input type="text" id="username" name="username" maxlength="30" placeholder="User" required><br />
                <label for ="password">Password</label>
                <input type="password" id="password" name="password" maxlength="30" placeholder="Password" required>
            </fieldset>
            <input type="button" id="generate-captcha" onclick="generateCaptcha()"/>
            <input type="hidden" id="captcha-hashcode-id" name="captcha-hashcode-id" value="<component>captcha-hashcode-id</component>"/>
            <input type="hidden" id="captcha-difficulty" name="captcha-difficulty" value="<component>captcha-difficulty</component>"/>
            <input type="hidden" id="nonce" name="nonce" value=""/>
            <input type="submit" value="Login">
            <input type="reset" value="Annulla">
        </form>
    </body>
</html>
