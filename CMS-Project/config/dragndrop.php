

<div style=" background-color: darkorange;width: 15%; height: 100%;float: left;position: absolute">
    <div class="sortable" style="margin-top: 130px; height: 100px; position: absolute">


        <?php


        $parentBlogs = $db->b_selectOnlyParents();
        $currentDate = new DateTime();
        while ($pb = $parentBlogs->fetch_assoc()) {
            if ($pb['active'] == true && ($pb['dateEnd']) >= ($currentDate->format('Y-m-d'))) {
                ?>

                <div class="group-caption" blogId="<?php echo $pb['id'] ?>">
                <div class="move">+</div>
                <h4><a style="color: white;font-size: 20px;"
                       href="inc/blogContent.php?id=<?php echo $pb['id'] ?>"><?php echo $pb['title'] ?></a></h4>

                <?php
                $childBlogs = $db->c_select();

                while ($ch = $childBlogs->fetch_assoc()) {
                    if ($pb['id'] == $ch['parentId']) {

                        $blogs = $db->b_select();
                        while ($b = $blogs->fetch_assoc()) {
                            if ($b['id'] == $ch['childId'] && $b['active'] == true) {

                                ?>
                                <div class="group-items">
                                    <div class="group-item" blogId="<?php echo $b['id'] ?>"><a
                                            style="color: black;font-size: 17px;"
                                            href="inc/blogContent.php?id=<?php echo $b['id'] ?>"><?php echo $b['title'] ?></a>
                                    </div>

                                    <?php

                                    ?>
                                </div>
                                <?php
                                break;
                            }

                        }


                    }
                }
                ?>
                <div class="move">+</div>
                <?php
            }
            ?></div>
            <?php
        }

        ?>
</div>
</div>
