<?php include 'header.php'; ?>
    <tr>
        <td bgcolor="#333333" height="400" style="color: white;">
            <img src="<?= base_url('public/images/800x800.png') ?>" alt="Logo"
                 style="width: 150px; margin: 0 auto; display: block;">
            <h1 style="text-align: center; font-weight: normal; font-size: 40px; letter-spacing: 3px;">
                Welcome to Orriz</h1>
            <h2 style="text-align: center; font-weight: normal;">Thank you for signing up for your new
                account at Orriz.</h2>
            <h2 style="text-align: center; font-weight: normal; margin: -10px;">Follow the link
                below to confirm your account.</h2>
        </td>
    </tr>

    <tr>
        <td bgcolor="white" height="30"></td>
    </tr>

    <tr>
        <td>
            <span style="width: 153px; display: inline-block;"></span>
            <a href="<?= base_url("public/activate/$id/$activation") ?>" target="_blank">
                <img src="<?= base_url('public/images/verify_button.gif') ?>" alt="Verify">
            </a>
        </td>
    </tr>

<?php if(!isset($email)){
    log_message('error', print_r($this->_ci_cached_vars).' identity= '.$identity, true);
} ?>

    <tr>
        <td>
            <table style="color: #646464;">
                <tr>
                    <td>
                        <div style="height: 40px;"></div>
                        <span style="display: inline-block; width: 30px;"></span>
                        <span style="display: inline-block; width: 350px; color: black;"><h2>Your account Information</h2></span>
                        <div></div>
                        <span style="display: inline-block; width: 30px;"></span>
                        <span style="display: inline-block; width: 150px;"><h2>Account:</h2></span>
                        <span style="display: inline-block; width: 470px; word-wrap: break-word; float: right;"><h2><?= $email ?></h2></span>
                        <div></div>
                        <span style="display: inline-block; width: 30px; "></span>
                        <span style="display: inline-block; width: 150px; "><h2>Verify Link:</h2></span>
                        <span style="display: inline-block; width: 470px; word-wrap: break-word; float: right;"><h2><?= base_url("public/activate/$id/$activation") ?></h2></span>
                        <div style="height: 20px;"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php include 'footer.php'; ?>