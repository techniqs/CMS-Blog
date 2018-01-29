<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Blog - Home</title>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="res/css/style.css">

    <?php
    session_start();
    include('utility\DbUtility.php');
    $db = new \utility\DbUtility();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlentities($_POST['username']);
        $password = htmlentities($_POST['password']);


        if ($username && $password) {

            $var = $db->u_query_password($username);
            if ($password == $var) {

                if (isset($_POST['loginSaved']) &&
                    $_POST['loginSaved'] == 'Yes') {
                    //cookie far far away
                    setcookie("username",
                        "$username",
                        time() + (10 * 365 * 24 * 60 * 60));

                }
                $_SESSION['username'] = $username;
                // echo $_COOKIE[$username];
            } else {
                header("Location: http://localhost/CMS-Project/admin/login.php?loginError=true");

            }
        }
    }


    ?>


    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"
            integrity="sha256-0vBSIAi/8FxkNOSKyPEfdGQzFDak1dlqFKBYqBp1yC4="
            crossorigin="anonymous"></script>

    <script src="ajax/main.js"></script>
    <script src="ajax/sortable.js"></script>

</head>
<body data-decimal-separator="," data-grouping-separator=".">

<div role="navigation" aria-label="jumplinks">
    <a href="#devicesheadline" class="accessibility">Zum Inhalt springen</a>
</div>

<header aria-labelledby="bannerheadline" style="z-index: 1">
    <a href="index.php"><img class="title-image" src="res/img/pandaHomeLogo.png" alt="Blog-Home"></a>

    <h1 class="header-title" id="bannerheadline">
        Menü
    </h1>
    <nav aria-labelledby="navigationheadline">
        <ul class="navigation-list">
            <li>
                <input type="text" id="search" placeholder="Search..">

                <div id="searchresults" style="background-color: ghostwhite;width: 243px; position:absolute;z-index: 1; text-align: left; border-radius: 5px;
                     border: 1px solid #031533;"></div>

            </li>

            <li>
                <!-- TODO : ABMELDEN/Login BUTTION ONLY THERE WHEN LOGGED/loggout IN -->
                <?php
                if (isset($_COOKIE['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="inc/navigation.php">User-Navigation</a>
                            <a href="admin/logout.php">Logout</a>
                        </div>
                    </div>
                    <?php
                    echo '<div class="whitelabel" >[Hallo ' . $_COOKIE['username'] . ']</div>';
                } elseif (isset($_SESSION['username'])) { ?>
                    <div class="dropdown">
                        <button class="dropbtn">User-Menü</button>
                        <div class="dropdown-content">
                            <a href="inc/navigation.php">User-Navigation</a>
                            <a href="admin/logout.php">Logout</a>
                        </div>
                    </div>
                    <?php echo '<div class="whitelabel" >[Hallo ' . $_SESSION['username'] . ']</div>';
                } else {
                    echo '<a style="color:white" href="admin/login.php" class="button" accesskey="1">Login</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
</header>
<?php
include('config\dragndrop.php');

?>

<div class="main-container">
    <main aria-labelledby="devicesheadline">
        <h2 class="main-headline" id="devicesheadline">Blogs</h2>

        <div class="blogs" style="position:relative">
            <?php
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
                $counter = 0;
                $currentDate = new DateTime();
                //Klammer nach dem ganzen HTML shit.


                if ($position > 0) {
                    if ($active == true && ($dateEnd) >= ($currentDate->format('Y-m-d'))) { ?>
                        <div class="blog-outer">
                            <a href="inc/blogContent.php?id=<?php echo $id ?>" class="blog"
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
                                         src="files/<?php echo $image ?>"
                                         alt="Kein Bild ausgewählt">
                                </div>
                            </a>
                            <ul class="blog-actions">
                                <li><span style="color:black">Author: <?php echo $author ?></span></li>
                            </ul>
                        </div>



                        <?php


                    }
                }
            }

            ?>

    </main>

</div>
</div>

<script src="ajax/main.js"></script>

</body>

