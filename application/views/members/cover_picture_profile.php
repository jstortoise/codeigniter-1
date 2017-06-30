<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="cover-picture-profile">
                <div class="cover-picture" style="background: url('<?= base_url('public/images/' . $topImage) ?>');">
                    <div class="profile-picture">
                        <img src="<?php echo base_url(); ?>public/images/thumb/<?php if (!empty($me->image)) {
                            echo $me->image;
                        } else echo "no.png"; ?>
						" alt="Profile Picture"/>
                    </div>
                    <div class="wraptext" id="wraptextelement"><?= $topText ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>