<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Browse Friends</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/browse.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/friends.css"/>
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
<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="container">
    <div class="row">
        <div class="col-sm-10 col-md-offset-1">
            <form id="filterForm" class="form-inline browsefriendform"
                  action="<?= base_url('dashboard/browsefriends') ?>" method="post">
                <div class="form-group">
                    <label class="sr-only" for="inputEmail">City</label>
                    <input type="text" value="<?php echo !empty($search_keywords) ? $search_keywords['city'] : "" ?>"
                           class="form-control" name="city" id="City" placeholder="Search By City Name">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="inputEmail">Country</label>
                    <input type="text" class="form-control"
                           value="<?php echo !empty($search_keywords) ? $search_keywords['country'] : "" ?>"
                           name="country" id="Country" placeholder="Search By Country Name">
                </div>
                <div class="form-group res-form">
                    <label class="sr-only" for="inputEmail">Age</label>
                    <select class="age-selection" name="start_age">
                        <option value=""><?php echo "Age from" ?></option>
                        <?php for ($i = 18; $i <= 80; $i++) { ?>
                            <option
                                <?php if (isset($search_keywords['start_age']) && $search_keywords['start_age'] == $i){ ?>selected="selected" <?php } ?>
                                value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select> -
                    <select class="age-selection" name="end_age">
                        <option value=""><?php echo "Age to" ?></option>
                        <?php for ($i = 18; $i <= 80; $i++) { ?>
                            <option
                                <?php if (isset($search_keywords['end_age']) && $search_keywords['end_age'] == $i){ ?>selected="selected" <?php } ?>
                                value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group res-form">
                    <label class="sr-only" for="inputEmail">Gender</label>
                    <select name="gender">
                        <option value=""><?= "Gender" ?></option>
                        <option <?php if (isset($search_keywords['gender']) && $search_keywords['gender'] == "male") { ?> selected="selected" <?php } ?>
                                value="male">Male
                        </option>
                        <option <?php if (isset($search_keywords['gender']) && $search_keywords['gender'] == "female") { ?> selected="selected" <?php } ?>
                                value="female">Female
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <hr>
            <?php if (isset($messages1)) {
                echo $messages1;
            } ?>
            <?php $i = 5;
            if (!empty($users)) { ?>
                <div class="col-xs-12">
                <div class="row row-no-padding">
                    <?php foreach ($users as $rows) {
                        $time = strtotime($rows['last_activity_timestamp']);
                        $curtime = time();
                        $firstCol = $i % 5 == 0 ? 'col-md-offset-1' : '';
                        $i++;
                        $age = isset($rows['birthday']) ? (date('Y') - date('Y', strtotime($rows['birthday']))) : '';
                        $city = isset($rows['city']) ? ' ' . $rows['city'] : '';
                        $country = isset($rows['country']) ? ' ' . $rows['country'] : '';
                        $status = "statusdeactive";
                        if (($time - $curtime) > 1200 && $rows['is_login'] == 1) {
                            $status = "statusactive";
                        } ?>
                        <div class="col-md-2 col-xs-6 custom-col-md-2">
                            <div class="browse_box">
								<div class="t-img-wrap">
                                <div class="imgthumb img-responsive">
                                    <a href="<?= $rows['member_url'] ?>">
                                        <img src="<?php echo base_url(); ?>public/images/thumb/<?php if (($rows['image']) != null) echo $rows['image']; else echo "avatar-no-image.png"; ?>">
                                    </a>
                                </div>
								<div class="up-text">
                                <div class="<?php echo $status; ?>" title="Online Now" rel="online">Online</div>
                                    <div class="user-name-col">
									<p><?php echo $rows['first_name'] . ' ' . $rows['last_name'] ?></p>
									<p><?php echo $age; ?> Years</p>
									<p><?php echo $city . $country ?></p>
									</div>
                                </div>
                                </div>
								<div class="user-icon-row">
									<div class="user-name-icon">
										<a id="<?php echo $rows['id']; ?>" href="javascript:void(0);"
                                       class="btn_add_friend"><i class="fa fa-user-plus" aria-hidden="true" title="Add friend"></i></a>
									</div>
									<div class="user-name-message">
										<a href="javascript:void(0);" class="msg-system"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
									</div>
								</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                </div>
                <div class="row" style="margin-top: 10%;">
                    <div class="col-md-12 text-center"><?= $this->pagination->create_links() ?></div>
                </div>
            <?php } else { ?>
                <div class="form-message warning">
                    <p>No records found.</p>
                </div>
            <?php } ?>

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

    $(document).on('click', '.btn_add_friend', function () {
        var friend_id = $(this).attr("id");
        var class1 = this;
        $.ajax({
            url: "<?= base_url('dashboard/sentrequest') ?>",
            cache: false,
            // dataType: 'json',
            data: {
                friend_id: friend_id,
            },
            type: 'POST',
            async: false,
            success: function (data) {
                if (data) {
                    $(class1).html('<i class="fa fa-check-square-o" aria-hidden="true" title="Request sent"></i>');
                    $(class1).removeClass("btn_add_friend");
                }
            }
        });
    });

    $('.pagination a').click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var form = $('#filterForm');
        form.attr('action', href);
        form.submit();
    });

    $('.age-selection').on('change', function (e) {
        var self = $(this);
        var type = self.attr('name');
        var startAge = parseInt($('select[name=start_age] option:selected').text());
        var endAge = parseInt($('select[name=end_age] option:selected').text());
        if (startAge && endAge && (endAge - startAge) < 1) {
            if (type == 'start_age') {
                $('select[name=end_age]').prop('selectedIndex', 0);
            } else {
                $('select[name=start_age]').prop('selectedIndex', 0);
            }
        }
    });

</script>
</body>
</html>
