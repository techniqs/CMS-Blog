<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Seitenbearbeitung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">


    <?php
    session_start();

    if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

        header("Location: http://localhost/CMS-Project/index.php");

    }
    include('..\utility\DbUtility.php');
    $db = new \utility\DbUtility();

    if (!isset($_GET['edit']) || $_GET['edit'] == false || !isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: http://localhost/CMS-Project/index.php");
    }

    if (isset($_GET['edit']) && $_GET['edit'] == true && isset($_GET['id']) && !empty($_GET['id'])) {
        $blog = $db->b_trySelect($_GET['id']);
    }

    if (isset($_GET['saveEdit'])) {

        $dateBeg = new DateTime($_SESSION['dateBeg']);
        $dateEnd = new DateTime($_SESSION['dateEnd']);
        $currentDate = new DateTime();

        if (strtotime($dateEnd->format('Y-m-d')) < strtotime($currentDate->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('End-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";

        } elseif (strtotime($dateBeg->format('Y-m-d')) > strtotime($dateEnd->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht nach dem End-Datum gesetzt werden');</script>";
        } elseif (strtotime($dateBeg->format('Y-m-d')) == strtotime($dateEnd->format('Y-m-d'))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht gleich dem End-Datum gesetzt werden');</script>";

        } elseif (strtotime($dateBeg->format('Y-m-d')) < (strtotime($currentDate->format('Y-m-d')))) {
            echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";
        } else {
            $text = $_SESSION['text'];
            $title = $_SESSION['title'];
            $image = $_SESSION['imageInput'];
            //NoPic
            $file = $_SESSION['fileInput'];
            //NoFile
            $position = $_SESSION['position'];
            $id = $_SESSION['editPage'];

            if (!empty($title)) {
                $db->b_updateTitle($id,$title);
            }
            if (!empty($text)) {
                $db->b_updateText($id,$text);

            }
            if ($image!="NoPic") {
                $db->b_updateImage($id,$image);

            }
            if ($file!="NoFile") {
                $db->b_updateFiles($id,$file);

            }
            $db->b_updateDateBeg($id,$dateBeg->format('Y-m-d'));
            $db->b_updateDateEnd($id,$dateEnd->format('Y-m-d'));
            //Has To be activated again by admin after edit.
            $db->b_updateActive($id,0);

            echo "<script type='text/javascript'>alert('Blog wurde geupdated!');</script>";
            header("Location: http://localhost/CMS-Project/inc/blogContent.php?id=".$id);




        }
    }





    ?>
</head>
<body data-decimal-separator="," data-grouping-separator=".">


<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        Seitenbearbeitung
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
                echo '<div class="whitelabel" > </div>';
                } elseif (isset($_SESSION['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="../inc/navigation.php">User-Navigation</a>
                            <a href="../admin/logout.php">Logout</a>
                        </div>
                    </div>
                <?php echo '<div class="whitelabel" >[Hallo ' . $_SESSION['username'] . ']</div>';
                $currentDate = new DateTime();

                echo '<div class="whitelabel">[Heutiges Datum: ' . $currentDate->format('d-m-Y') . ']</div>';

                } else {
                echo '<a href="../admin/login.php" class="button" accesskey="1">Login</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
</header>
<div>
    <div style="width: 45%;float: left; margin-left: 50px;">

        <!-- Image -->
        <div class="form-row">
            <a href="../files/<?php echo $blog->getImage() ?>" style="margin: 0px auto">
                <img style="margin: 0px auto"
                     width="480" height="180"
                     src="../files/<?php echo $blog->getImage() ?>"
                     alt="Kein Bild ausgewählt"></a>
            <h1 style="color: black">Alter Blog</h1>

        </div>


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
                if ($blog->getFiles() == "NoFile") {
                echo "Keine Datei ausgewählt.";
                } else {
                ?>
                <span style="color: black">Dokument downloaden: <a
                            href="blogContent.php?download=true&id=<?php echo $blog->getId() ?>"><?php echo $blog->getFiles() ?></a></span>
                <?php

                }
                ?>
            </label>
        </div>


    </div>


    <form class="ajax" action="../ajax/listAllFiles.php" method="post">
        <div style="width: 45%; float: right;margin-right: 50px">

            <!-- Image -->
            <div class="form-row">
                <h1 style="color: black">Neuer Blog</h1>
                <a href="../files/<?php if (isset($_GET['image'])) {
                echo $_GET['image'];
                } else {
                echo $blog->getImage();
                } ?>" style="margin: 0px auto">
                    <img style="margin: 0px auto"
                         width="480" height="180"
                         src="../files/<?php if (isset($_GET['image'])) {
                         echo $_GET['image'];
                         } else {
                         echo $blog->getImage();
                         } ?>"
                         alt="Kein Bild ausgewählt"></a>


            </div>

            <!-- Title Input -->
            <div class="form-row">
                <label class="form-label" for="text-input">
                    <div class="blacklabel">
                        Überschrift
                    </div>
                </label>
                <input type="text" name="title" required class="form-input"
                       value="<?php if (isset($_SESSION['title'])) {
                       echo $_SESSION['title'];
                       } else {
                       echo $blog->getTitle();
                       } ?>">
            </div>

            <!-- Texteingabe-->
            <div class="form-row">
                <label class="form-label" for="text-input">
                    <div class="blacklabel">
                        Text

                    </div>
                </label>

                <textarea name="text" cols="100" rows="17" required
                          class="textareaInput"><?php if (isset($_SESSION['text'])) {
                    echo $_SESSION['text'];
                    } else {
                    echo $blog->getText();
                    } ?></textarea>

            </div>

            <!-- DateBeg Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Von
                    </div>
                </label>
                <input type="date" name="dateBeg" required class="form-input"
                       value="<?php if (isset($_SESSION['dateBeg'])) {
                       echo $_SESSION['dateBeg'];
                       } else {
                       echo $blog->getDateBeg();
                       } ?>">
            </div>

            <!-- DateEnd Input -->
            <div class="form-row">
                <label class="form-label" for="username-input">
                    <div class="blacklabel">
                        Bis
                    </div>
                </label>
                <input type="date" name="dateEnd" required class="form-input"
                       value="<?php if (isset($_SESSION['dateEnd'])) {
                       echo $_SESSION['dateEnd'];
                       } else {
                       echo $blog->getDateEnd();
                       } ?>">
            </div>


            <!--Bild hochladen-->
            <div class="form-row">
                <input name="imageInput" type="hidden" value='<?php
                if (isset($_GET['image'])) {
                echo $_GET['image'];
                } elseif (isset($_SESSION['imageInput'])) {
                echo $_SESSION['imageInput'];
                } else {
                echo "NoPic";
                } ?>'>
                <input type="submit" class="button" name="postImageButton" value="Bild auswählen"/>

                <label class="blacklabel"><?php
                    if (isset($_GET['image']) && $_GET['image'] != "NoPic") {
                    echo $_GET['image'];
                    } elseif (isset($_SESSION['imageInput'])) {
                    echo $_SESSION['imageInput'];
                    } else {
                    echo "Kein Bild ausgewählt";
                    } ?></label>
            </div>

            <!--Datei hochladen-->
            <div class="form-row">
                <!--<input type="file" name="files"/>-->
                <input name="fileInput" type="hidden" value='<?php
                if (isset($_GET['file'])) {
                echo $_GET['file'];
                } elseif (isset($_SESSION['fileInput'])) {
                echo $_SESSION['fileInput'];
                } else {
                echo "NoFile";
                } ?>'>
                <input type="submit" class="button" name="postFileButton" value="Datei auswählen"/>
                <label class="blacklabel"> <?php
                    if (isset($_GET['file']) && $_GET['file'] != "NoFile") {
                    echo $_GET['file'];
                    } elseif (isset($_SESSION['fileInput'])) {
                    echo $_SESSION['fileInput'];
                    } else {
                    echo "Keine Datei ausgewählt";
                    } ?>
                </label>
            </div>


            <!--Oberblog selecten-->

            <input name="position" value="<?php echo $blog->getPosition() ?>" hidden>


            <input name="editPage" value="<?php echo $blog->getId() ?>" hidden> <!--Only for listAllFiles.php -->

            <!--SUBMIT-->
            <div class="form-row form-row-center">
                <input type="submit" class="button button-submit" name="saveEdit" value="Speichern"/>
            </div>

        </div>
    </form>
</div>



