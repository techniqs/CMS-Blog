<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Userverwaltung</title>
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

    if (isset($_POST['insertData'])) {

        if (htmlentities($_POST['password']) == htmlentities($_POST['passwordRepeat'])) {

            $checkbox = false;
            if (isset($_POST['adminrights']) &&
                $_POST['adminrights'] == 'Yes') {
                $checkbox = true;
            }
            if ($db->u_lookForUser(htmlentities($_POST['username'])) == 1) {
                echo '<script>alert("Username bereits vergeben bitte neuen auswählen.")</script>';
            } else {
                $user=new \model\User(htmlentities($_POST['username']), htmlentities($_POST['password']), htmlentities($_POST['email']), $checkbox);
                $db->u_insert($user);
            }


        } else {
            header("Location: editUser.php?createPasswordWrong=true");
        }

    }

    //TODO: Username mitgeben für DB, DB hat keine full update funktion
    // TODO: Validate if sachen wurden eingegeben oder nicht

    if (isset($_POST['updateData'])) {
        if (!empty($_POST['username']) && $db->u_lookForUser(htmlentities($_POST['username'])) == 1) {
            echo '<script>alert("Username bereits vergeben bitte neuen auswählen.")</script>';
        } else {

            if (!empty($_POST['password']) && !empty($_POST['passwordRepeat']) && htmlentities($_POST['password']) == htmlentities($_POST['passwordRepeat'])) {


                $username = htmlentities($_POST['oldusername']);
                if (!empty($_POST['username'])) {

                    $db->u_updateName(htmlentities($_POST['oldusername']), htmlentities($_POST['username']));
                    $username = htmlentities($_POST['oldusername']);
                }

                if (!empty($_POST['password'])) {
                    $db->u_updatePw($username, $_POST['password']);

                }
                if (!empty($_POST['email'])) {

                    $db->u_updateEmail($username, $_POST['email']);
                }

                if (isset($_POST['adminrights']) &&
                    $_POST['adminrights'] == 'Yes') {
                    $db->u_updateRights($username, 1);
                } else {
                    $db->u_updateRights($username, 0);
                }


            } elseif (empty($_POST['password']) && empty($_POST['passwordRepeat'])) {

                $username = htmlentities($_POST['oldusername']);
                if (!empty($_POST['username'])) {

                    $db->u_updateName(htmlentities($_POST['oldusername']), htmlentities($_POST['username']));
                    $username = htmlentities($_POST['oldusername']);
                }

                if (!empty($_POST['password'])) {
                    $db->u_updatePw($username, $_POST['password']);

                }
                if (!empty($_POST['email'])) {

                    $db->u_updateEmail($username, $_POST['email']);
                }

                if (isset($_POST['adminrights']) &&
                    $_POST['adminrights'] == 'Yes') {
                    $db->u_updateRights($username, 1);
                } else {
                    $db->u_updateRights($username, 0);
                }



            } else {
                echo '<script>alert("Passwörter stimmten nicht überein bitte wiederholen.")</script>';

            }

        }

    }


    if (isset($_GET['delete']) && $_GET == true) {
        $db->u_delete($_GET['username']);
    }
    ?>
</head>
<body data-decimal-separator="," data-grouping-separator=".">


<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        Userverwaltung
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
<?php


$result = $db->u_select();
echo "<div style='margin: 0px auto'>";
echo "<table id='tableM' >";

$i = 0;
while ($row = $result->fetch_assoc()) {
    if ($i == 0) {
        $i++;
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo '<th><span style="color:#000000">' . $key . "</span></th>";
        }
        echo "</tr>";
    }
    echo "<tr>";
    $counter = 1;
    $username = "";
    $password = "";
    $email = "";
    $adminrights = 0;
    $myaccount = false;
    foreach ($row as $value) {
        //fetching all rows from database
        echo "<td><span style=\"color:#000000\">" . $value . "</span></td>";
        if ($counter == 1) {
            $username = $value;
        }
        if (isset($_SESSION['username']) && $_SESSION['username'] == $username) {
            $myaccount = true;
        }
        if (isset($_COOKIE['username']) && $_COOKIE['username'] == $username) {
            $myaccount = true;
        }
        if ($counter == 2) {
            $password = $value;
        }
        if ($counter == 3) {
            $email = $value;
        }
        if ($counter == 4) {
            $adminrights = $value;
        }
        $counter++;
    }
    $counter = 0;

    //UPDATE `blogs` SET active=1 WHERE id="59b816c7e7dba"
    if ($myaccount == false) {


        //echo "<a href='../index.php' target='_blank'>link text</a>";

        ?>
        <td class="outside">
            <a href="editUser.php?username=<?php echo $username; ?>&password=<?php echo $password; ?>&email=<?php echo $email; ?>&adminrights=<?php echo $adminrights; ?>">
                Bearbeiten</a>
            <!-- TODO ALERT USER WILL BE DELETED -->
            <a href="userManagement.php?delete=true&username=<?php echo $username; ?>"> User Löschen</a></td>


        <?php
    } else {
        echo "<td class='outside'><span style=\"color:#000000\">Eigener Account nicht editier/löschbar.</span></td>";
    }
    echo "</tr>";
    $myaccount = false;
}


echo "</table>";

// echo '<button class="button" onclick="location.href = \'http://localhost/CMS-Project/editUser.php?newUser=true\';" value="Neuen User erstellen" </a>';

echo '<a href="editUser.php?newUser=true" style="display: block;margin-left: auto;margin-right: auto;"  > Neuen User erstellen</a>';

echo "</div>";
?>

