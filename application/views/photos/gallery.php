<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Photos</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link type="text/css" href="<?= base_url('public/css/imgareaselect-default.css') ?>" rel="stylesheet"/>
    <script type="text/javascript" src="<?= base_url('public/js/jquery.imgareaselect.js') ?>"></script>
</head>
<body>
<?php echo $this->load->view('members/dashboard_top', null, true);
$path = base_url() . "public/images/photos/"; ?>
<div class="clearfix"></div>

<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="container">
    <div class="titleBox row">
        <h2><?= $userGallery ? '<a href="' . $user->member_url . '">' . $user->first_name . ' ' . $user->last_name . "'s </a>" : '' ?>
            Photos</h2>
    </div>
    <?php if (!$userGallery) { ?>
        <ul class="nav nav-tabs" style="border-bottom: 1px solid #ddd;">
            <li id="tab-add" class="active"><a href="<?= base_url() ?>images/gallery" title="My Photos">My Photos</a>
            </li>
            <li id="tab-gallery"><a href="<?= base_url() ?>images/add_photos" title="Add Photos"
                                    style="background: none; color: #428bca">Add Photos</a></li>
        </ul>
    <?php } ?>

    <div class="row">
        <?php foreach ($photos as $photo) {
            $isAvatar = false;
            if (!$userGallery && $photo->photo == $me->image) {
                $isAvatar = true;
            } ?>
            <div id="<?= $photo->id ?>" class="gallery-photo <?= $isAvatar ? ' avatar' : '' ?>" style="float: left;">

                <a href="javascript:void(0)" style="float: left;">
                    <div class="pic" data-toggle="modal" data-target="#myModal">
                        <div class="thumbnail_wrapper">
                            <img class="photo-img"
                                 src="<?= $path . $photo->photo ?>" style="width: 100%;">
                        </div>
                    </div>
                </a>

                <?php if (!$userGallery) { ?>
                    <div class="controls-photo">
                        <i class="fa fa-plus fa-2x <?= $isAvatar ? '' : 'make-avatar' ?>" title="Make avatar"
                           data-toggle="modal"
                           data-target="<?= $isAvatar ? '' : '#myModalForAvatar' ?>"
                           style="margin-right: 5px; display: none; <?= $isAvatar ? 'opacity: 0;' : '' ?>"></i>
                        <i class="fa fa-close fa-2x delete-photo" aria-hidden="true" title="Delete photo"
                           style="display: none;"></i>
                    </div>

                    <div class="controls-edit">
                        <i class="fa fa-floppy-o save-title" title="Save title"
                           style="margin-right: 5px; display: none;"></i>
                        <i class="fa fa-undo cancel-edit" aria-hidden="true" title="Cancel"
                           style="display: none;"></i>
                    </div>
                <?php } ?>

                <div style="position: absolute; top: 160px;">
                    <?php if ($userGallery) { ?>
                        <p class="photo-title-p"><?= $photo->title ? $photo->title : '' ?></p>

                    <?php } else { ?>
                        <textarea class="photo-title-textarea" placeholder="Title"
                                  maxlength="250"><?= $photo->title ? $photo->title : '' ?></textarea>
                    <?php } ?>
                </div>
                <div style="font-size: 10px; color: #7b8087; margin-left: 5px; position: absolute; top: 200px;">
                    <span count="<?= count($photo->comments) ?>"
                          class="comments-count-for<?= $photo->id ?>"><?= count($photo->comments) ? 'Comments: ' . count($photo->comments) : '' ?></span>
                    <span class="likes-count-for<?= $photo->id ?>"><?= count($photo->likes) ? '&nbsp;&nbsp;&nbsp; Likes: ' . count($photo->likes) : '' ?></span>
                </div>

            </div>
        <?php }
        if (!count($photos) && !$userGallery) { ?>
            <h4 style="text-align: center; margin-top: 60px; position: relative;">You do not have any photo in gallery,
                please click on <a href="<?= base_url() ?>images/add_photos">Add
                    Photos</a> to upload your photo</h4>
        <?php }
        if (!count($photos) && $userGallery) { ?>
            <h4 style="text-align: center; margin-top: 60px; position: relative;">No photos</h4>
        <?php } ?>

    </div>
