<?php include 'header.php'; ?>
    <tr>
        <td bgcolor="#333333" height="400" style="color: white;">
            <img src="<?= base_url('public/images/800x800.png') ?>" alt="Logo"
                 style="width: 150px; margin: 0 auto; display: block;">
            <h1 style="text-align: center; font-weight: normal; font-size: 40px; letter-spacing: 3px;">Orriz password
                reset system</h1>
            <h2 style="text-align: center; font-weight: normal;"><?= sprintf(lang('email_forgot_password_heading'), $identity) ?></h2>
        </td>
    </tr>

    <tr>
        <td bgcolor="white" height="30"></td>
    </tr>

    <tr>
        <td>
            <div style="height: 40px;"></div>
            <span style="display: inline-block; width: 30px;"></span>
            <span><h3 style="color: #646464; display: inline-block; width: 600px; word-wrap: break-word;">You have requested to recover your Orriz password. Please click on the link below to reset your password.</h3></span>
        </td>
    </tr>

    <tr>
        <td>
            <div style="height: 40px;"></div>
            <span style="width: 132px; display: inline-block;"></span>
            <a href='<?= base_url("public/reset_password/$forgotten_password_code") ?>' target="_blank">
                <img src="<?= base_url('public/images/reset_password.gif') ?>" alt="Reset password">
            </a>
        </td>
    </tr>

    <tr>
        <td>
            <div style="height: 40px;"></div>
            <span style="display: inline-block; width: 30px;"></span>
            <span style="display: inline-block; width: 150px; "><h2
                        style="color: #646464;">Reset password Link:</h2></span>
            <span style="display: inline-block; width: 470px; word-wrap: break-word; float: right;"><h2
                        style="color: #646464;"><?= base_url("public/reset_password/$forgotten_password_code") ?></h2></span>
            <div style="height: 20px;"></div>
        </td>
    </tr>

<?php include 'footer.php'; ?>