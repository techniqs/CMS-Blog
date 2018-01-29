<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>SeitenVerwaltung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">


    <?php
    session_start();

    if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {

        header("Location: http://localhost/CMS-Project/index.php");

    }
    include('..\utility\DbUtility.php');
    $db = new \utility\DbUtility();
    $admin = false;
    $user = false;

    if ((isset($_SESSION['username']) && ($db->u_query_adminRights($_SESSION['username'])) == 1) || (isset($_COOKIE['username']) && ($db->u_query_adminRights($_COOKIE['username'])) == 1)) {
        $admin = true;
    }
    if ((isset($_SESSION['username']) && ($db->u_query_adminRights($_SESSION['username'])) == 0) || (isset($_COOKIE['username']) && ($db->u_query_adminRights($_COOKIE['username'])) == 0)) {
        $user = true;
    }

    if (($admin == false && $user == false)) {
        header("Location: http://localhost/CMS-Project/index.php");
    }

    if (isset($_GET['delete']) && $_GET['delete'] == true) {
        if (isset($_GET['id'])) {
            if ($db->b_position($_GET['id']) == 0) {
                $db->c_realDelete($_GET['id']);
                $db->b_delete($_GET['id']);
            }

            else {
                $db->b_realDelete($_GET['id']);
            }
        }
    }

    if (isset($_GET['activate']) && $_GET['activate'] == true) {
        if (isset($_GET['id'])) {
            $db->b_updateActive($_GET['id'], 0);

        }

    }
    if ((isset($_GET['deactivate']) && $_GET['deactivate'] == true)) {
        if (isset($_GET['id'])) {
            $db->b_updateActive($_GET['id'], 1);
        }
    }


    ?>
</head>
<body data-decimal-separator="," data-grouping-separator=".">


