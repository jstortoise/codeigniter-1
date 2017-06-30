<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
</head>
<body>
<div class="container">
    <form class="form-signin" method="post" action="<?php echo base_url('admin/check_login'); ?>">
        <h2 class="form-signin-heading">Please Login</h2>
        <?php echo $this->session->flashdata('message'); ?> <br>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>
</div> <!-- /container -->
</body>
</html>