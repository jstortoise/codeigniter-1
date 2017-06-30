<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Edit</title>
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
                <li class="active"><a href="<?php echo base_url('members/edit_about_yourself'); ?>">About yourself</a>
                </li>
<!--                <li><a href="--><?php //echo base_url('members/upload_profile_image'); ?><!--">Upload Image</a></li>-->
                <li><a href="<?php echo base_url('members/change_password'); ?>">Change Password</a></li>
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
                        <h4 class="form-tagline">Edit about yourself</h4>
                        <form role="form" METHOD="post" action="<?php echo base_url('members/edit_about_yourself'); ?>">
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Music:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Fav. Music" name="music"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->music) ? trim($getStep2ProfileDetails->music) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Movies:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Fav. Movies" name="movies"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->movies) ? trim($getStep2ProfileDetails->movies) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">TV:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Fav. TV Shows" name="tv"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->tv) ? trim($getStep2ProfileDetails->tv) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Books:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Fav. Books" name="books"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->books) ? trim($getStep2ProfileDetails->books) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Sports:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Fav. Sports" name="sports"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->sports) ? trim($getStep2ProfileDetails->sports) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Interests:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Interests" name="interests"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->interests) ? trim($getStep2ProfileDetails->interests) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Dreams:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Dreams" name="dreams"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->dreams) ? trim($getStep2ProfileDetails->dreams) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">Best Feature:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="Your Best Feature" name="best_feature"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->best_feature) ? trim($getStep2ProfileDetails->best_feature) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-2-label-col">
                                    <label class="second-step-label">About Me:</label>
                                </div>
                                <div class="step-2-input-field">
                                    <textarea placeholder="About Me" name="about_me"
                                              class="join-form-control second-form-textarea"><?php echo !empty($getStep2ProfileDetails->about_me) ? trim($getStep2ProfileDetails->about_me) : ""; ?></textarea>
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