<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <h4>Prices</h4>
    <table cellpadding="0" cellspacing="0" border="0" class="display dataTable" id="example">
        <thead>
        <tr>
            <th width="20%">Option</th>
            <th width="20%">Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($options as $option) { ?>
            <tr id="<?php echo $option['id']; ?>">
                <td><?php echo $option['key']; ?></td>
                <td><span class="price-to-update"><?php echo $option['value']; ?></span><input
                            value="<?php echo $option['value']; ?>" class="price-to-update-field hide form-control"
                            type="text"></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <th width="20%">Option</th>
            <th width="25%">Value</th>
        </tr>
        </tfoot>
    </table>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<script>
    $('.price-to-update').click(function () {
        current = $(this);
        current.addClass('hide');
        current.next().removeClass('hide');
    });

    var new_price;
    var id;
    $('.price-to-update-field').keypress(function (e) {
        current = $(this);
        id = current.parent().parent().attr('id');
        new_price = current.val();
        if (new_price == '') {
            new_price = '0';
        }
        if (e.which == 13) {
            $.ajax({
                method: "POST",
                data: {id: id, price: new_price},
                url: "<?php echo base_url('admin/update_price'); ?>"
            }).done(function (data) {
                if (data == 'success') {
                    current.addClass('hide');
                    current.prev().html(new_price);
                    current.prev().removeClass('hide');
                } else {
                    alert(data);
                }
            });
        }
    });
    ;
</script>
</body>
</html>