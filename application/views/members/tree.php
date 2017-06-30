<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Referral Tree</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/tree.css"/>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<div class="container">
    <div class="row">
        <div class="tree">
            <?php echo $child; ?>
        </div>
    </div>
    <br>
</div>
<?= $this->load->view('/public/footer', null, true); ?>
</body>
</html>