<header aria-labelledby="bannerheadline">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        SeitenVerwaltung
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
<div class="main-container">

    <main aria-labelledby="devicesheadline">
        <h2 class="main-headline" id="devicesheadline">Blogs</h2>
        <div class="blogs">
            <?php
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            //TODO : ADMIN
            if ($admin == true) {
                $whileCounter = 1;
                while ($whileCounter <= 2) {
                    $result = $db->b_select();
                    while ($row = $result->fetch_assoc()) {
                        $counter = 1;
                        $active = false;
                        foreach ($row as $value) {
                            //fetching all rows from database
                            //echo "<td><span style=\"color:#000000\">" . $value . "</span></td>";
                            if ($counter == 1) {
                                $id = $value;
                            }
                            if ($counter == 2) {
                                $author = $value;
                            }
                            if ($counter == 3) {
                                $title = $value;
                            }
                            if ($counter == 4) {
                                $text = $value;
                            }
                            //Care for "NoPic"

                            if ($counter == 5) {
                                $image = $value;
                            }
                            //Care for "NoFile"
                            if ($counter == 6) {
                                $files = $value;
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
                                $position = $value;
                            }

                            $counter++;
                        }

                        $currentDate = new DateTime();
                        //Klammer nach dem ganzen HTML shit.

                        if ($whileCounter == 1) {
                            if ($active == true) {
                                ?>
                                <div class="blog-outer" style="height: 240px;">
                                    <a href="../inc/blogContent.php?id=<?php echo $id ?>" class="blog"
                                       title="Genauere Informationen zu diesem Blog">
                                        <dl class="blog-properties">
                                            <dt>Title</dt>
                                            <dd class="blog-displayname"><?php echo $title ?></dd>
                                            <dt>Text</dt>
                                            <!-- Regulate that only first 3 sentences will be shown -->
                                            <dd class="blog-type"><?php
                                                echo substr($text, 0, 15);
                                                if (strlen($text) > 15) {
                                                    echo "...";
                                                    echo "<br>";
                                                    echo "<br>";
                                                    echo "<span style='color:darkorange'>Für mehr Informationen draufklicken</span>";
                                                }
                                                ?> </dd>
                                        </dl>
                                        <!-- hier kommt image rein -->
                                        <div class="blog-image-container">
                                            <img class="blog-image" width="180" height="180"
                                                 src="../files/<?php echo $image ?>"
                                                 alt="Kein Bild ausgewählt">
                                        </div>
                                    </a>
                                    <ul class="blog-actions">
                                            <span style="color:black">AnfangsDatum: <?php echo $dateBeg ?></span>
                                            <span style="color:black">EndDatum: <?php echo $dateEnd ?></span>
                                            <span style="color:black">Aktiv: <?php if ($active == 1) {
                                                    echo "Ja";
                                                } else {
                                                    echo "Nein";
                                                } ?></span>
                                            <span style="color:black">Author: <?php echo $author ?></span>
                                            <span><a href="pageManagement.php?<?php if ($active == 1) {
                                                echo "activate=true";
                                            } else {
                                                echo "deactivate=true";
                                            } ?>&id=<?php echo $id; ?>"><?php if ($active == 1) {
                                                    echo "Deaktivieren";
                                                } else {
                                                    echo "Aktivieren";
                                                } ?></a></span>

                                            <span><a href="pageManagement.php?delete=true&id=<?php echo $id; ?>">Löschen</a></span>

                                    </ul>
                                </div>


                                <?php
                            }
                        } elseif ($whileCounter == 2) {
                            if ($active == false) {
                                ?>
                                <div class="blog-outer" style="height: 240px;">
                                    <a href="../inc/blogContent.php?id=<?php echo $id ?>" class="blog"
                                       title="Genauere Informationen zu diesem Blog">
                                        <dl class="blog-properties">
                                            <dt>Title</dt>
                                            <dd class="blog-displayname"><?php echo $title ?></dd>
                                            <dt>Text</dt>
                                            <!-- Regulate that only first 3 sentences will be shown -->
                                            <dd class="blog-type"><?php
                                                echo substr($text, 0, 15);
                                                if (strlen($text) > 15) {
                                                    echo "...";
                                                    echo "<br>";
                                                    echo "<br>";
                                                    echo "<span style='color:darkorange'>Für mehr Informationen draufklicken</span>";
                                                }
                                                ?> </dd>
                                        </dl>
                                        <!-- hier kommt image rein -->
                                        <div class="blog-image-container">
                                            <img class="blog-image" width="180" height="180"
                                                 src="../files/<?php echo $image ?>"
                                                 alt="Kein Bild ausgewählt">
                                        </div>
                                    </a>
                                    <ul class="blog-actions">
                                            <span style="color:black">AnfangsDatum: <?php echo $dateBeg ?></span>
                                            <span style="color:black">EndDatum: <?php echo $dateEnd ?></span>
                                            <span style="color:black">Aktiv: <?php if ($active == 1) {
                                                    echo "Ja";
                                                } else {
                                                    echo "Nein";
                                                } ?></span>
                                            <span style="color:black">Author: <?php echo $author ?></span>
                                           <span><a href="pageManagement.php?<?php if ($active == 1) {
                                                echo "activate=true";
                                            } else {
                                                echo "deactivate=true";
                                            } ?>&id=<?php echo $id; ?>"><?php if ($active == 1) {
                                                    echo "Deaktivieren";
                                                } else {
                                                    echo "Aktivieren";
                                                   } ?></a> </span>


                                            <span><a href="pageManagement.php?delete=true&id=<?php echo $id; ?>">Löschen</a> </span>

                                    </ul>
                                </div>

                                <?php
                            }
                        }
                    }
                    $whileCounter++;
                }
            }

            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            //TODO : USER
            elseif ($user == true) {
                $result = $db->b_select();
                while ($row = $result->fetch_assoc()) {
                    $counter = 1;
                    $active = false;
                    foreach ($row as $value) {
                        //fetching all rows from database
                        //echo "<td><span style=\"color:#000000\">" . $value . "</span></td>";
                        if ($counter == 1) {
                            $id = $value;
                        }
                        if ($counter == 2) {
                            $author = $value;
                        }
                        if ($counter == 3) {
                            $title = $value;
                        }
                        if ($counter == 4) {
                            $text = $value;
                        }
                        //Care for "NoPic"

                        if ($counter == 5) {
                            $image = $value;
                        }
                        //Care for "NoFile"
                        if ($counter == 6) {
                            $files = $value;
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

                        $counter++;
                    }
                    $currentDate = new DateTime();
                    //Klammer nach dem ganzen HTML shit.

                    if ((isset($_SESSION['username']) && $_SESSION['username'] == $author) || (isset($_COOKIE['username']) && $_COOKIE['username'] == $author)) {
                        ?>
                        <div class="blog-outer" style="height: 225px;">
                            <a href="../inc/blogContent.php?id=<?php echo $id ?>" class="blog"
                               title="Genauere Informationen zu diesem Blog">
                                <dl class="blog-properties">
                                    <dt>Title</dt>
                                    <dd class="blog-displayname"><?php echo $title ?></dd>
                                    <dt>Text</dt>
                                    <!-- Regulate that only first 3 sentences will be shown -->
                                    <dd class="blog-type"><?php
                                        echo substr($text, 0, 15);
                                        if (strlen($text) > 15) {
                                            echo "...";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<span style='color:darkorange'>Für mehr Informationen draufklicken</span>";
                                        }
                                        ?> </dd>
                                </dl>
                                <!-- hier kommt image rein -->
                                <div class="blog-image-container">
                                    <img class="blog-image" width="180" height="180"
                                         src="../files/<?php echo $image ?>"
                                         alt="Kein Bild ausgewählt">
                                </div>
                            </a>
                            <ul class="blog-actions">
                                <li>
                                    <br/>
                                    <span style="color:black">AnfangsDatum: <?php echo $dateBeg ?></span>
                                    <span style="color:black">EndDatum: <?php echo $dateEnd ?></span>
                                    <span style="color:black">Aktiv: <?php if ($active == 1) {
                                            echo "Ja";
                                        } else {
                                            echo "Nein";
                                        } ?></span>
                                    <span><a href="editPage.php?edit=true&id=<?php echo $id; ?>">Bearbeiten</a></span>
                            </ul>
                        </div>





                        <?php

                    }
                }
            }

            ?>


    </main>
</div>

<script src="../ajax/jquery-3.2.1.js"></script>
<script src="../ajax/main.js"></script>
</body>
