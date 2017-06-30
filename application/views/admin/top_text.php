<!DOCTYPE html>
<html>
<head>
    <title>Top Text</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
    <link href="<?= base_url('public/libraries/bootstrap3-editable-1.5.1/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css') ?>" rel="stylesheet" type="text/css" />
    <script src="<?= base_url('public/libraries/bootstrap3-editable-1.5.1/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js') ?>"></script>
    <script src="<?= base_url('public/libraries/bootstrap3-editable-1.5.1/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.min.js') ?>"></script>
    <script src="<?= base_url('public/libraries/bootstrap3-editable-1.5.1/inputs-ext/wysihtml5/wysihtml5.js') ?>"></script>

</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <h1 style="text-align: center; margin-top: 50px;">Set Top Text</h1>
    <div style="margin-top: 200px;">
        <?php foreach ($texts as $key => $text) { ?>
            <div class="row" style="border: solid 1px silver; display: flex;">
                <div class="col-sm-4" style="border-right: solid 1px silver; align-items: stretch;"><h3 style="text-transform: capitalize; margin-top: 0;"><?= $key ?></h3></div>
                <div class="my-editable-element col-sm-8" data-type="wysihtml5"
                     data-url="<?= base_url('admin/set_top_text_ajax') ?>"
                     data-pk="<?= $key ?>" style="border-bottom: none;">
                    <?= $text ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?= $this->load->view('public/footer', null, true) ?>

<script>
    $(document).ready(function () {
        $('.my-editable-element').editable();
    });
</script>

</body>
</html>