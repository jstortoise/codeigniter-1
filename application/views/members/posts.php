<?php if ($posts != null) {
    foreach ($posts as $rows) {
        $isLike = $this->posts_model->find_like_on_post($this->session->userdata('user_id'), $rows['id']);
        $likesUser = $this->posts_model->total_likes_user_details($rows['id']);
        if ($rows['last']){
            $last = "Post added {$rows['last']} ago";
        }
        else{
            $last = "Post added moment ago";
        }

        if(!isset($rows['member_id'])){
            log_message('error', print_r($this->_ci_cached_vars, true));
        }
        ?>
        <div class="orriztime orriztime-items mvm no_more_post">
            <a id="newsfeed-refresh-link" class="ng-binding"><span></span></a>
            <div class="orriztime-line"></div>
            <div class="orriztime-date">
                <div style="float:left">
                    <?= date($rows['time']) ?>
                </div>
                <div style="float:right; position:relative; text-align:right; margin-right:10px;">
                    <a href="?id=<?php echo $rows['id']; ?>" title="REPORT THIS POST"><i
                                class="icon-flag icon-1x pull-left" style="color:red"></i></a>
                </div>
            </div>
            <div class="ofv oln ptl pbxs">
                <a class="pull-left thumbnail orriztime-thumbnail" href="<?= $rows['member_url'] ?>">
                    <?php if (($rows['image']) != null) { ?>
                        <img src="<?php echo base_url(); ?>public/images/thumb/<?php echo $rows['image']; ?>"
                             style="width: 75px; height: 75px;"/>
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>public/images/thumb/no.png"
                             style="width: 75px; height: 75px;"/>
                    <?php } ?>
                </a>
                <div class="orriztime-media-body">
                    <div class="orriztime-container">
                        <a class="orriztime-user-name ng-binding"
                           href="<?= $rows['member_url'] ?>"><?php echo $rows['first_name'] . '  ' . $rows['last_name']; ?></a>
                        <span class="orriztime-user-info mls ng-binding"></span>
                        <?php if (($rows['photos']) != null) { ?>
                            <div class="photos">
                                <div class="squarified" data-toggle="modal" data-target="#myModal"
                                     memberId="<?= $rows['member_id'] ?>" photoId="<?= $rows['id'] ?>">
                                    <img src="<?php echo base_url(); ?>public/images/photos/<?php echo $rows['photos']; ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="truncate">
                            <p class="orriztime-status"><?php echo ltrim($rows['status']); ?></p>
                        </div>
                        <div class="orriztime-actions">
                            <a class="action like" href="javascript:void(0);"
                               onclick="like_add('<?php echo $rows['id']; ?>');
                                       return false;"><i class="fa fa-thumbs-up"></i>
                                <span id="heart_<?php echo $rows['id']; ?>"
                                      class=""><?php echo !empty($isLike) ? "Unlike" : "Like"; ?></span></a>
                            <span class="bar"></span>
                            <a class="action comment">
                                <i class="fa fa-comment"></i>
                                <span onclick="get_comments('<?php echo $rows['id']; ?>'); ">Comment</span>
                            </a>
                            <span class="bar"></span>
                            <span class="time-ago"><?= $last ?></span>
                        </div>
                    </div>
                    <div class="orriztime-comments">
                        <div class="orriztime-likes">
                            <div class="orriztime-comment-left tac pts">
                                <i class="fa fa-thumbs-up orriztime-large-thumb"></i>
                                <span id="<?php echo "post_id_" . $rows['id'] . "_likes"; ?>"> <?php echo $rows['likes']; ?>
                                    Likes
                                </span>
                            </div>
                            <div class="orriztime-likers-list">
                                <ul class="lstn mbn">
                                    <?php
                                    if (!empty($likesUser)) {
                                        foreach ($likesUser as $key => $value) {
                                            $user = $this->posts_model->getUserDetails($value['member_id']);
                                            ?>
                                            <li class="dib pts">
                                                <a ref="javascript:void(0);">
                                                    <?php if ($user->image) { ?>
                                                        <img src="<?php echo base_url(); ?>public/images/thumb/<?php echo $user->image; ?>"
                                                             title="<?php echo $user->first_name . ' ' . $user->last_name; ?>"
                                                             class="thumbnail" alt="<?php echo $user->first_name; ?>">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>public/images/thumb/no.png"
                                                             title="<?php echo $user->first_name . ' ' . $user->last_name; ?>"
                                                             class="thumbnail" alt="<?php echo $user->first_name; ?>">
                                                    <?php } ?>
                                                </a>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="orriztime-comment read first">
                            <div class="lh20" id="get_comment_<?php echo $rows['id']; ?>">
                            </div>
                        </div>
                        <div class="orriztime-comment post">
                            <div class="orriztime-comment-left">
                                <?php //echo "<pre>av";print_r($userImage[0]['image']); ?>
                                <div class="thumbnail orriztime-comment-triangle-right">
                                    <?php if (isset($userImage) && $userImage[0]['image'] != '') { ?>
                                        <img src="<?php echo base_url(); ?>public/images/thumb/<?php echo $userImage[0]['image']; ?>"
                                             alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>public/images/thumb/no.png" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="orriztime-container orriztime-comment-container">
                                <form class="form-inline" role="form" id="commentbox_<?php echo $rows['id']; ?>"
                                      action="<?php echo base_url('posts/add_comment'); ?>" method="post">
                                    <button class="btn btn-success  pvs phml pull-right mls button_post_comment"
                                            href="javascript:void(0);" disabled="true"
                                            onclick="add_comment('<?php echo $rows['id']; ?>');
                                                    return false;">Comment
                                    </button>
                                    <div class="textarea-wrapper">
                                        <textarea placeholder="Add comment..."
                                                  class="w100 dib ofh font16 text_post_comment"
                                                  name="comment_<?php echo $rows['id']; ?>"
                                                  id="comment_<?php echo $rows['id']; ?>"></textarea>
                                    </div>
                                    <span id="comment_<?php echo $rows['id']; ?>"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} //else echo "There is no post to show";  ?>
<script>
    $(document).ready(function () {
        $('.text_post_comment').on('keyup change', function () {
            if ($(this).val().length) {
                // $(this).find('.button_post_comment')
                $(this).parents('.textarea-wrapper').prev('.button_post_comment').attr("disabled", false);
            }
            else {
                $(this).parents('.textarea-wrapper').prev('.button_post_comment').attr("disabled", true);
            }
        });
//             $('.text_post_comment').keyup(function(e) {
//                
//                if (e.which == 13) {
//                //e.preventDefault();
//                console.log(($(this).parent().next().find('.button_post_comment').length));
//                $(this).parent().next().find('.button_post_comment').click();
//                
//                return false;
//             }
//         });
    });
</script>