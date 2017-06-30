<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
    <script>
        $(document).ready(function () {
            $('#example').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url('admin/members_data'); ?>"
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
            <th width="20%">ID</th>
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
            <th width="20%">ID</th>
            <th width="20%">Member Name</th>
            <th width="25%">Email</th>
            <th width="25%">Country</th>
            <th width="15%">Status</th>
            <th width="15%">Points</th>
        </tr>
        </tfoot>
    </table>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<script>
    var id;
    var current;
    var new_points;
    $(document).ajaxComplete(function () {
        $('.points-to-update').unbind();
        $('.points-to-update-field').unbind();


        $('.points-to-update').click(function () {
            current = $(this);
            current.addClass('hide');
            current.next().removeClass('hide');
        });

        $('.points-to-update-field').keypress(function (e) {
            current = $(this);
            new_points = current.val();
            if (e.which == 13) {
                id = $(this).prev().attr('id');
                $.ajax({
                    method: "POST",
                    data: {id: id, points: new_points},
                    url: "<?php echo base_url('admin/update_points'); ?>"
                }).done(function (data) {
                    if (data == 'success') {
                        current.addClass('hide');
                        current.prev().html(new_points);
                        current.prev().removeClass('hide');
                    } else {
                        alert(data);
                    }
                });
            }
        });
    });
</script>
</body>
</html>