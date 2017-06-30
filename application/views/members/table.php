<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Table</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<div class="container">
    <div class="refer-points-box">
        <div class="row">
            <div class="col-md-12">
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>You</th>
                        <th>Level-1</th>
                        <th>Level-2</th>
                        <th>Level-3</th>
                        <th>Level-4</th>
                        <th>Level-5</th>
                        <th>Level-6</th>
                        <th>Level-7</th>
                        <th>Level-8</th>
                        <th>Level-9</th>
                        <th>Level-10</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                    foreach ($table as $row) { ?>
                        <tr>
                            <th></th>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['parent_id'] ?>"><?php echo $row['parent_name'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_1'] ?>"><?php echo $row['child_name_1'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_2'] ?>"><?php echo $row['child_name_2'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_3'] ?>"><?php echo $row['child_name_3'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_4'] ?>"><?php echo $row['child_name_4'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_5'] ?>"><?php echo $row['child_name_5'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_6'] ?>"><?php echo $row['child_name_6'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_7'] ?>"><?php echo $row['child_name_7'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_8'] ?>"><?php echo $row['child_name_8'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_9'] ?>"><?php echo $row['child_name_9'] ?></a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>dashboard/tree/<?php echo $row['child_id_10'] ?>"><?php echo $row['child_name_10'] ?></a>
                            </td>
                        </tr>    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('/public/footer', null, true); ?>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pagingType": "full_numbers"
        });
    });
</script>
<script>
    var table = document.getElementsByTagName('table')[0],
        rows = table.getElementsByTagName('tr'),
        text = 'textContent' in document ? 'textContent' : 'innerText';
    console.log(text);
    for (var i = 1, len = rows.length; i < len; i++) {
        rows[i].children[0][text] = i + '' + rows[i].children[0][text];
    }
</script>
</body>
</html>