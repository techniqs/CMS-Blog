<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Dateien verwalten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">

</head>
<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

    header("Location: http://localhost/CMS-Project/index.php");
}

include('..\utility\DbUtility.php');
$db = new \utility\DbUtility();

if (isset($_POST['submitFile'])){

    $files = $_FILES['fileUpload']['name'];
    $tmp_file = $_FILES['fileUpload']['tmp_name'];
    $location = '../files/';

    if (move_uploaded_file($tmp_file, $location . $files)) {

    echo "<script type='text/javascript'>alert('File uploaded succesfully');</script>";


    } else {
        echo "<script type='text/javascript'>alert('No file selected');</script>";

    }

    ?>
    <script type='text/javascript'>alert(<?php echo $msgfile ?>);</script>
<?php

}


if (isset($_GET['delete'])) {
    if (unlink($_GET['file'])){
        ?>
        <script type='text/javascript'>alert("Datei erfolgreich gelöscht");</script>
        <?php
    }
    else{
        ?>
        <script type='text/javascript'>alert("Datei konnte nicht gelöscht werden");</script>
        <?php
    }
}
?>

<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="User-Navigation"></a>

    <h1 class="header-title" id="bannerheadline">
        Datei Manager
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
                            <a href="../admin/logout.php">Logout</a>
                        </div>
                    </div>
                    <?php
                    echo '<div class="whitelabel" >[Hallo ' . $_COOKIE['username'] . ']</div>';
                } elseif (isset($_SESSION['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="../inc/navigation.php">User-Navigation</a>
                            <a href="../admin/logout.php">Logout</a>
                        </div>
                    </div>
                    <?php echo '<div class="whitelabel" >[Hallo ' . $_SESSION['username'] . ']</div>';
                } else {
                    echo '<a href="../admin/login.php" class="button" accesskey="1">Login</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
</header>
<div class="main-container">
    <main aria-labelledby="formheadline">
        <!-- hrefs machen für jeden shit und dadurch href back to addpage mit file name ez.
        wsl mit hidden input bei addpage sowie bei edit damit ich das submitten kann lul.
         glob("img/thumb/*.{jpg,png,gif}", GLOB_BRACE)

         -->

        <!-- File Input -->
        <?php //if ((isset($_SESSION['username'])&&($db->u_query_adminRights($_SESSION['username']))==1) || (isset($_COOKIE['username'])&& ($db->u_query_adminRights($_COOKIE['username']))==1)) {
        ?>

        <?php
        //}

        //<input name="files" type="file">

        //<input name="image" type="image">

        $log_directory = '../files';

        echo "<div>";
        echo "<table id='tableM' >";
        echo "<tr>";
        echo '<th><span style="color:#000000"> Dateien </span></th>';
        echo "</tr>";
        echo "<tr>";

        foreach (glob($log_directory . '/*.*') as $file) {
        ?>
        <td><a href="../files/<?php echo basename($file) ?>" > <?php echo basename($file) ?></a></td>
        <?php if ((isset($_SESSION['username'])&&($db->u_query_adminRights($_SESSION['username']))==1) || (isset($_COOKIE['username'])&& ($db->u_query_adminRights($_COOKIE['username']))==1)) { ?>
        <td class='outside'><a href="fileManager.php?delete=true&file=<?php echo $file ?>">Datei Löschen </a></td> <?php } echo "</tr>"?>

<?php
}

echo "</table>";
echo "</div>"; ?>
        <form class="ajax" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <input type="file" name="fileUpload" style="color:black;margin:0px auto">
            </div>

            <div class="form-row">
                <input type="submit" class="button" name="submitFile" value="Hochladen" style="margin: 0px auto"/>
            </div>
        </form>

<script src="../ajax/jquery-3.2.1.js"></script>
<script src="../ajax/main.js"></script>
</main>
</body>