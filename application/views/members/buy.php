<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Buy</title>
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
                <div class="referral-content-container res-center">
                    <div class="error"><?php if (isset($message)) {
                            echo $message;
                        } ?></div>
                    <!--                    <form role="form" method="post" action="-->
                    <?php //echo base_url('dashboard/buy'); ?><!--">-->
                    <!--                    <div class="referral-number">-->
                    <!--                        <p>Please Enter Points Quantity(Per Point price=-->
                    <?php //echo $setting['per_point_price']; ?><!--):</p>-->
                    <!--                        <input name="quantity" type="number"/> <button type="submit" name="enter" value="enter">Enter</button>-->
                    <!--                    </div>-->
                    <!---->
                    <!--                    </form>-->
                    <form action="<?php echo base_url('dashboard/buy'); ?>" method="post">
                        <h4>Please Select Number of Points You Want to buy</h4>
                        <?php foreach ($point_price as $price) { ?>
                            <div>
                                <label><input type="radio" name="Amount" value="<?php echo $price['id'] ?>"
                                              required="required"> $<?php echo $price['price']; ?>
                                    = <?php echo $price['quantity']; ?> Points</label></div>
                        <?php } ?>
                        <input type="submit" name="submit" value="Buy" class="btn btn-success make_b_btn">
                    </form>
                    <div class="referral-number">
                        <?php if (isset($amount)) {
                            echo "Points Total Quantity:= " . $quantity . '<br>';
                            echo "Total ammount to pay:=" . $amount . ' ' . $setting['currency'];
                            echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="' . $setting['email'] . '">
        <input type="hidden" name="currency_code" value="' . $setting['currency'] . '">
        <input type="hidden" name="item_number" value="points">
        <input type="hidden" name="item_name" value="points">
        <input type="hidden" name="amount" value="' . $amount . '">
        <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_buynow_pp_142x27.png" border="0" name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!">
</form>';
                        } ?>                    </div>
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
<?= $this->load->view('/public/footer', null, true); ?>
</body>
</html>