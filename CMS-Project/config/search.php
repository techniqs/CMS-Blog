<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instant Search Tutorial</title>
</head>

<body>
<?php

include('..\utility\DbUtility.php');
$db = new \utility\DbUtility();

$search = mysqli_real_escape_string($db->getMysqli(), htmlentities(trim($_POST['searchterm'])));

$find_search = mysqli_query($db->getMysqli(), "SELECT * FROM `blogs` WHERE `title` LIKE '%$search%'");
while ($row = $find_search->fetch_assoc()) {

    $currentDate = new DateTime();
    if ($row['active'] == true && ($row['dateEnd']) >= ($currentDate->format('Y-m-d'))) {
        $title = $row['title'];
        $id = $row['id'];
        ?>

        <a href='../../CMS-Project/inc/blogContent.php?id=<?php echo $id ?>'>Title: <?php echo $title ?><br/></a>
        <?php

    }
}

$find_search = mysqli_query($db->getMysqli(), "SELECT * FROM `blogs` WHERE `text` LIKE '%$search%'");
while ($row = $find_search->fetch_assoc()) {
    $currentDate = new DateTime();
    if ($row['active'] == true && ($row['dateEnd']) >= ($currentDate->format('Y-m-d'))) {

        $text = $row['text'];
        $id = $row['id'];

        $text = substr($text, 0, 10) . "...";
        ?>
        <a href='../../CMS-Project/inc/blogContent.php?id=<?php echo $id ?>'>Text: <?php echo $text ?><br/></a>
        <?php

    }
}


?>
</body>
</html>