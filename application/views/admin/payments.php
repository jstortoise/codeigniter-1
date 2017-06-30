<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Payments</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
    <script>
        $(document).ready(function () {
            $('#example').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url('admin/payments_data'); ?>"
            });
        });

    </script>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <h4>Members List</h4>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
        <tr>
            <th width="20%">Member Email</th>
            <th width="15%">Points Quantity</th>
            <th width="15%">Total Payment</th>
            <th width="25%">Transaction ID</th>
            <th width="25%">Date</th>

        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="5" class="dataTables_empty">Loading data from server</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th width="20%">Member Email</th>
            <th width="15%">Points Quantity</th>
            <th width="15%">Total Payment</th>
            <th width="25%">Transaction ID</th>
            <th width="25%">Date</th>
        </tr>
        </tfoot>
    </table>
</div>
<?= $this->load->view('public/footer', null, true) ?>
</body>
</html>