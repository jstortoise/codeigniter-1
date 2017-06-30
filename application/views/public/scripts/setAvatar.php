<div class="modal fade" id="myModalForAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
		<i class="fa fa-times close_wall visible-xs" aria-hidden="true"></i>
            <div class="container" style="width: 100%;">
                <div class="row" style="height: 500px; padding: 20px;">
                    <div class="col-md-8">
                        <div><p>Use mouse to select area of your photo to crop</p></div>
                        <div id="bigAvatarImage"><img></div>
                    </div>
                    <div class="col-md-4">
                        <h3>Preview</h3>
                        <div id="previewAvatarImage"><img></div>
                        <div>
                            <div id="setAvatar" class="btn btn-default" style="margin-top: 30px;">Set avatar</div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var ias = null;
    var avatar = {};

    $('.make-avatar').click(function (e) {
        var self = $(e.currentTarget);
        var img = self.parents().eq(1).find('.photo-img').attr('src');
        setAvatarImages(img);
    });

    $('#set_avatar').click(function () {
        setAvatarImages($('#thumbnail').attr('src'));
    });

    function setAvatarImages(img) {
        $('#bigAvatarImage img').attr('src', img);
        ias = $('#bigAvatarImage img').imgAreaSelect({
            handles: true,
            instance: true,
            aspectRatio: '1:1',
            onSelectChange: preview
        });

        $('#previewAvatarImage img').attr('src', img);
        avatar.img = img.substring(img.lastIndexOf('/') + 1);
    }

    $('#myModalForAvatar').on('hidden.bs.modal', function () {
        $('#bigAvatarImage img').imgAreaSelect({
            remove: true
        });
    });

    $('#setAvatar').click(function () {
        $('#myModalForAvatar').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>members/set_avatar',
            data: {
                x1: avatar.x1,
                x2: avatar.x2,
                y1: avatar.y1,
                y2: avatar.y2,
                w: avatar.w,
                h: avatar.h,
                filename: avatar.img,
                upload_thumbnail: true,
                fromPhoto: true
            },
            success: function (data) {
                var IS_JSON = true;
                try {
                    data = $.parseJSON(data);
                }
                catch (err) {
                    IS_JSON = false;
                }
                if (IS_JSON && data.result == 'ok') {
                    var url = window.location.href;
                    if (url.indexOf('uploadimage') > -1) {
                        swal(
                            'Success',
                            'You avatar changed',
                            'success'
                        ).then(function () {
                            window.location.href = '<?= base_url('dashboard') ?>';
                        });
                    } else {
                        swal(
                            'Success',
                            'You avatar changed',
                            'success'
                        );
                    }
                } else {
                    swal(
                        'Error!',
                        'We can\'t change avatar now. Please try again later',
                        'error'
                    );
                }
            },
            error: function (data) {
                swal(
                    'Error!',
                    'We can\'t change avatar now. Please try again later',
                    'error'
                );
            }
        });
    });

    function preview(img, selection) {
        var scaleX = 150 / selection.width;
        var scaleY = 150 / selection.height;

        $('#previewAvatarImage img').css({
            width: Math.round(scaleX * img.width) + 'px',
            height: Math.round(scaleY * img.height) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });

        var x1 = Math.round((img.naturalWidth / img.width) * selection.x1);
        var y1 = Math.round((img.naturalHeight / img.height) * selection.y1);
        var x2 = Math.round(x1 + selection.width);
        var y2 = Math.round(y1 + selection.height);

        avatar.x1 = x1;
        avatar.x2 = x2;
        avatar.y1 = y1;
        avatar.y2 = y2;
        avatar.w = Math.round((img.naturalWidth / img.width) * selection.width);
        avatar.h = Math.round((img.naturalHeight / img.height) * selection.height);
    }
</script>