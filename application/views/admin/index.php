<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container" style="height: 500px;">
    Total Members:= <?php echo $count_members; ?><br>
    Total Payments:= <?php echo $total_payments; ?><br>
    Total Active Members := <?php echo $total_active; ?><br>
    Total Inactive Members := <?php echo $count_members - $total_active; ?><br>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>