<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Browse</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/browse.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/error.css"/>
    <script src="<?= base_url('public/js/typeahead.min.js') ?>"></script>
    <script>
        $(document).ready(function () {
            $('input.typeahead').typeahead({
                name: 'typeahead',
                remote: '<?php echo base_url('dashboard/suggestions'); ?>?key=%QUERY',
                limit: 10
            });
        });
    </script>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('members/cover_picture_profile', null, true) ?>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-7">
            <div class="posts-ads-container">
                <div class="wall-posts">
                    <form class="form-wrapper cf" method="post" action="<?php echo base_url('dashboard/search'); ?>">
                        <div class="bs-example">
                            <?php
                            @$string1 = @$this->session->userdata('string');
                            $string = "";
                            if (!empty($string1)) {
                                $string = $string1;
                            }
                            ?>
                            <input type="text" value="<?php echo $string; ?>" name="typeahead"
                                   class="typeahead tt-query" autocomplete="off" spellcheck="false"
                                   placeholder="Enter First or Last Name">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                    <?php if (isset($messages)) {
                        echo $messages;
                    } ?>
                    <?php if (isset($result)) {
                        foreach ($result as $rows) { ?>
                            <div class="col-md-3">
                                <div class="browse_box">
                                    <div class="imgthumb img-responsive">
                                        <a href="<?= $rows['member_url'] ?>">
                                            <img src="<?php echo base_url(); ?>public/images/thumb/<?php if (($rows['image']) != null) echo $rows['image']; else echo "no.png"; ?>">
                                        </a>
                                    </div>
                                    <div>
                                        <div class="text-center" style="font-size: 12px;">
                                            <strong> <?php echo $rows['first_name'] . ' ' . $rows['last_name'] ?></strong>
                                        </div>
                                        <a id="<?php echo $rows['id']; ?>" href="javascript:void(0);"
                                           class="btn btn-info btn-xs btn_add_friend"><?php if ($rows['status'] == 2) {
                                                echo "friend";
                                            } elseif ($rows['status'] == 1) {
                                                if ($rows['friend_one'] != $this->session->userdata('user_id')) {
                                                    echo "Request received";
                                                } else
                                                    echo "Request sent";
                                            } elseif ($rows['status'] == 0 || $rows['status'] == null) {
                                                if ($rows['id'] != $this->session->userdata('user_id')) {
                                                    echo "Add friend";
                                                } else echo "me";
                                            } ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="sidebar-ads">
                <img src="<?php echo base_url(); ?>public/images/sidebar-ad.jpg" alt="Sidebar Ad"/>
            </div>
        </div>
    </div>
</div>
<br>
<?= $this->load->view('public/footer', null, true) ?>
<div id="overlay-back"></div>
<script>
    window.onload;
    {
        var a = 0;
        a =<?php if (!empty($message)) {
            echo 1;
        } else echo 0 ?>;
        if (a === 1) {
            $('#overlay-back').fadeIn(500, function () {
                $('#error').show();
            });
            $("#error_btn").on('click', function () {
                $('#error').hide();
                $('#overlay-back').fadeOut(500);
            });
        } else {
            $('#error').hide();
        }
        ;
    }
</script>
<script>
    addFriendsUrl = "<?php echo base_url('dashboard/sentrequest'); ?>";
    $(document).on('click', '.btn_add_friend', function () {
        var friend_id = $(this).attr("id");
        var class1 = this;
        // alert(friend_id);
        $.ajax({
            url: addFriendsUrl,
            cache: false,
            // dataType: 'json',
            data: {
                friend_id: friend_id,
            },
            type: 'POST',
            async: false,
            success: function (data) {
                if (data) {
                    $(class1).html("Request Sent");
                    $(class1).removeClass("btn_add_friend");
                }
            }
        });
    });
</script>
</body>
</html>
