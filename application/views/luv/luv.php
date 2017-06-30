<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Luv</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/imgareaselect-default.css"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.imgareaselect.js"></script>
</head>
<body>
<div class="yellow-line"></div>
<?php echo $this->load->view('members/dashboard_top', null, true);
$im = $me->image ? $me->image : 'no.png'; ?>

<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="clearfix"></div>

<div class="container">
    <div class="titleBox row luv_row">
        <h3>My Luv</h3>
        <hr/>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="avatars-wrapper">
                <img src="<?= base_url() . 'public/images/thumb/' . $im ?>" class="avatar-image"/>
            </div>
        </div>
        <div class="col-sm-9">
            <div><h4 class="h4_img"><?= $me->first_name . ' ' . $me->last_name ?></h4></div>
            <div class="res_center">
                You have <span class="my-free-luv-count"><?= $me->free_luv ? $me->free_luv : 'no' ?></span> free Luv
                <?= isset($me->till_free_luv) ? "($me->till_free_luv till 1 free Luv)" : '' ?>
            </div>
            <div class="res_center">Luv Reaches: <span class="my-luv-points"><?= $me->luv_points ? $me->luv_points : '0' ?></span></div>
        </div>
    </div>

    <div class="row luv_row" style="border-bottom: solid 1px #aaaaaa;">
        <h3>Luv Activity</h3>
    </div>
    <?php foreach ($members as $key => $member) {
        $im = $member->image ? $member->image : 'no.png';
        $im = base_url() . 'public/images/thumb/' . $im;

        $age = isset($member->birthday) ? (date('Y') - date('Y', strtotime($member->birthday))) : '';
        $city = isset($member->city) ? ', ' . $member->city : '';
        $country = isset($member->country) ? ', ' . $member->country : '';

        $last = "$member->first_name $member->last_name gave you a Luv {$member->luvs[0]->last} ago";
        if ($member->luvs[0]->from_member_id == $me->id) {
            $last = "You gave $member->first_name $member->last_name a Luv {$member->luvs[0]->last} ago";
        } ?>
        <div memberId="<?= $key ?>" class="row luv-row member-list<?= $key ?>"
             style="padding-top: 10px; padding-bottom: 10px; border-bottom: solid 1px #aaaaaa;">

            <?php $fromMe = 0;
            $toMe = 0;
            foreach ($member->luvs as $luv) {
                if ($luv->to_member_id == $me->id) {
                    $toMe++;
                } else {
                    $fromMe++;
                }
            }
            $text1 = $fromMe ? "<p count='$fromMe' class='I-gave-luv-count$key'>You have sent $fromMe Luv to this member</p>" : '';
            $text2 = $toMe ? "<p count='$fromMe' class='I-gave-luv-count$key'>You have recieved $toMe Luv from this member</p>" : ''; ?>

            <div class="col-sm-3">
                <div class="avatars-wrapper">
                    <a href="<?= $member->member_url ?>">
                        <img src="<?= $im ?>" class="avatar-image"/>
                    </a>
                </div>
            </div>
            <div class="col-sm-9 luv-details">
                <div class="row">
                    <div class="col-sm-8">
                        <h4><?= $member->first_name . ' ' . $member->last_name ?></h4>
                        <p><?= $age . $city . $country ?></p>
                        <div class="marg_top" style="margin-top: 30px;">
                            <?= $text1 ?>
                            <?= $text2 ?>
                        </div>
                        <div class="bn_luv I-gave-luv<?= $key ?>"
                             memberName="<?= $member->first_name . ' ' . $member->last_name ?>"
                             style="position: absolute; top: 140px;">
                            <?= $last ?>
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-top: 25px;">
                        <div class="give_luv"  style="top: -5px; position: absolute; padding-left: 17px;">
                            <p>Give Luv</p>
                        </div>
                        <div userId="<?= $key ?>" class="heart"><img class="heart-icon"
                                                                     src="<?= base_url() ?>public/images/heart.png"
                                                                     title="Give Luv" style="max-width: 100%;">
                            <div class="luv-give<?= $key ?> success"
                                 style="position: absolute; color: #00CC00; top: 10px; width: 70px;">Luv given!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                </div>

                <i class="fa fa-close fa-2x hide-member-luv" aria-hidden="true" title="Hide"
                   style="position: absolute;"></i>
            </div>

            <div class="hidden-details" style="display: none;">
                <div class="row"
                     style="height: 130px; position: fixed; top: 50px; z-index: 2000; background: white; width: 100%; padding-top: 10px; left: 15px;">
                    <div class="col-sm-4">
                        <div style="width: 110px; height: 110px; padding: 5px; border: solid 1px #cecece;">
                            <img src="<?= $im ?>" id="luvDetailsMemberImage" style="min-width: 100%"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p><h4><?= "$member->first_name $member->last_name" ?></h4></p>
                        <p><?= "has <span class='luv-points$key'>$member->luv_points</span> Luv Reaches" ?></p>
                    </div>
                    <div class="col-sm-4">
                        <div class="give_luv" style="top: -5px; position: absolute; padding-left: 17px;">
                            <p>Give Luv</p>
                        </div>
                        <div userId="<?= $key ?>" class="heart"><img src="<?= base_url() ?>public/images/heart.png"
                                                                     title="Give Luv" style="max-width: 100%;">
                            <div class="luv-give<?= $key ?> success"
                                 style="position: absolute;  color: #00CC00; top: 10px; width: 70px;">Luv given!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="for-details-inner"
                     style="overflow-y: auto; overflow-x: hidden; max-height: 420px; margin-top: 180px; width: 100%;">
                    <?php foreach ($member->luvs as $luv) {
                        $class = '';
                        $im = $member->image ? $member->image : 'no.png';
                        $text = "$member->first_name $member->last_name gave you a Luv $luv->last ago";
                        $icon = 'fa fa-arrow-left fa-2x color-purple';
                        if ($luv->from_member_id == $me->id) {
                            $class = 'from';
                            $im = $me->image ? $me->image : 'no.png';
                            $text = "You gave $member->first_name $member->last_name a Luv $luv->last ago";
                            $icon = 'fa fa-arrow-right fa-2x color-gray';
                        } ?>

                        <div class="row luv-details-row <?= $class ?>">
                            <div class="col-sm-3" style="height: 90px; width: 90px; padding: 5px; margin-left: 25px;">
                                <img src="<?= base_url() . 'public/images/thumb/' . $im ?>" style="max-height: 100%;">
                            </div>
                            <div class="col-sm-2 st_up_text" style="text-align: center;">
                                <i class="<?= $icon ?>" aria-hidden="true" style="padding-top: 35px;"></i>
                            </div>
                            <div class="col-sm-7 st_text" style="padding-top: 40px;">
                                <?= $text ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>

        </div>
    <?php }
    $im = $me->image ? $me->image : 'no.png';?>

</div>
<?= $this->load->view('public/footer', null, true) ?>
<div id="luvDetailsTemplate" style="display: none;">
    <div class="row luv-details-row from">
        <div class="col-sm-3" style="height: 90px; width: 90px; padding: 5px; margin-left: 25px;">
            <img src="<?= base_url() . 'public/images/thumb/' . $im ?>" style="max-height: 100%;">
        </div>
        <div class="col-sm-2" style="text-align: center;">
            <i class="fa fa-arrow-right fa-2x color-gray" aria-hidden="true" style="padding-top: 35px;"></i>
        </div>
        <div class="col-sm-7 userName" style="padding-top: 40px;">
        </div>
    </div>
</div>


<div class="modal fade" id="luvDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="min-width: 400px;">
        <div class="modal-content" style="border: none;">
            <div class="container" style="width: 100%; padding: 0;">
                <div class="row"
                     style="height: 50px;  background-color: #5a5a5a; margin-bottom: 10px; z-index: 2000; position: fixed; width: 100%; left: 15px;">
					 <i class="fa fa-times close_wall visible-xs" aria-hidden="true"></i>
                    <span style="color: white; font-size: 20px; margin-left: 15px; top: 10px; position: absolute;">Detailed History</span>
                </div>
                <div class="for-details" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myLuvInformation" points="<?= $me->points ?>" freeLuv="<?= $me->free_luv ?>" style="display: none;"></div>
<?= $this->load->view('public/scripts/luv', null, true) ?>

<script type="text/javascript">
    $('.luv-row').click(function (e) {
        if (!$(e.target).hasClass('heart-icon') && !$(e.target).hasClass('avatar-image') && !$(e.target).hasClass('success') && !$(e.target).hasClass('hide-member-luv')) {
            $('#luvDetails').modal('show');
            var self = $(e.currentTarget);
            var memberId = self.attr('memberId');
            var details = self.find('.hidden-details').html();
            $('#luvDetails .for-details').html(details);
        }
    });

    $('.hide-member-luv').click(function (e) {
        var self = $(e.currentTarget);
        var parent= $(self.parents().eq(1));
        var userId =parent.attr('memberId');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>luv/not_show_ajax',
            dataType: 'json',
            data: {member_id: userId},
            success: function (data) {
                if (data.result == 'ok') {
                }
            },
            error: function (data) {
            }
        });
        parent.slideUp(400, function(){ parent.remove(); });
    });
</script>
</body>
</html>