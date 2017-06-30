<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Orriz - Messages</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <script src="<?php echo base_url(); ?>public/js/common.js"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/error.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/post.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/wall.css"/>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<script type="text/javascript">
    /*jQuery(document).ready(function($) {
     //publish_sent();
     publish_inbox();
     });*/
    $(document).ready(function () {
        $("#the_inbox").click();
    });
    function publish_inbox() {
        $.ajax({
            url: '<?= site_url("messages/get_inbox") ?>',
            dataType: 'json',
        })
            .done(function (data) {
                $("#inbox_tab .email-holder").empty();
                $("#inbox_tab .email-holder").append(print_email(data));
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                //console.log("complete");
            });
    }

    function publish_sent() {
        $.ajax({
            url: '<?php echo site_url("messages/get_sentbox"); ?>',
            dataType: 'json',
        })
            .done(function (data) {
                $("#sentbox_tab .email-holder").empty();
                $("#sentbox_tab .email-holder").append(print_email(data));
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                //console.log("complete");
            });
    }

    function print_email(data) {
        var output = '';
        var bold = "";
        var user_id = <?php echo $this->session->userdata('user_id'); ?>;
        if (Object.keys(data).length > 0) {
            $.each(data, function (index, val) {
                var profileImage = '<?= base_url("public/images/no.png") ?>';
                if (val.image != "" && val.image != null) {
                    profileImage = '<?= base_url("public/images/thumb") ?>/' + val.image;
                }
                bold = "";
                if (val.is_read == 0 && user_id != val.sender_id) {
                    bold = "font-weight: 900;font-style: italic;";
                }
                output += '<div class="row inbox_rows"><div class="col-md-12">\
                                <div class="row"><div class="col-md-2">\
                                <input type="checkbox" class="checkbox_message"/>\
                                </div>\
                                <div class="col-md-2"><a href="' + val.member_url + '">\
                                <img class="image_resize" src="' + profileImage + '" />\
                                </a></div>\
                                <div class="col-md-3">\
                                <b>' + val.name + '</b>\
                                </div>\
                                <div class="col-md-3">\
                                <a href="#" style="' + bold + '" class="msg-subject" data-is-read="' + val.is_read + '" id="' + val.id + '">' + val.subject + '</a>\
                                <br>\
                                <p>' + val.message + '</p>\
                                </div>\
                                <div class="col-md-2">\
                                <a href="<?php echo site_url("messages/delete/"); ?>/' + val.id + '">Delete</a>\
                                </div>\
                                </div>\
                                </div>\
                            </div>\
                                <hr class="hr_margin">';
            });
        } else {
            output += '<div class="row inbox_rows"><div class="col-md-12">No Records Found</div></div>';
        }
        return output;
    }

    function publish_message(message_id) {
        $.ajax({
            url: '<?php echo site_url("messages/get_message"); ?>/' + message_id,
            dataType: 'json',
        })
            .done(function (data) {
                $("#inbox_tab .email-holder").empty();
                $("#inbox_tab .email-holder").append(print_message(data));
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                //console.log("complete");
            });
    }

    function print_message(data) {
        var output = "";
        var replies = "";
        if (Object.keys(data).length > 0) {
            $("#showReplyTap").click();
            $("#reply_tab").addClass('active in');
            $("#reply_message_id").val(data.message_id);
            $("#view_the_message").html(data.message_text);
            $("#message_subject").html(data.message_subject);
            $("#friend_name").html(data.friend_name);
            $.each(data.replies, function (index, val) {
                var image = '<?= base_url("public/images/thumb") ?>/' + val.image;
                if (!val.image) {
                    image = '<?= base_url("public/images/no.png") ?>';
                }
                replies += '<div class="media">\
                                      <div class="media-left">\
                                        <a href="#">\
                                          <img style="max-width: 100px" class="media-object" src="' + image + '" alt="...">\
                                        </a>\
                                      </div>\
                                      <div class="media-body"><br>\
                                        <h5 class="media-heading">' + val.reply_date + '</h5>\
                                        <h5 class="media-heading">' + val.reply_from + '</h5>\
                                        ' + val.reply_text + '\
                                      </div>\
                                    </div><hr>';
            });
            $("#replies").html(replies);
        } else {
            output += '<div class="row inbox_rows"><div class="col-md-12">No Records Found</div></div>';
        }
        return output;
    }
