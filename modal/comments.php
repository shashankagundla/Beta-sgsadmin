<?php
/*
 * Page Setup
 */
require_once("../includes/init.php");
//Page Variables
$id = $_GET["id"];
/*
 * Init job class and get info
 */
$job = new Job();
$jobComments = $job->queryJobComments($id);
?>
<div class="actionBox">
    <ul class="commentList">
        <?php foreach($jobComments as $c){ ?>
            <li>
                <?php if (!$_SESSION['mobile']){?>
            <?php
            /*
             * TODO: CommenterImages
              <div class="commenterImage">
                    <img src="https://lh4.googleusercontent.com/-oUozwkil0JM/AAAAAAAAAAI/AAAAAAAABoA/ShUKvKu0akQ/photo.jpg" />
                </div>
             */
            ?>
                <div class="">
                    <?php } ?>
                    <p><?=nl2br($c['comment'])?></p>
                    <span class="date sub-text">By <?=$c['user']?> - <?=timeAgo(strtotime($c['date'])) ?></span>
                    <?php if (!$_SESSION['mobile']){?>
                </div>
            <?php } ?>
            </li>
            <hr>
        <?php } ?>
    </ul>
</div>
