<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <h4>Control Prices</h4>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
    <tr>
        <th width="20%">Member Name</th>
        <th width="25%">Email</th>
        <th width="25%">Country</th>
        <th width="15%">Status</th>
        <th width="15%">Points</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="5" class="dataTables_empty">Loading data from server</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <th width="20%">Member Name</th>
        <th width="25%">Email</th>
        <th width="25%">Country</th>
        <th width="15%">Status</th>
    </tr>
    </tfoot>
</table>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>