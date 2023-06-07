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
    <body>
        <h1>
            <span lang="en">Login</span>
        </h1>
        <form id="form">
            <fieldset class="credentials">
                <legend>Credenziali</legend>
                <label for ="username">Username</label>
                <input type="text" id="username" name="username" maxlength="30" placeholder="User" required><br />
                <label for ="password">Password</label>
                <input type="password" id="password" name="password" maxlength="30" placeholder="Password" required>
            </fieldset>
            <button id="generate" onclick="getCaptcha();">Genera captcha</button>
            <div id="loading"></div>
            <fieldset class="captcha-images" id="captcha-images">
                <legend>Seleziona le immagini appartenente alla classe <component>ClassTarget</component></legend>
                <div class="img-container">
                    <input type="checkbox" id="img0" name="image[]" value="0" />
                    <label for="img0"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img1" name="image[]" value="1" />
                    <label for="img1" ><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img2" name="image[]" value="2" />
                    <label for="img2"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img3" name="image[]" value="3" />
                    <label for="img3"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img4" name="image[]" value="4" />
                    <label for="img4"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img5" name="image[]" value="5" />
                    <label for="img5"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img6" name="image[]" value="6" />
                    <label for="img6"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img7" name="image[]" value="7" />
                    <label for="img7"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img8" name="image[]" value="8" />
                    <label for="img8"><img src=""></label>
                </div>
                <div class="img-container">
                    <input type="checkbox" id="img9" name="image[]" value="9" />
                    <label for="img9"><img src=""></label>
                </div>
            </fieldset>
            <input type="reset" id="reset" value="Annulla">
            <input type="submit" id="submit" value="Login" onclick="Verify();">
        </form>
    </body>
    
</html>