</div>

<?= $this->load->view('public/footer', null, true) ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
		<i class="fa fa-times close_wall visible-xs" aria-hidden="true"></i>
            <div class="row">
                <div class="col-md-8">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height:600px">

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $data['photos']=$photos;
                            $data['members']=$members;
                            $data['path']=$path;
                            $this->load->view('photos/carousel', $data);?>
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="modal-body inline">

                        <div class="row" id="photoData2">

                        </div>

                        <hr/>
                        <div id="photoData" class="row" style="height: 340px; overflow: auto; margin-bottom: 10px;">


                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <textarea rows="3" placeholder="Comment" type="text"
                                      class="form-control photo_comment_textarea" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <span class="text-mute" style="margin-top: 15px;">Please wrtie your opinion.</span>
                        <button class="submit-comment btn btn-sm btn-success pull-right" style="margin-top: 20px;">
                            Comment
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('public/scripts/setAvatar', null, true) ?>

<script type="text/javascript">
    <?php if ($openPhotoId) {
        echo("$(document).ready(function () {
        $('.class$openPhotoId').addClass('active');
        changePhotoDescription();
        $('#myModal').modal('show');
        });");
    }?>

    $('#myCarousel').carousel({interval: false});

    $('.gallery-photo').on('mouseenter', function (e) {
        if (!$(e.target).hasClass('controls-photo')) {
            var self = $(e.currentTarget);
            var fa = self.find('.controls-photo .fa');
            if (!fa.is(':visible')) {
                fa.fadeIn(100);
            }
        }
    });
    $('.gallery-photo').on('mouseleave', function (e) {
        var self = $(e.currentTarget);
        self.find('.controls-photo .fa').fadeOut(50);
    });

    var oldTitle = '';
    var newTitle = '';
    $('.photo-title-textarea').on('focusin', function (e) {
        var self = $(e.currentTarget);
        oldTitle = self.val();
        var fa = self.parents().eq(1).find('.controls-edit .fa');
        fa.fadeIn(100);
    })
    $('.photo-title-textarea').on('focusout', function (e) {
        var self = $(e.currentTarget);
        if (self.val() != oldTitle) {
            newTitle = self.val().trim();
        }
        self.val(oldTitle);
        var fa = self.parents().eq(1).find('.controls-edit .fa');
        fa.fadeOut(100);
    })

    $('.cancel-edit').click(function (e) {
        var self = $(e.currentTarget);
        var textarea = self.parents().eq(1).find('.photo-title-textarea');
        textarea.val(oldTitle);
    });

    $('.save-title').click(function (e) {
        var self = $(e.currentTarget);
        var textarea = self.parents().eq(1).find('.photo-title-textarea');
        var title = textarea.val().trim();
        photoId = self.parents().eq(1).attr('id');
        if (title != newTitle) {
            title = newTitle;
            textarea.val(title);
        }
        $('.class' + photoId + ' .hidden-info .photo-title-slider').html(title);
        var data = {
            photoId: photoId,
            title: title
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>images/set_title_ajax',
            data: data,
            success: function (data) {
            },
            error: function (data) {
            }
        });
    });

    $('.delete-photo').click(function (e) {
        var self = $(e.currentTarget);
        var photoId = self.parents().eq(1).attr('id');

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            self.parents().eq(1).remove();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>images/delete_photo_ajax',
                data: {photoId: photoId},
                success: function (data) {
                },
                error: function (data) {
                }
            });
        })
    });

    $('#myModal').on('hidden.bs.modal', function () {
        $('.carousel-inner .active').removeClass('active');
    });


    $('a .pic').click(function (e) {
        var self = $(e.currentTarget);
        var photoId = self.parents().eq(1).attr('id');
        $('.class' + photoId).addClass('active');
        changePhotoDescription();
    });


</script>

<?php $this->load->view('public/scripts/gallery', ['me'=>$me]); ?>

</body>
</html>