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
        <h4>Member Detail</h4>
        <h5 class="error"><?php echo $this->session->flashdata('message');
           ?></h5>
        <form class="form-horizontal" method="post" action="<?php echo base_url('admin/updatemember'); ?>">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" name="first_name" class="form-control" value="<?php echo $member_detail[0]['first_name']; ?>" id="name" >
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" name="last_name" class="form-control" value="<?php echo $member_detail[0]['last_name']; ?>" id="name" >
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" value="<?php echo $member_detail[0]['email']; ?>" class="form-control" id="email">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Change Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="password" placeholder="if want to change password">
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                    <select name="status" class="dropdown">
                        <option value="1" <?php if($member_detail['0']['active']==1){echo "Selected";}?>>Active</option>
                        <option  value="0" <?php if($member_detail['0']['active']==0){echo "Selected";}?>>Inactive</option>
                    </select>

                </div>
                <input type="hidden" name="id" value="<?php echo $member_detail['0']['id'];?>"/>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-default">Update </button>
                    <a href="<?php echo base_url('admin/memberslist'); ?>" class="btn btn-default">Cancel </a>
                </div>
            </div>
        </form>

    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>