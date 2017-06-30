<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Wallet</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="container">
    <div class="refer-points-box">
        <div class="row">
            <?= $this->load->view('members/partials/wallet_referal_container', null, true) ?>
            <div class="col-sm-6">
                <div class="referral-content-container">
                    <div class="referral-number">
                        <p>Total number of your Referrals: <span
                                    class="direct-referral-counting"><?php echo $total_direct_referel; ?></span></p>
                    </div>
<!--                    <div class="referral-number">-->
<!--                        <p>Total number of your In-direct Referrals: <span-->
<!--                                    class="in-direct-referral-counting">--><?php //echo $total_referel - $total_direct_referel; ?><!--</span>-->
<!--                        </p>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="col-sm-3">
                <div class="points-container">
                    <div class="points-counting-container">
                        <div class="points-counting">
                            You have <span class="points-number-counting"><?php echo $points; ?></span> Points
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
</body>
</html>