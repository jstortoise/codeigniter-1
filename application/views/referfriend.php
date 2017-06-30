<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Refer Friend</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>

<!-- This is Google Ad Code, please do not make changes on following code -->

        <center><br />
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Orriz - Under menu banner -->
<ins class="adsbygoogle"
     style="display:inline-block;width:970px;height:90px"
     data-ad-client="ca-pub-8451164086915508"
     data-ad-slot="7376237473"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</center>

<!-- Google Code End here -->

<div class="container">
    <div class="refer-points-box">
        <div class="row">
            <?= $this->load->view('members/partials/wallet_referal_container', null, true) ?>
            <div class="col-sm-6">
                <div class="referral-content-container">
                    <div class="referral-number">
                        <p>Refer a friend with the link: <span
                                    class="number-referral-counting"><?php echo base_url() . 'index/' . $reference_link; ?></span>
                        </p>
                    </div>
                    <div class="referral-number">
                        <p>You can copy above link and promote it all over the internet.</p>
                        <p>Every successful activation of your friend's account will give you 10 points.</p>
                        <p>Every your friend will get 10 extra points for registration via this link.</p>
                    </div>
                    <div class="invitation-form">
                        <h6 class="invitation-form-heading">Send Your Friends A Referral Invitation Email</h6>
                        <!--                            --><? //= isset($message) ? $message : '' ?>
                        <form role="form" action="<?php echo base_url('dashboard/reference'); ?>" method="post">
                            <div class="invitation-grop-form">
                                <input type="email" class="invitation-form-control" name="email" required/>
                            </div>
                            <div class="invitation-grop-form">
                                <input type="submit" value="Send Invitation" class="send-invitation-email"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="points-container">
                    <div class="points-counting-container">
                        <div class="points-counting">
                            You have <span class="points-number-counting"><?php echo $points ?></span> Points
                        </div>
                    </div>
                </div>
                <div class="points-button-container">
                    <a href="<?php echo base_url('dashboard/buy'); ?>">
                        <button class="points-button">Buy Points</button>
                    </a>
                    <a href="<?php echo base_url('dashboard/reference'); ?>">
                        <button class="points-button">Earn FREE Points</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<script>
    <?php if (isset($message) && $message != ''){
    $type = strpos($message, 'Successfully') ? 'success' : 'error' ?>
    $(document).ready(function () {
        swal('',
            '<?= $message ?>',
            '<?= $type ?>');
    });
    <?php } ?>
</script>
</body>
</html>