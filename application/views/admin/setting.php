<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes') ?>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <div class="col-md-6">
        <h4>Admin Setting</h4>
        <h5 class="error"><?php echo $this->session->flashdata('message');
            unset($_SESSION['message']);?></h5>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo $setting[0]['name']; ?>" id="name" disabled >
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $setting[0]['email']; ?>" class="form-control" id="email" disabled >
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="<?php echo base_url('admin/editsetting').'/'.$setting['0']['id']; ?>"class="btn btn-default">Edit </a>

                    <a href="<?php echo base_url('admin'); ?>" class="btn btn-default">Cancel </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>