</script>
<div class="clearfix">
</div>
<div class="container">
    <div class="row" style="height: 500px;">
        <div class="col-md-12">
            <div class="posts-ads-container">
                <ul class="nav nav-tabs message_tabs" style="width: 96%">
                    <li class="active inbox-tab"><a class="one-tap" data-toggle="tab" id="the_inbox" href="#inbox_tab"
                                                    onclick="publish_inbox()">Conversations</a></li>
                    <li><a class="one-tap" data-toggle="tab" href="#compose_tab">Compose Message</a></li>
                    <li><a class="one-tap" id="thebulletintab" data-toggle="tab" href="#bulletin_tab">Bulletin</a></li>
                </ul>
                <div class="tab-content">
                    <div id="inbox_tab" class="tab-pane fade in active">
                        <div class="row inbox_header">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2"><input type="checkbox" class="checkbox_message"/></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">Friend</div>
                                    <div class="col-md-3">Subject</div>
                                    <div class="col-md-2">Action</div>
                                </div>
                            </div>
                        </div>
                        <hr class="hr_margin">
                        <div class="email-holder">

                        </div>
                    </div>
                    <?php /* ?>
                            <div id="sentbox_tab" class="tab-pane fade">
                                <div class="row inbox_header">
                                    <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2"><input type="checkbox" class="checkbox_message"/></div>

                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">To</div>

                                        <div class="col-md-3">Subject</div>

                                        <div class="col-md-2">Action</div>

                                    </div>
                                    </div>
                                </div>
                                <hr class="hr_margin">
                                <div class="email-holder">
                                    
                                </div>
                            </div>
                            <?php */ ?>
                    <div id="compose_tab" class="tab-pane fade">
                        <div style="color: #F8BB22"><?php echo $this->session->flashdata('message'); ?></div>
                        <form method="post" action="<?php echo base_url('messages/compose') ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">From:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="hidden" name="sender_id"
                                           value="<?php echo $this->session->userdata('user_id'); ?>"/>
                                    <div class="details-form-group">
                                        <?php echo isset($first_name) ? $first_name : '' . " "; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">To:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <select name="receiver_id" class="join-form-control">
                                            <?php foreach ($friends_list as $key => $value) { ?>
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['first_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">Subject:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <input type="text" name="subject" class="join-form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="details-form-group">
                                        <textarea name="message" class="ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row pull-right">
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <a href="<?php echo base_url() ?>messages/index"
                                           class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="bulletin_tab" class="tab-pane fade">
                        <div style="color: #F8BB22"><?php echo $this->session->flashdata('message'); ?></div>
                        <form id="bulletinForm" method="post" action="<?php echo base_url('messages/bulletin') ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">From:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="hidden" name="sender_id"
                                           value="<?php echo $this->session->userdata('user_id'); ?>"/>
                                    <div class="details-form-group">
                                        <?php echo isset($first_name) ? $first_name : '' . " "; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">To: </label>
                                </div>
                                <div class="col-md-10">
                                    <h5>ALL Friends</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">Subject:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <input type="text" name="subject" class="join-form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="details-form-group">
                                        <textarea name="message" class="ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row pull-right">
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <input type="submit" value="Submit" id="submitBulletin"
                                               class="btn btn-primary"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <a href="<?php echo base_url() ?>messages/index"
                                           class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="reply_tab" class="tab-pane fade">
                        <div style="color: #F8BB22"><?php echo $this->session->flashdata('message'); ?></div>
                        <form method="post" action="<?php echo base_url('messages/reply_to_message') ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">From:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="hidden" name="sender_id"
                                           value="<?php echo $this->session->userdata('user_id'); ?>"/>
                                    <input id="reply_message_id" type="hidden" name="message_id" value="">
                                    <div class="details-form-group">
                                        <?php echo isset($first_name) ? $first_name : '' . " "; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">To:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <span id="friend_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="step-label">Subject:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <span id="message_subject"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <br><br>
                                <div class="col-md-2">
                                    <label class="step-label">Message:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <div id="view_the_message"></div>
                                    </div>
                                </div>
                                <br><br>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="details-form-group">
                                        <textarea name="message" class="ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row pull-right">
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="details-form-group">
                                        <a href="<?php echo base_url() ?>messages" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <br>
                        <br>
                        <div style="padding-left:20px;">
                            <div class="row">
                                <div id="replies"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<div id="overlay-back">
</div>

<script type="text/javascript">
    var message_id;
    var counter;
    $(document).ajaxComplete(function () {
        //$("#thebulletintab").unbind();
        $('.msg-subject').unbind();
        $('.msg-subject').click(function (e) {
            e.preventDefault();
            message_id = $(this).attr('id');
            is_read = $(this).attr('data-is-read');
            if (is_read == 0) {
                $.ajax({
                    method: "POST",
                    url: '<?php echo site_url("messages/mark_as_read"); ?>',
                    data: {message_id: message_id}
                })
                    .done(function (data) {
                        if (data == 'ok') {
                            counter = $('#new_messages_counter').html();
                            counter = counter - 1;
                            if (counter <= 0) {
                                $('#new_messages_counter').hide();
                            } else {
                                $('#new_messages_counter').html(counter);
                            }
                        }
                    });
            }
            publish_message(message_id);
        });
    });
    function publish_back() {
        $('#the_inbox').click();
        $('#popup,#overlay-back').remove();
    }

    $(".one-tap").click(function () {
        $("#reply_tab").removeClass('active in');
    });

    //    $('.btn').click(function () {
    //        $('.active').removeClass('active');
    //    });

    //    $("#bulletin_tab").removeClass('active');

    $('#submitBulletin').click(function (e) {
        e.preventDefault();
        <?php if(isset($points)){
        if($points < 10){?>
        lessThan10Points();
        <?php }else{ ?>
        swal({
            title: 'Confirm',
            text: "10 points will be charged",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#30d674',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Send'
        }).then(function () {
            $('#bulletinForm').submit();
        });
        <?php } ?>
        <?php }else{ ?>
        lessThan10Points();
        <?php } ?>
    });

    function lessThan10Points() {
        swal({
            title: 'You have less than 10 points',
            text: "One bulletin costs 10 points",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#30d674',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Get more points'
        }).then(function () {
            window.location.href = '<?= base_url() ?>dashboard/wallet';
        });
    }
</script>
</body>
</html>