<?php foreach ($comments as $comment) {
    ?>
    <a class="orriztime-comment-left" href="#">
        <img class="thumbnail"
             src="<?php echo base_url(); ?>public/images/thumb/<?php if (($comment['image']) != null) {
                 echo $comment['image'];
             } else echo "no.png"; ?>" alt="">
    </a>
    <div class="orriztime-container orriztime-comment-container orriztime-comment-triangle">
        <a class="orriztime-user-name"
           href="#"><?php echo $comment['first_name'] . '  ' . $comment['last_name'] . ': '; ?></a>
        <span class="orriztime-user-info mls"></span>
        <div class="truncate">
            <p><?php echo $comment['comment'] ?></p>
        </div>
        <div class="actions mts">
            <a href="#" class="action like">
                <span></span>
            </a>
            <span class="bar"></span>
            <span class="time-ago">on <?= $comment['timestamp'] ?></span>
        </div>
    </div>
<?php } ?>