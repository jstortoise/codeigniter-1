<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Add Photo</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/loading_animation.css"/>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="container">
    <div class="titleBox row">
        <h2>Photos</h2>
    </div>
    <div class="row">
        <ul class="nav nav-tabs" style="border-bottom: 1px solid #ddd;">
            <li id="tab-add"><a href="<?= base_url() ?>images/gallery" title="My Photos"
                                style="background: none; color: #428bca">My Photos</a></li>
            <li id="tab-gallery" class="active"><a href="<?= base_url() ?>images/add_photos" title="Add Photos">Add
                    Photos</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="blue_box_content">
            <div id="album_uploader" class="yui-content">
                <div id="my_files">
                    <div id="upload_error"></div>
                    <?= form_open('images/upload_ajax', ['name' => 'uploadfile',
                        'id' => 'uploadfile',
                        'enctype' => "multipart/form-data",
                        'method' => "POST",
                        'style' => 'padding-top: 20px;']) ?>
                    <?= form_input(['name' => 'upload_photo', 'id' => 'upload_photo', 'class' => 'btn btn-default', 'value' => 'Choose Photo', 'type' => 'file']) ?>
                    <span id="upload_text">Max File Size: 2 MB</span>
                    <?= form_close() ?>
                    <div id="my_files_feedback" class="feedback success hide_me" style="opacity: 1; display: none;">
                    </div>
                </div>
                <div id="image_url" style="opacity: 1; display: none;">
                    <div id="url_error"></div>
                    <form name="uploadurl" id="uploadurl" method="POST" upload_field="upload_photo"
                          submit_button="submit_btn" preview_div=" preview_div=" upload_photo_div
                    ""="">
                    <input type="hidden" name="csrfname" value="CSRF_url_photo_upload">
                    <input type="hidden" name="csrftoken"
                           value="37f47253e903c3d5cad2de96426ea8fc7545173e3bc3fecc788cd357c204fc04a086bea79a339ddf4793d61556bd0ffb58f4673c1a7ad8b3a5db4aa422901b73">
                    <input type="text" name="upload_photo" value="" id="url_input" class="text"
                           placeholder="Paste an image URL (like http://www.tagged.com/greg.jpg)">
                    <input type="hidden" name="size" value="">
                    <input type="hidden" name="imageType" value="P">
                    <input type="submit" name="submit_btn" value="Add Photo">
                    </form>
                    <div id="url_feedback"></div>
                </div>
                <div><p id="uploadMessage" style="display: none; width: 300px;"></p></div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<div id="loadingAnimationModal">
    <div class="windows8 loading-animation">
        <div class="wBall" id="wBall_1">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_2">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_3">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_4">
            <div class="wInnerBall"></div>
        </div>
        <div class="wBall" id="wBall_5">
            <div class="wInnerBall"></div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#upload_photo").change(function () {
        $('#loadingAnimationModal').modal({backdrop: 'static', keyboard: false});
        var form = $('#uploadfile');
        var formData = new FormData(form);
        var file_data = $('#upload_photo').prop('files')[0];
        formData.append('imagefile', file_data);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var IS_JSON = true;
                try {
                    data = $.parseJSON(data);
                }
                catch (err) {
                    IS_JSON = false;
                }
                if (IS_JSON) {
                    $('#uploadMessage').attr('class', '');
                    var filename = $("#upload_photo").val().replace(/C:\\fakepath\\/i, '');
                    if (IS_JSON && data.result == 'ok') {
                        $('#uploadMessage').addClass('bg-success').html('Photo ' + filename + ' was uploaded successfully').fadeIn();
                        window.location.href = '<?=base_url()?>images/gallery';
                    }
                    else if (IS_JSON) {
                        $('#uploadMessage').addClass('bg-danger').html(data.message).fadeIn();
                    }
                    else {
                        swal('Server error', '', 'error');
                    }
                } else {
                    swal('Server error', '', 'error');
                }
                $('#loadingAnimationModal').modal('hide');
                $("#upload_photo").val('');

            },
            error: function (data) {
                var IS_JSON = true;
                try {
                    data = $.parseJSON(data);
                }
                catch (err) {
                    IS_JSON = false;
                }
                $('#uploadMessage').attr('class', '');
                $('#loadingAnimationModal').modal('hide');
                if (IS_JSON) {
                    $('#uploadMessage').addClass('bg-danger').html(data.message).fadeIn();
                }
                else {
                    swal('Server error', '', 'error');
                }
            }
        });

    });

    $('#uploadMessage').click(function () {
        $(this).fadeOut();
    });

</script>
</body>
</html>