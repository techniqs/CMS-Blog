<?php
session_start();

if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {
    header("Location: http://localhost/CMS-Project/index.php");
}


include('..\utility\DbUtility.php');
$db = new \utility\DbUtility();

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Menü</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../res/css/style.css">

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"
            integrity="sha256-0vBSIAi/8FxkNOSKyPEfdGQzFDak1dlqFKBYqBp1yC4="
            crossorigin="anonymous"></script>



    <script src="../ajax/main.js"></script>
    <script src="../ajax/sortable.js"></script>
</head>
<body data-decimal-separator="," data-grouping-separator=".">

<header aria-labelledby="bannerheadline" style="z-index: 1">
    <a href="../index.php"><img class="title-image" src="../res/img/pandaHomeLogo.png" alt="User-Navigation"></a>

    <h1 class="header-title" id="bannerheadline"">
        User-Navigation
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


<?php
include ('../config/dragndrop.php');
?>

<div class="main-container">
    <main aria-labelledby="formheadline">
        <h2 id="formheadline" class="registration-headline" style="font-size: 25px">Aktion auswählen</h2>

        <div>
            <?php
            $nav_xml = simplexml_load_file('../config/navigation.xml');

            foreach ($nav_xml->usermenu as $elem) {
                foreach ($elem as $key => $value) {
                    $usermenu[(string)$key] = (string)$value;
                    ?>
                    <!-- TODO : Die Links an die einzelnen seiten verweisen -->
                    <li style="color: #CC4800"><a style="font-size: 20px;" href=<?php echo (string)$value->link; ?> ><?php echo (string)$value->name; ?></a>
                    </li>
                    <?php
                }
            }

            // TODO: if Anweisung so bearbeiten das überprüft wird ob admin oder nomraler user zugreift
              if (isset($_SESSION['username'])&&($db->u_query_adminRights($_SESSION['username']))==1){
                foreach($nav_xml->adminmenu as $elem)
                {
                    foreach($elem as $key => $value)
                    {
                        $usermenu[(string)$key] = (string)$value;
                        ?>
                        <!-- TODO : Die Links an die einzelnen seiten verweisen -->
                        <li style="color: #CC4800"><a style="font-size: 20px" href=<?php echo (string)$value->link; ?>><?php echo (string)$value->name; ?></a>

                        </li>
                        <?php
                    }
                }
            }
            elseif (isset($_COOKIE['username'])&& ($db->u_query_adminRights($_COOKIE['username']))==1){
                foreach($nav_xml->adminmenu as $elem)
                {
                    foreach($elem as $key => $value)
                    {
                        $usermenu[(string)$key] = (string)$value;
                        ?>
                        <!-- TODO : Die Links an die einzelnen seiten verweisen -->
                        <li style="color: #CC4800"><a style="font-size: 20px" href=<?php echo (string)$value->link; ?>><?php echo (string)$value->name; ?></a>

                        </li>
                        <?php
                    }
                }

            }
            ?>
        </div>
    </main>
</div>



</body>
</html>

