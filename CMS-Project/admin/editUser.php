<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title><?php if (isset($_GET['newUser']) || isset($_GET['createPasswordWrong'])) { ?> User erstellen <?php } else { ?> User editieren<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">
    <?php
    session_start();

    if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

        header("Location: http://localhost/CMS-Project/index.php");

    }
    include('..\utility\DbUtility.php');
    $db = new \utility\DbUtility();

    if ((isset($_SESSION['username']) && !($db->u_query_adminRights($_SESSION['username'])) == 1) || (isset($_COOKIE['username']) && !($db->u_query_adminRights($_COOKIE['username'])) == 1)) {
        header("Location: http://localhost/CMS-Project/index.php");
    }

    //echo $db->u_query_username("admin");
    // echo $_GET['user']

    /*
     * <button type="button" class="button"
                        onclick="parent.window.opener.location='userManagement.php'; window.close();">Submit
                </button>


     */
    if (isset($_GET['createPasswordWrong'])) {
        echo '<script>alert("Passwörter stimmten nicht überein.")</script>';
    }

    ?>


<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        <?php if (isset($_GET['newUser']) || isset($_GET['createPasswordWrong'])) { ?> User erstellen <?php } else { ?> User editieren<?php } ?>
    </h1>
    <nav aria-labelledby="navigationheadline">
        <ul class="navigation-list">
            <li>
                <!-- TODO : ABMELDEN/Login BUTTION ONLY THERE WHEN LOGGED/loggout IN -->
                <?php
                if (isset($_COOKIE['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="../inc/navigation.php">User-Navigation</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                    <?php
                    echo '<div class="whitelabel" >[Hallo ' . $_COOKIE['username'] . ']</div>';
                } elseif (isset($_SESSION['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="../inc/navigation.php">User-Navigation</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                    <?php echo '<div class="whitelabel" >[Hallo ' . $_SESSION['username'] . ']</div>';
                } else {
                    echo '<a href="login.php" class="button" accesskey="1">Login</a>';
                }
                ?>
            </li>
        </ul>
    </nav>

</header>
<div class="main-container">
    <main aria-labelledby="formheadline">
        <form id="ajax" action="userManagement.php" method="post">
            <h2 id="formheadline"
                class="registration-headline"><?php if (isset($_GET['newUser']) || isset($_GET['createPasswordWrong'])) { ?> User erstellen <?php } else { ?> User editieren
                    <br> (Stellen die gleich bleiben auslassen) <?php } ?></h2>

            <!-- Username Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Benutzername<?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) {
                        echo ": " . $_GET['username'];
                        ?>
                    </div>
                </label>
                <input name="username" class="form-input">
                <input name="oldusername" type="hidden" value=<?php echo $_GET['username'] ?>>

                <?php } else{ ?>
            </div>
            <?php echo"</label>"; ?>
            <input name="username" required class="form-input">
            <?php } ?>
            </div>

            <!-- Password Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Passwort<?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) {
                            echo ": " . $_GET['password'];
                        }
                        ?>
                    </div>
                </label><?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) { ?>
                    <input type="password" name="password" class="form-input">
                <?php } else { ?>
                    <input type="password" name="password" required class="form-input">
                <?php } ?>
            </div>

            <!-- Password again Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Passwort
                        wiederholen<?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) {
                            echo ": " . $_GET['password'];
                        }
                        ?>
                    </div>
                </label><?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) { ?>
                    <input type="password" name="passwordRepeat" class="form-input">
                <?php } else { ?>
                    <input type="password" name="passwordRepeat" required class="form-input">
                <?php } ?>
            </div>

            <!-- Email Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Email<?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) {
                            echo ": " . $_GET['email'];
                        }
                        ?>
                    </div>
                </label><?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) { ?>
                    <input  name="email" class="form-input">
                <?php } else { ?>
                    <input  name="email" required class="form-input">
                <?php } ?>
            </div>
            <!-- Adminrights Input -->
            <div class="form-row">
                <input type="checkbox" name="adminrights"
                       value="Yes" <?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) {
                    if ($_GET['adminrights'] == 1) {
                        echo 'checked';
                    } else {
                        echo ": Nicht Vorhanden";
                    }
                }
                ?> >
                <div class="blacklabel">Adminrechte
                    (ja / nein)
                </div>
            </div>


            <div class="form-row form-row-center">
                <input type="submit"
                       class="button button-submit" <?php if (!isset($_GET['newUser']) && !isset($_GET['createPasswordWrong'])) { ?>
                    name="updateData"
                <?php } else { ?> name="insertData"
                <?php } ?> value="Speichern">
            </div>
<?php
echo "</form>";
echo "</main>";
echo "</div>";?>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="../ajax/main.js"></script>
</body>
</html>