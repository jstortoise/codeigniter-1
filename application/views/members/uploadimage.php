<?php
error_reporting(E_ALL ^ E_NOTICE);
$upload_path = base_url() . "/public/images/photos/";
$thumb_width = "150";
$thumb_height = "150";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/cropimage.css"/>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link type="text/css" href="<?= base_url('public/css/imgareaselect-default.css') ?>" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.imgareaselect.js"></script>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true); ?>
<div class="container1">
    <div class="crop_box">
        <form class="uploadform" method="post" enctype="multipart/form-data" name="photo">
            <div class="crop_set_upload">
                <div class="pull-left"><input type="file" name="imagefile" id="imagefile" style="padding-left: 20px;"/>
                </div>
                <div class="crop_select_image pull-right"><input type="submit" value="Upload" class="upload_button"
                                                                 name="submitbtn" id="submitbtn"/></div>
            </div>
        </form>
        <div class="crop_set_preview">
            <div class="crop_preview_left">
                <div class="crop_preview_box_big" id='viewimage'>
                </div>
            </div>
            <div class="crop_preview_right">
                <div name="thumbnail">
                    <div class="crop_preview_submit">
                        <button type="button" class="btn bg-primary" id="set_avatar" data-toggle="modal"
                                data-target="#myModalForAvatar" disabled="disabled">Set as avatar
                        </button>
                    </div>
                    <div class="second-step-skip-button" style="margin-top: 214px;">
                        <span>or</span>
                        <a class="add-detail-skip" href="<?= base_url('dashboard') ?>"> Skip </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('/public/footer', null, true); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#submitbtn').click(function () {
            $("#viewimage").html('');
            $("#viewimage").html('<img src="<?php echo base_url(); ?>public/images/loading.gif" />');
            $(".uploadform").ajaxForm({
                url: '<?= base_url('images/upload_ajax') ?>',
                success: showResponse
            });
        });
    });
    function showResponse(responseText, statusText, xhr, $form) {
        $('#thumbviewimage').html('');
        $('#viewimage').html('');
        var IS_JSON = true;
        try {
            responseText = $.parseJSON(responseText);
        }
        catch (err) {
            IS_JSON = false;
        }
        if (IS_JSON) {
            if (responseText.result == 'ok') {
                $('#set_avatar').removeAttr('disabled');
                $('#thumbviewimage').html('<img src="<?php echo $upload_path; ?>' + responseText.image + '"   style="position: relative;" alt="Thumbnail Preview" />');
                $('#viewimage').html('<img class="preview" alt="" src="<?php echo $upload_path; ?>' + responseText.image + '"   id="thumbnail" />');
                $('#filename').val(responseText.image);
            } else {
                swal('', responseText.message, 'error');
            }
        } else
            swal('Server error', '', 'error');
    }
</script>

<?= $this->load->view('public/scripts/setAvatar', null, true) ?>

</body>
</html>