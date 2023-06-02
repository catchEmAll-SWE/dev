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
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="main.js"></script>
    </head>
    <body onload="pow()">
	<p id="currentPath"></p>
        <h1>
            <span lang="en">Login</span>
        </h1>
        <form method="POST" action="/api/v1">
            <fieldset class="credentials">
                <legend>Credenziali</legend>
                <label for ="username">Username</label>
                <input type="text" id="username" name="username" maxlength="30" placeholder="User" required><br />
                <label for ="password">Password</label>
                <input type="password" id="password" name="password" maxlength="30" placeholder="Password" required>
            </fieldset>
            <input type="button" id="generate-captcha" onclick="captcha()" value="Genera Captcha"/>
            <input type="hidden" id="captcha-id" name="captcha-id" value=""/>
            <input type="hidden" id="nonce" name="nonce" value=""/>
            <input type="submit" value="Login">
            <input type="reset" value="Annulla">
        </form>
    </body>
</html>
