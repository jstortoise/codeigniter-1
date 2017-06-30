<?php include 'header.php'; ?>
    <tr>
        <td bgcolor="#333333" height="400" style="color: white;">
            <img src="<?= base_url('public/images/800x800.png') ?>" alt="Logo"
                 style="width: 150px; margin: 0 auto; display: block;">
            <h1 style="text-align: center; font-weight: normal; font-size: 40px; letter-spacing: 3px;">
                Invitation to Orriz</h1>
            <h2 style="text-align: center; font-weight: normal;">You was invited by our member.</h2>
        </td>
    </tr>

    <tr>
        <td bgcolor="white" height="30"></td>
    </tr>

    <tr>
        <td bgcolor="white" height="50">
            <h3 style="text-align: center;">Our member <?= $fname . ' ' . $lname ?> has invited you to our team.</h3>
        </td>
    </tr>
    <tr>
        <td bgcolor="white" height="50">
            <h3 style="text-align: center;">Please press the button below to register.</h3>
        </td>
    </tr>
    <tr>
        <td bgcolor="white" height="30"></td>
    </tr>
    <tr>
        <td>
            <span style="width: 153px; display: inline-block;"></span>
            <a href="<?= $link ?>" target="_blank">
                <img src="<?= base_url('public/images/register_button.gif') ?>" alt="Register">
            </a>
        </td>
    </tr>

    <tr>
        <td style="padding: 30px; color: #646464;">
            <span style="display: inline-block; width: 150px; "><h3>Register Link:</h3></span>
            <span style="display: inline-block; width: 470px; word-wrap: break-word; float: right;"><h3><?= $link ?></h3></span>
            <div style="height: 20px;"></div>
        </td>
    </tr>
<?php include 'footer.php'; ?>