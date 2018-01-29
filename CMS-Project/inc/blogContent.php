<?php
session_start();
include('..\utility\DbUtility.php');
$db = new \utility\DbUtility();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $blog = $db->b_trySelect($_GET['id']);
    $currentDate = new DateTime();

    } else {
        header("Location: http://localhost/CMS-Project/index.php");
    }
//} else {
   // header("Location: http://localhost/CMS-Project/index.php");
/*
 *
    echo $blog->getFiles();
    echo file_get_contents( "../files/".$blog->getFiles());
 */

//}
if (isset($_GET['download'])&&$_GET['download']==true &&(isset($_GET['id']) && !empty($_GET['id']))){
                     $file = '../files/'.$blog->getFiles();
                     if (file_exists($file)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="'.basename($file).'"');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        readfile($file);
                        exit;

                    }
         }
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $blog->getTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">


</head>

<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        <?php echo $blog->getTitle() ?>
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
                            <a href="navigation.php">User-Navigation</a>
                            <a href="../admin/logout.php">Logout</a>
                        </div>
                    </div>
                    <?php
                    echo '<div class="whitelabel" >[Hallo ' . $_COOKIE['username'] . ']</div>';
                } elseif (isset($_SESSION['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="navigation.php">User-Navigation</a>
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
    <main aria-labelledby="devicesheadline">

                    <!-- Image -->

            <a  href="../files/<?php echo $blog->getImage()?>" style="margin: 0px auto"><img style="margin-left: 135px;"  width="720" height="360"
                 src="../files/<?php echo $blog->getImage() ?>"
                 alt="Kein Bild ausgewählt"></a>


        <!-- Title Input -->
        <div class="form-row">
            <label class="form-label" for="text-input">
                <div class="blacklabel">
                    Überschrift
                </div>
            </label>
            <input type="text" name="title" required class="form-input"
                   value="<?php echo $blog->getTitle() ?>" readonly>
        </div>

        <!-- Texteingabe-->
        <div class="form-row">
            <label class="form-label" for="text-input">
                <div class="blacklabel">
                    Text

                </div>
            </label>

            <textarea name="text" cols="100" rows="17" required
                      class="textareaInput" readonly><?php echo $blog->getText() ?></textarea>

        </div>

        <!-- DateBeg Input -->
        <div class="form-row">
            <label class="form-label" for="username-input">
                <div class="blacklabel">
                    Von
                </div>
            </label>
            <input type="date" name="dateBeg" required class="form-input"
                   value="<?php echo $blog->getDateBeg() ?>" readonly>
        </div>

        <!-- DateEnd Input -->
        <div class="form-row">
            <label class="form-label" for="username-input">
                <div class="blacklabel">
                    Bis
                </div>
            </label>
            <input type="date" name="dateEnd" required class="form-input"
                   value="<?php echo $blog->getDateEnd() ?>" readonly>
        </div>

        <!--Datei hochladen-->
        <div class="form-row">
            <label class="blacklabel"> <?php
                if ($blog->getFiles()=="NoFile") {
                    echo "Keine Datei ausgewählt.";
                    }
                    else{
                    ?>
                    <span style="color: black">Dokument downloaden: <a href="blogContent.php?download=true&id=<?php echo $blog->getId()?>"><?php echo $blog->getFiles()?></a></span>
                    <?php

                   }
                ?>
            </label>
        </div>

        <!--Oberblog selecten-->
        <div class="form-row">
            <?php if ($blog->getPosition()==0){
                $parentId=$db->c_selectParentId($blog->getId());
                 $parentTitle=$db->b_selectTitle($parentId)
                ?>
            <label class="blacklabel"> Unterblog von <?php echo $parentTitle ?></label>

        </div>
        <?php }