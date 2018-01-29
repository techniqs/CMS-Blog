<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Blog - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">

</head>
<?php
session_start();

if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
    header("Location: http://localhost/CMS-Project/index.php");
}
if (isset($_GET['loginError']) && $_GET['loginError']==true){
    echo '<script>alert("Username oder Passwort falsch.")</script>';
}



?>
<!--<script>alert("username or password wrong.")</script> -->

<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php">
        <img class="title-image" src="../res/img/pandaHomeLogo.png" alt="BIG Smart Home logo">
    </a>
    <h1 class="header-title" id="bannerheadline">
        Blog - Login
    </h1>
    <nav aria-labelledby="navigationheadline">
        <ul class="navigation-list">

        </ul>
    </nav>

</header>
<div class="main-container">
    <main aria-labelledby="formheadline">
        <form id="ajax" action="../index.php" method="post">
            <h2 id="formheadline" class="registration-headline">Anmelden</h2>
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Benutzername
                    </div>
                </label>
                <input name='username' id="username" required class="form-input">
                <span id="username-error" class="error-text"></span>
            </div>
            <div class="form-row">
                <label class="form-label" for="password-input">
                    <div class="blacklabel">
                        Passwort
                    </div>
                </label>
                <input type="password" name="password" id="password" required class="form-input">
                <span id="password-error" class="error-text"></span>
            </div>
            <div class="form row form-row-left">
                <input type="checkbox" name="loginSaved" value="Yes">
                <div class="blacklabel">Login merken
                </div>
            </div>
            <div class="form-row form-row-center">
                <button class="button button-submit">
                    <div class="blacklabel">
                        Anmelden
                    </div>
                </button>
        </form>
    </main>
</div>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="../ajax/main.js"></script>

</body>
</html>
