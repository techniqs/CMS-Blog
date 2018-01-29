<?php


//var_dump($_POST);


$myfile = fopen("../config/newfile.txt", "w") or die("Unable to open file!");

$postToFile=serialize($_POST);
fwrite($myfile, ($postToFile));

fclose($myfile);




//two functions
//update Position of Parents
//update Position of Children
include('..\utility\DbUtility.php');
$db = new \utility\DbUtility();


foreach ($_POST as $parents){
    //hier meine Parents
    //echo $parents['key'];
    $db->b_updatePosition($parents['key'],$parents['pos']+1);
    if (!empty($parents['children'])) {
        foreach ($parents['children'] as $children) {

            //hier meine children
            //echo $children['key'];
            $db->c_updatePositionWithParents($children['key'],$parents['key'],$children['pos']+1);

            echo "\n";
        }
    }
}










