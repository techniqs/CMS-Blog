<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Datei-Liste</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">

</head>
<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

    header("Location: http://localhost/CMS-Project/index.php");
}
/*
    if (isset($_POST['savesite'])) {

        //TODO muss noch modified werden dass nur db eintrag und nicht real file genommen wird luuul
        //echo $_POST['image'];
        $image = $_FILES['image']['name'];
        $text = $_POST['text'];
        $title = $_POST['title'];
        $files = $_FILES['files']['name'];

        $dateBeg = new DateTime($_POST['dateBeg']);
        $dateEnd = new DateTime($_POST['dateEnd']);
        $currentDate = new DateTime();
        //echo $dateBeg;


        $tmp_image = $_FILES['image']['tmp_name'];
        $tmp_file = $_FILES['files']['tmp_name'];

        if (strtotime($dateEnd->format('Y-m-d')) < strtotime($currentDate->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('End-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";

        } elseif (strtotime($dateBeg->format('Y-m-d')) > strtotime($dateEnd->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht nach dem End-Datum gesetzt werden');</script>";
        } elseif (strtotime($dateBeg->format('Y-m-d')) == strtotime($dateEnd->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht gleich dem End-Datum gesetzt werden');</script>";

        } elseif (strtotime($dateBeg->format('Y-m-d')) < (strtotime($currentDate->format('Y-m-d')))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";

        } else {
            $blog = new \model\Blog(uniqid(), $author, $title, $text, $image, $files, 0, $dateBeg->format('Y-m-d'), $dateEnd->format('Y-m-d'));
            $db->b_insert($blog);


        }


}
*/

if (isset($_POST['editPage'])) {
    if (isset($_POST['postImageButton']) || isset($_POST['postFileButton'])) {
        $_SESSION['text'] = $_POST['text'];
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['dateBeg'] = $_POST['dateBeg'];
        $_SESSION['dateEnd'] = $_POST['dateEnd'];
        // $_SESSION['image'] = $_POST['image'];
        // $_SESSION['files'] = $_POST['files'];
        // echo $_POST['postImageButton'];
        // echo $_POST['position'];
        $_SESSION['position'] = $_POST['position'];
        $_SESSION['editPage']=$_POST['editPage'];

    }

    if (isset($_POST['saveEdit'])) {
        $_SESSION['text'] = $_POST['text'];
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['dateBeg'] = $_POST['dateBeg'];
        $_SESSION['dateEnd'] = $_POST['dateEnd'];
        $_SESSION['imageInput'] = $_POST['imageInput'];
        $_SESSION['fileInput'] = $_POST['fileInput'];
        $_SESSION['position'] = $_POST['position'];
        $_SESSION['editPage']=$_POST['editPage'];
        header("Location: http://localhost/CMS-Project/inc/editPage.php?edit=true&saveEdit=true&id=".$_SESSION['editPage']);


    }


}

if (isset($_POST['postImageButton']) || isset($_POST['postFileButton'])) {
    $_SESSION['text'] = $_POST['text'];
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['dateBeg'] = $_POST['dateBeg'];
    $_SESSION['dateEnd'] = $_POST['dateEnd'];
    // $_SESSION['image'] = $_POST['image'];
    // $_SESSION['files'] = $_POST['files'];
    // echo $_POST['postImageButton'];
    // echo $_POST['position'];
    $_SESSION['position'] = $_POST['position'];

}
if (isset($_POST['savesite'])) {
    $_SESSION['text'] = $_POST['text'];
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['dateBeg'] = $_POST['dateBeg'];
    $_SESSION['dateEnd'] = $_POST['dateEnd'];
    $_SESSION['imageInput'] = $_POST['imageInput'];
    $_SESSION['fileInput'] = $_POST['fileInput'];
    $_SESSION['position'] = $_POST['position'];
    header("Location: http://localhost/CMS-Project/ajax/addPage.php?savesite=true");


}


?>
<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="User-Navigation"></a>

    <h1 class="header-title" id="bannerheadline">
        Datei-Liste
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

        <?php

        $addToImage = "&image=";
        if (isset($_POST['imageInput'])) {
            $addToImage = $addToImage . $_POST['imageInput'];
        }
        $addToFile = "&file=";
        if (isset($_POST['fileInput'])) {
            $addToFile = $addToFile . $_POST['fileInput'];
        } ?>

        <?php
        $log_directory = '../files';

        if (!isset($_POST['editPage'])) {
            if (isset($_POST['postFileButton'])) {
                foreach (glob($log_directory . "/*.{pdf,txt}", GLOB_BRACE) as $file) {
                    ?>

                    <a href="http://localhost/CMS-Project/ajax/addPage.php?file=<?php echo basename($file) . $addToImage ?>"><?php echo basename($file) ?> </a>
                    <br/>
                    <?php

                }
            }
            if (isset($_POST['postImageButton'])) {
                foreach (glob($log_directory . "/*.{jpg,png}", GLOB_BRACE) as $file) {
                    ?>


                    <a href="http://localhost/CMS-Project/ajax/addPage.php?image=<?php echo basename($file) . $addToFile ?>"><?php echo basename($file) ?> </a>
                    <br/>
                    <?php
                }
            }
        }
        if (isset($_POST['editPage'])){

        if (isset($_POST['postFileButton'])) {
            foreach (glob($log_directory . "/*.{pdf,txt}", GLOB_BRACE) as $file) {
                ?>

                <a href="http://localhost/CMS-Project/inc/editPage.php?edit=true&id=<?php echo $_POST['editPage']?>&file=<?php echo basename($file) . $addToImage ?>"><?php echo basename($file) ?> </a>
                <br/>
                <?php

            }
        }
        if (isset($_POST['postImageButton'])){
        foreach (glob($log_directory . "/*.{jpg,png}", GLOB_BRACE) as $file) {
        ?>


        <a href="http://localhost/CMS-Project/inc/editPage.php?edit=true&id=<?php echo $_POST['editPage']?>&image=<?php echo basename($file) . $addToFile ?>"><?php echo basename($file) ?> </a>
        <br/>
<?php
}
}
}