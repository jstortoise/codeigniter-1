<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?php $this->load->view('public/top'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="front-page-section">
                <div class="front-page-title">
                    <h2>
                        <a href="<?php  echo base_url(); ?>public/#" class="front-page-title-links">Join Now!</a>
                        <a href="<?php  echo base_url(); ?>public/#" class="front-page-title-links">Make Friends!</a>
                        <a href="<?php  echo base_url(); ?>public/#" class="front-page-title-links">Share Life!</a></h2>
                </div>
                <div class="homepage-banner">
                    <img src="<?php  echo base_url(); ?>public/images/home-page-banner.jpg" alt="Home Page Banner" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="join-form">
                <form role="form" method="post" action='<?= base_url("public/reset_password/$code") ?>'>
                    <div class="form-title">
                        <h5>Password Reset!</h5>
                        <h4>Please Enter Your New Password</h4>
                    </div>
                    <div class="join-form-body">
                        <div style="color:#F9B920 " ><?php echo $this->session->flashdata('message_forgot_password'); ?></div>
                        <div style="color: #F8BB22"> <?php if(isset($message)) echo $message ?> </div>
                        <div class="join-form-group">
                            <input type="password" placeholder="New Password" id="new_password" value="<?php echo set_value('new_password'); ?>" name="new_password" class="join-form-control" required  />
                        </div>
                        <div class="join-form-group">
                            <input type="password" placeholder="Confirm New Password" id="new_confirm" value="<?php echo set_value('new_confirm'); ?>" name="new_confirm" class="join-form-control" required />
                        </div>
                        <div class="join-form-group">
                            <input type="hidden" placeholder="Email" id="user_id" value="<?php echo $user_id; ?>" name="user_id" class="join-form-control" required />
                        </div>
                        <div class="submit-join-form">
                            <input type="submit" value="Submit" class="join-form-submit-button" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>