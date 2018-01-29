<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Blog erstellen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">

</head>
<?php
session_start();
$msgimage = "";
$msgfile = "";
$author = "";
if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

    header("Location: http://localhost/CMS-Project/index.php");
}
if (isset($_SESSION['username'])) {
    $author = $_SESSION['username'];
}
if (isset($_COOKIE['username'])) {
    $author = $_COOKIE['username'];

}

include('../utility/DbUtility.php');
include('../model/Blog.php');
$db = new \utility\DbUtility();


if (isset($_GET['savesite'])) {

    $text = $_SESSION['text'];
    $title = $_SESSION['title'];
    $selectedPosition =$_SESSION['position'];


    $dateBeg = new DateTime($_SESSION['dateBeg']);
    $dateEnd = new DateTime($_SESSION['dateEnd']);
    $currentDate = new DateTime();

    $image = $_SESSION['imageInput'];
    $files = $_SESSION['fileInput'];


    if (strtotime($dateEnd->format('Y-m-d')) < strtotime($currentDate->format('Y-m-d'))) {
        echo "<script type='text/javascript'>alert('End-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";

    } elseif (strtotime($dateBeg->format('Y-m-d')) > strtotime($dateEnd->format('Y-m-d'))) {
        echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht nach dem End-Datum gesetzt werden');</script>";
    } elseif (strtotime($dateBeg->format('Y-m-d')) == strtotime($dateEnd->format('Y-m-d'))) {
        echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht gleich dem End-Datum gesetzt werden');</script>";

    } elseif (strtotime($dateBeg->format('Y-m-d')) < (strtotime($currentDate->format('Y-m-d')))) {
        echo "<script type='text/javascript'>alert('Anfangs-Datum des Blogs kann nicht vor dem heutigen Datum gesetzt werden');</script>";

    } else {
        $uniqid=uniqid();
        if ($selectedPosition=="None") {
        $result = $db->b_select();
        $position = 1;
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $value) {
                if ($counter == 10) {
                    if ($value != 0) {
                        $position++;
                    }
                }
                $counter++;
            }
            $counter = 1;
        }
    }
    else{
        $position=0;

        $result = $db->c_select();
        $dbPos = 1;
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $value) {
                if ($counter == 1 && $value==$selectedPosition) {
                        $dbPos++;
                }
                $counter++;
            }
            $counter = 1;
        }
            $db->c_insert($selectedPosition,$uniqid,$dbPos);
    }
        $blog = new \model\Blog($uniqid, $author, $title, $text, $image, $files, 0, $dateBeg->format('Y-m-d'), $dateEnd->format('Y-m-d'), $position);
        $db->b_insert($blog);
        echo "<script type='text/javascript'>alert('Blog wurde erstellt!');</script>";

        header("Location: http://localhost/CMS-Project/inc/blogContent.php?id=".$uniqid);



    }
}

?>

<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="User-Navigation"></a>

    <h1 class="header-title" id="bannerheadline">
        Blog erstellen
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
        <form class="ajax" action="listAllFiles.php" method="post">
            <h2 id="formheadline" class="registration-headline">Seite erstellen</h2>



            <?php

            /*
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * TODO: CHECK THIS
             * Not Sure anymore if necessary or not LUL
             */


            $titleValue = "&title=";
            if (isset($_GET['file'])) {
                $titleValue = $titleValue . $_GET['file'];
            }
            $textValue = "&text=";
            if (isset($_GET['file'])) {
                $textValue = $textValue . $_GET['file'];
            }
            $dateBegValue = "&dateBeg=";
            if (isset($_GET['file'])) {
                $dateBegValue = $dateBegValue . $_GET['file'];
            }
            $dateEndValue = "&dateEnd=";
            if (isset($_GET['file'])) {
                $dateEndValue = $dateEndValue . $_GET['file'];
            }
            $imageValue = "&image=";
            if (isset($_GET['image'])) {
                $imageValue = $imageValue . $_GET['image'];
            }
            $fileValue = "&file=";
            if (isset($_GET['file'])) {
                $fileValue = $fileValue . $_GET['file'];
            }

            ?>


            <!-- Title Input -->
            <div class="form-row">
                <label class="form-label" for="title">
                    <div class="blacklabel">
                        Überschrift
                    </div>
                </label>
                <input type="text" name="title" required class="form-input"
                       value="<?php if (isset($_SESSION['title'])) {
                           echo $_SESSION['title'];
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
            <div class="form-row">
                <label class="blacklabel"> Wähle einen Oberblog aus </label>
                <select style='color: black' name="position">
                    <?php
                    $result = $db->b_select();
                    $counter = 1;
                    $idSelect = "";
                    $titleSelect = "";
                    while ($row = $result->fetch_assoc()) {
                        foreach ($row as $value) {
                            if ($counter == 1) {
                                $idSelect = $value;
                            }
                            if ($counter == 3) {
                                $titleSelect = $value;
                            }
                            if ($counter == 7) {
                                $active = $value;
                            }
                            //TODO No need for Datebeg though but whatever
                            if ($counter == 8) {
                                $dateBeg = $value;
                            }
                            if ($counter == 9) {
                                $dateEnd = $value;
                            }
                            if ($counter == 10) {
                                $positionOfBlog = $value;
                            }
                            $counter++;
                        }
                        $currentDate=new DateTime();
                        if ($active == true && ($dateEnd) >= ($currentDate->format('Y-m-d'))) {
                            if ($positionOfBlog > 0) {
                                ?>
                                <option style='color:black' <?php if (isset($_SESSION['position']) && $_SESSION['position'] == $idSelect) {
                                    ?> selected="selected" <?php } ?>
                                        value='<?php echo $idSelect ?>'><?php echo $titleSelect ?></option> <?php
                            }
                        }
                        $counter = 1;

                    }
                    ?>
                    <option style='color: black' <?php
                    if (!isset($_SESSION['position']) || (isset($_SESSION['position']) && $_SESSION['position'] == "None")) { ?>
                        selected="selected" <?php } ?> value='None'>None
                    </option>

                </select>
            </div>

            <!--SUBMIT-->
            <div class="form-row form-row-center">
                <input type="submit" class="button button-submit" name="savesite" value="Speichern"/>
            </div>
        </form>

    </main>
</div>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="main.js"></script>
</body>
</html>