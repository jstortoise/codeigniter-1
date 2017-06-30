<?php foreach ($photos as $photo) {
    $active='';
    if(isset($photoIdActive) && $photoIdActive==$photo->id){
        $active='active';
    }?>
    <div photoId="<?= $photo->id ?>" class="<?= $active ?> item class<?= $photo->id ?>">
        <img alt="photo" src="<?= $path . $photo->photo ?>">
        <div class="hidden-info" style="display: none;">
            <div class="hidden-info-comments">
                <?php if (count($photo->comments)) {
                    foreach ($photo->comments as $comment) {
                        $im = $members[$comment->member_id]->image ? $members[$comment->member_id]->image : 'no.png'; ?>
                        <div class="photo-comment">
                            <a class="orriztime-comment-left"
                               href="<?= $members[$comment->member_id]->member_url ?>">
                                <img class="thumbnail"
                                     src="<?= base_url() . 'public/images/thumb/' . $im ?>"
                                     alt="">
                            </a>
                            <div class="orriztime-container orriztime-comment-container orriztime-comment-triangle">
                                <a class="orriztime-user-name"
                                   href="<?= $members[$comment->member_id]->member_url ?>"><?= $members[$comment->member_id]->first_name . ' ' . $members[$comment->member_id]->last_name ?></a>
                                <div class="truncate" style="word-wrap: break-word;">
                                    <p><?= $comment->comment ?></p>
                                </div>
                                <div class="actions mts">
                                    <span class="bar"></span>
                                    <span style="font-size: 10px; color: #898989;">on <?= $comment->created_at ?></span>
                                </div>
                            </div>
                        </div>

                    <?php }
                } ?>
            </div>

            <?php $hideLike = '';
            $hideUnlike = '';
            if (!count($photo->likes)) {
                $hideUnlike = 'style="display: none;"';
            }
            foreach ($photo->likes as $key => $l) {
                if ($l == $this->session->userdata('user_id')) {
                    $hideLike = 'style="display: none;"';
                    $hideUnlike = '';
                    break;
                }
                $hideUnlike = 'style="display: none;"';
            } ?>
            <div class="hidden-info-info">
                <div class="row">
                    <div class="col-md-3" style="padding: 0;">
                        <a class="action like" <?= $hideLike ?> photoId="<?= $photo->id ?>">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            <span>Like</span>
                        </a>
                        <a class="action unlike" <?= $hideUnlike ?>
                           photoId="<?= $photo->id ?>">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            <span>Unlike</span>
                        </a>
                    </div>
                    <div class="col-md-9 photo-title-slider"
                         style="padding-right: 20px; height: 40px; text-overflow: ellipsis; word-wrap: break-word; white-space:nowrap; overflow:hidden;">
                        <?= $photo->title ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: -15px; margin-top: 10px;">
                    <div style="font-size: 10px; color: #7b8087; margin-left: 5px;">
                                                    <span count="<?= count($photo->comments) ? count($photo->comments) : '0' ?>"
                                                          class="comments-count-for<?= $photo->id ?>"><?= count($photo->comments) ? 'Comments: ' . count($photo->comments) : '' ?></span>
                        <span count="<?= count($photo->likes) ? count($photo->likes) : '0' ?>"
                              class="likes-count-for<?= $photo->id ?>"><?= count($photo->likes) ? '&nbsp;&nbsp;&nbsp; Likes: ' . count($photo->likes) : '' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
