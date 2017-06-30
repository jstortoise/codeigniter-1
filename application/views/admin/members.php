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
        <h4>Member Detail
            <h5 class="error"><?php echo $this->session->flashdata('message');
                unset($_SESSION['message']); ?></h5>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               value="<?php echo $member_detail[0]['first_name'] . " " . $member_detail[0]['last_name']; ?>"
                               id="name" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php echo $member_detail[0]['email']; ?>" class="form-control"
                               id="email" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php if ($member_detail['0']['active'] == 1) {
                            echo "Active";
                        } elseif ($member_detail[0]['active'] == 0) echo "Inactive" ?>" class="form-control" id="status"
                               disabled>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="<?php echo base_url('admin/editmember') . '/' . $member_detail['0']['id']; ?>"
                           class="btn btn-default">Edit </a>
                        <a href="<?php echo base_url('admin/deletemember') . '/' . $member_detail['0']['id']; ?>"
                           class="btn btn-default">Delete </a>
                        <a href="<?php echo base_url('admin/memberslist'); ?>" class="btn btn-default">Cancel </a>
                    </div>
                </div>
            </form>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>