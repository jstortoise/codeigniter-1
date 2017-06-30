<!DOCTYPE html>
<html>
<head>
    <title>Orriz</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('public/scripts/ga', null, true) ?>
<?= $this->load->view('public/top', null, true); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 hidden-xs">
            <div class="front-page-section">
                <div class="front-page-title">
                    <h2>
                        <a href="<?php echo base_url(); ?>public/#" class="front-page-title-links">Join Now!</a>
                        <a href="<?php echo base_url(); ?>public/#" class="front-page-title-links">Make Friends!</a>
                        <a href="<?php echo base_url(); ?>public/#" class="front-page-title-links">Share Life!</a></h2>
                </div>
                <div class="homepage-banner">
                    <img src="<?php echo base_url(); ?>public/images/home-page-banner.jpg" alt="Home Page Banner"/>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="join-form">
                <form role="form" method="post" action="<?php echo base_url(); ?>public/register_member">
                    <div class="form-title">
                        <h5>Join Free!</h5>
                    </div>
                    <div class="join-form-body">
                        <div class="join-form-group">
                            <div class="first-name-field">
                                <input type="text" value="<?php echo set_value('first_name'); ?>"
                                       placeholder="First Name" id="join-first-name" name="first_name"
                                       class="join-form-control" required/>
                                <div class="error"> <?php echo form_error('first_name'); ?>   </div>
                            </div>
                            <div class="last-name-field">
                                <input type="text" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name"
                                       id="join-last-name" name="last_name" class="join-form-control"/>
                                <div class="error"> <?php echo form_error('last_name'); ?>   </div>
                            </div>
                        </div>
                        <div class="join-form-group">
                            <input type="email" placeholder="Email" id="join-first-email"
                                   value="<?php echo set_value('email'); ?>" name="email" class="join-form-control"
                                   required/>
                            <div class="error"> <?php echo form_error('email'); ?>   </div>
                        </div>
                        <div class="join-form-group">
                            <input type="password" placeholder="New Password" id="join-first-password"
                                   value="<?php echo set_value('password'); ?>" name="password"
                                   class="join-form-control" required/>
                            <div class="error"> <?php echo form_error('password'); ?>   </div>
                        </div>
                        <div>
                            <input type="password" placeholder="Confirm Password" id="join-first-password"
                                   value="<?php echo set_value('password_confirm'); ?>" name="password_confirm"
                                   class="join-form-control" required/>
                            <div class="error"> <?php echo form_error('password_confirm'); ?>   </div>
                        </div>
                        <div class="join-form-birthday">
                            <span>Birthday:</span>
                        </div>
                        <div class="join-form-group">
                            <div class="birthday-day">
                                <select class="join-form-control" name="birthday[]" required>
                                    <option value="">Day</option>
                                    <?php for ($i = 1; $i <= 31; $i++) {
                                        if (strlen($i) != 2) {
                                            echo '<option value="' . "0" . $i . '">' . $i . '</option>';
                                        } else
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                    } ?>

                                </select>
                            </div>
                            <div class="birthday-month">
                                <select class="join-form-control" name="birthday[]" required="required">
                                    <option value="">Month</option>
                                    <option value="01" <?php if (set_value('birthday[1]') === "01") echo "Selected"; ?>>
                                        January
                                    </option>
                                    <option value="02" <?php if (set_value('birthday[1]') === "02") echo "Selected"; ?>>
                                        February
                                    </option>
                                    <option value="03" <?php if (set_value('birthday[1]') === "03") echo "Selected"; ?>>
                                        March
                                    </option>
                                    <option value="04" <?php if (set_value('birthday[1]') === "04") echo "Selected"; ?>>
                                        April
                                    </option>
                                    <option value="05" <?php if (set_value('birthday[1]') === "05") echo "Selected"; ?>>
                                        May
                                    </option>
                                    <option value="06" <?php if (set_value('birthday[1]') === "06") echo "Selected"; ?>>
                                        June
                                    </option>
                                    <option value="07" <?php if (set_value('birthday[1]') === "07") echo "Selected"; ?>>
                                        July
                                    </option>
                                    <option value="08" <?php if (set_value('birthday[1]') === "08") echo "Selected"; ?>>
                                        August
                                    </option>
                                    <option value="09" <?php if (set_value('birthday[1]') === "09") echo "Selected"; ?>>
                                        September
                                    </option>
                                    <option value="10" <?php if (set_value('birthday[1]') === "10") echo "Selected"; ?>>
                                        October
                                    </option>
                                    <option value="11" <?php if (set_value('birthday[1]') === "11") echo "Selected"; ?>>
                                        November
                                    </option>
                                    <option value="12" <?php if (set_value('birthday[1]') === "12") echo "Selected"; ?>>
                                        December
                                    </option>
                                </select>
                            </div>

                            <div class="birthday-year">
                                <select class="join-form-control" name="birthday[]" required>
                                    <option value="">Year</option>
                                    <?php for ($i = 1950; $i <= date('Y') - 18; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="error"> <?php echo form_error('birthday'); ?>  </div>
                        </div>
                        <div class="join-form-group">
                            <input type="radio" name="gender"
                                   value="male" <?php if (set_value('gender') === "male") echo "checked"; ?> id="male"
                                   class="radio-label" required/><label for="male" class="radio-label-text">Male</label>
                            <input type="radio" name="gender"
                                   value="female" <?php if (set_value('gender') === "female") echo "checked"; ?>
                                   id="female" class="radio-label" required/><label for="female"
                                                                                    class="radio-label-text">Female</label>
                        </div>
                        <div class="join-free-form-text">
                            <p>By clicking Sign up, you are indicating that you have read & agree to the <a
                                        href="<?php echo base_url(); ?>public/#">Terms of Service</a> and <a
                                        href="<?php echo base_url(); ?>public/#">Privacy Policy</a>.</p>
                        </div>
                        <div class="submit-join-form">
                            <input type="submit" value="Sign Up" class="join-form-submit-button"/>
                        </div>
                        <input type="hidden" name="reference_link" value="<?= isset($reference_link) ? $reference_link : '' ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div align="right"><br />
<span id="cdSiteSeal1"><script type="text/javascript" src="//tracedseals.starfieldtech.com/siteseal/get?scriptId=cdSiteSeal1&amp;cdSealType=Seal1&amp;sealId=55e4ye7y7mb730dbec9962c4e7c129b105y7mb7355e4ye769feabc723fea2b2a"></script></span>
</div>
</div>
<?= $this->load->view('public/footer', null, true); ?>
</body>
</html>