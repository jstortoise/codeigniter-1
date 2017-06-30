<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Change Password</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('members/cover_picture_profile', null, true) ?>
<div class="container">
    <div class="row">

        <div class="panel-body">
            <ul class="nav nav-tabs edit_prtab" role="tablist">
                <li><a href="<?php echo base_url('members/edit_profile'); ?>">Edit profile info</a></li>
                <li><a href="<?php echo base_url('members/edit_about_yourself'); ?>">About yourself</a></li>
<!--                <li><a href="--><?php //echo base_url('members/upload_profile_image'); ?><!--">Upload Image</a></li>-->
                <li class="active"><a href="<?php echo base_url('members/change_password'); ?>">Change Password</a></li>
            </ul>
        </div>

        <div class="col-xs-12">
            <div style="color: #F8BB22">   <?php echo $this->session->flashdata('message'); ?> </div>
            <div class="first-step-form">
                <div class="form-title">
                    <h5>Edit Profile</h5>
                </div>
                <div class="join-form-body">
                    <div class="from-body-container">
                        <h4 class="form-tagline">Edit Your Profile Password</h4>
                        <form role="form" method="post" action="<?php echo base_url(); ?>members/change_password">
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">Current Password:</label>
                                </div>
                                <div class="step-input-field">
                                    <input type="password" placeholder="Your Current Password"
                                           value="<?php echo set_value('password'); ?>" name="password"
                                           class="join-form-control" required="required"/>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">New Password:</label>
                                </div>
                                <div class="step-input-field">
                                    <input type="password" placeholder="New Password" name="new_password"
                                           value="<?php echo set_value('new_password'); ?>" class="join-form-control"
                                           required="required"/>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">Confirm Password:</label>
                                </div>
                                <div class="step-input-field">
                                    <input type="password" placeholder="Confirm Password" name="new_confirm"
                                           value="<?php echo set_value('new_confirm'); ?>" class="join-form-control"
                                           required="required"/>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-label-col">
                                </div>
                                <div class="step-input-field">
                                    <input type="submit" value="Save" class="add-detail-submit-button"/>
                                    <div class="skip-button">
                                        <span>or</span>
                                        <a class="add-detail-skip" href="<?php echo base_url('dashboard/index'); ?>">
                                            Cancel </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('/public/footer', null, true); ?>
</body>
</html>