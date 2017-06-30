<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <div class="col-md-6">
        <h4>Paypal Setting</h4>
        <h5 class="error"><?php echo $this->session->flashdata('message') ?></h5>
        <form class="form-horizontal" method="post" action="<?php echo base_url('admin/updatepaypal'); ?>">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Gateway Name</label>
                <div class="col-sm-10">
                    <input type="text" name="gateway_name" class="form-control"
                           value="<?php echo $paypal_detail[0]['gateway_name']; ?>" id="name">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" value="<?php echo $paypal_detail[0]['email']; ?>"
                           class="form-control" id="email">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Url</label>
                <div class="col-sm-10">
                    <input type="text" name="url" value="<?php echo $paypal_detail[0]['url']; ?>" class="form-control"
                           id="email">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Currency</label>
                <div class="col-sm-10">
                    <input type="text" name="currency" value="<?php echo $paypal_detail[0]['currency']; ?>"
                           class="form-control" id="email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Update</button>

                    <a href="<?php echo base_url('admin/paypal'); ?>" class="btn btn-default">Cancel </a>
                </div>
            </div>
        </form>

    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>