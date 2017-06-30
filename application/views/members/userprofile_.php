<!DOCTYPE html>
<html>
<head>
    <title>Orriz - User</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<div class="container">
    <div class="myprofile-box">
        <!-- Slider Code Start-->
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
                <div id="carousel-example-generic" class="carousel slide wallpaper_slider" data-ride="carousel"
                     data-interval="5000">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php
                        if ($users_data[0]['profile_wallpaper1'] != "" || $users_data[0]['profile_wallpaper2'] != "" || $users_data[0]['profile_wallpaper3'] != "") {
                            $active_slide = "";
                            $check_active = "";
                            for ($k = 1; $k <= 3; $k++) {
                                if ($users_data[0]['profile_wallpaper' . $k] == "") {
                                } else {
                                    if ($check_active == "") {
                                        $active_slide = "active";
                                        $check_active = "active";
                                    } else {
                                        $active_slide = "";
                                    }
                                }
                                if ($users_data[0]['profile_wallpaper' . $k] != "") {
                                    echo '<li data-target="#carousel-example-generic" data-slide-to="' . $k . '" class="' . $active_slide . '"></li>';
                                }
                            }
                        } else {
                            echo '<li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>';
                        }
                        ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <!--                        <div class="edit_slider_wallpaper"-->
                        <!--                             style="position: absolute;z-index: 999;padding-left: 10px;padding-top: 10px;font-weight: bold;cursor:pointer;">-->
                        <!--                            Edit WallPaper-->
                        <!--                        </div>-->
                        <?php
                        if ($users_data[0]['profile_wallpaper1'] != "" || $users_data[0]['profile_wallpaper2'] != "" || $users_data[0]['profile_wallpaper3'] != "") {
                            $active_slide = "";
                            $check_active = "";
                            for ($i = 1; $i <= 3; $i++) {
                                if ($users_data[0]['profile_wallpaper' . $i] == "") {
                                } else {
                                    if ($check_active == "") {
                                        $active_slide = "active";
                                        $check_active = "active";
                                    } else {
                                        $active_slide = "";
                                    }
                                }
                                if ($users_data[0]['profile_wallpaper' . $i] != "") {
                                    ?>
                                    <div class='item <?php echo $active_slide; ?>'>
                                        <img src='<?php echo base_url(); ?>public/images/slider/<?php echo $users_data[0]['profile_wallpaper' . $i]; ?>'
                                             style="height: 250px;width: 100%;">
                                        <div class='carousel-caption'>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        } else {
                            echo '<div class="item active">
										<img src="' . base_url() . 'public/images/slider/default.jpg" style="height: 250px;width: 100%;">
										<div class="carousel-caption">
										</div>
									</div>';
                        } ?>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Slider Code End-->
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4" style="margin-top: 25px;">
                    </div>
                    <?php $this->load->view('public/scripts/luv'); ?>
                    <div class="col-sm-8">
                        <div class="referral-content-container">
                            <div class="referral-number">
                                <!--                                <a href="-->
                                <?php //echo base_url() . $users_data[0]['profile_url']; ?><!--">-->
                                <img
                                        src="<?php echo base_url(); ?>public/images/photos/<?php if (!empty($users_data[0]['image'])) {
                                            echo $users_data[0]['image'];
                                        } else echo "no.png"; ?>" alt="..." class="img-thumbnail"
                                        style="width: 100%;">
                                <!--                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-8">
                        <div style="margin-bottom: 30px;">Luv Reaches: <span
                                    class="luv-points<?= $users_data[0]['id'] ?>"><?= $users_data[0]['luv_points'] ?></span>
                        </div>
                        <?php if ($me->id != $users_data[0]['id']) { ?>
                            <div style="z-index: 100; top: -40px; right: 50px; position: absolute;">
                                <div style="top: 25px; position: relative; left: 16px;"><p>Give Luv</p></div>
                                <div userId="<?= $users_data[0]['id'] ?>" class="heart heart-top">
                                    <img src="<?= base_url() ?>public/images/heart.png" title="Give Luv"
                                         style="max-width: 100%;">
                                    <div class="luv-give<?= $users_data[0]['id'] ?> success"
                                         style="position: absolute; color: #00CC00; top: 10px; width: 70px;">
                                        Luv given!
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <hr>
                        <ol class="breadcrumb">
                            <li><b>Photos</b></li>
                        </ol>
                    </div>
                    <div class="col-sm-12" style="margin-top: -10px;">
                        <a href="<?php echo $users_data[0]['member_url'] . '/gallery'; ?>">
                            View all photos
                        </a>
                    </div>
                    <?php if (isset($photos)) {
                        for ($i = 0; $i < count($photos); $i++) { ?>
                            <div class="col-sm-4 col-xs-6">
                                <div id="<?= $photos[$i]->id ?>" class="gallery-photo res_photo" style="float: left;">
                                    <a href="#" style="float: left;">
                                        <div class="pic">
                                            <div class="thumbnail_wrapper">
                                                <img class="photo-img"
                                                     src="<?= base_url() . "public/images/photos/" . $photos[$i]->photo ?>"
                                                     style="width: 100%;">
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <p class="photo-title-p"><?= $photos[$i]->title ? $photos[$i]->title : '' ?></p>
                                    </div>
                                    <div style="font-size: 10px; color: #7b8087; margin-left: 5px; min-height: 14px;">
                                        <span class="comments-count-for<? $photos[$i]->id ?>"><?= count($photos[$i]->comments) ? 'Comments: ' . count($photos[$i]->comments) : '' ?></span>
                                        <span class="likes-count-for<? $photos[$i]->id ?>"><?= count($photos[$i]->likes) ? '&nbsp;&nbsp;&nbsp; Likes: ' . count($photos[$i]->likes) : '' ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($i == 5) {
                                break;
                            }
                        }
                    } ?>
                    <form id="fakeForm" method="post" type="hidden"
                          action="<?php echo $users_data[0]['member_url'] . '/gallery'; ?>">
                        <input type="hidden" id="fakeFormPhotoId" name="fakeFormPhotoId" value=""/>
                    </form>
                    <script type="text/javascript">
                        $('.gallery-photo').click(function (e) {
                            e.preventDefault();
                            var self = $(e.currentTarget);
                            var photoId = self.attr('id');
                            $('#fakeFormPhotoId').val(photoId);
                            $('#fakeForm').submit();
                            $('#fakeForm').submit();
                        });
                    </script>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <hr>
                        <ol class="breadcrumb">
                            <li><b>Friends</b></li>
                        </ol>
                    </div>
                    <?php if (isset($friend_list)) {
                        foreach ($friend_list as $rows) {
                            $age = isset($rows['birthday']) ? (date('Y') - date('Y', strtotime($rows['birthday']))) : '';
                            $city = isset($rows['city']) ? ' ' . $rows['city'] : '';
                            $country = isset($rows['country']) ? ' ' . $rows['country'] : ''; ?>
                            <div class="col-sm-4 col-xs-6">
                                <div class="browse_box">
                                    <div class="t-img-wrap">
										<div class="imgthumb img-responsive">
											<a href="<?= $rows['member_url'] ?>">
												<img src="<?php echo base_url(); ?>public/images/thumb/<?php if (($rows['image']) != null) echo $rows['image']; else echo "no.png"; ?>">
											</a>
										</div>
										<div class="up-text">
											<div class="user-name-col">
												<p><?php echo $rows['first_name'] . ' ' . $rows['last_name'] ?></p>
												<p><?php echo $age; ?> Years</p>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="referral-content-container">
                    <div class="referral-number">
                        <h3><i class="fa fa-circle" aria-hidden="true"
                               style="color:green;font-size: 16px;margin-right: 5px;"></i><?php echo ucfirst($users_data[0]['first_name']) . ' ' . ucfirst($users_data[0]['last_name']); ?>
                        </h3>
                        <?php //print_r($users_data); ?>
                        <table style="width:100%;">
                            <!--                            <tr>-->
                            <!--                                <td>Profile Url</td>-->
                            <!--                                <td>:</td>-->
                            <!--                                <td class="profile_url">-->
                            <!--                                    --><?php
                            //
                            //                                    if ($users_data[0]['profile_url'] != "") {
                            //                                        echo '<a href="' . base_url() . 'user/' . $users_data[0]['profile_url'] . '">' . base_url() . 'user/' . $users_data[0]['profile_url'] . '</a>';
                            //                                    } else {
                            //                                        echo base_url() . 'user/<input type="text" id="profile_url"><input type="submit" value="save" id="set_profile_url" data-userid="' . $users_data[0]['id'] . '">';
                            //                                    }
                            //                                    ?>
                            <!--                                    <p class="text-danger check_profile_url" style="display:none;">Already Exist, Please-->
                            <!--                                        Try Another!!</p>-->
                            <!--                                </td>-->
                            <!--                            </tr>-->
                            <tr>
                                <td>Last Active:</td>
                                <td>:</td>
                                <td><?php if ($users_data[0]['active'] == "1") {
                                        echo 'Online Now!';
                                    } else {
                                        echo $users_data[0]['last_seen'];
                                    } ?></td>
                            </tr>
                            <tr>
                                <td>Profile Views</td>
                                <td>:</td>
                                <td>0 times</td>
                            </tr>
                            <tr>
                                <td>Member Since</td>
                                <td>:</td>
                                <td><?php echo date('F d, Y', $users_data[0]['created_on']); ?></td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['gender']; ?></td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['city'] . ', ' . $users_data[0]['country']; ?></td>
                            </tr>
                            <?php
                            $dob = $users_data[0]['birthday'];
                            $age = (date('Y') - date('Y', strtotime($dob)));
                            ?>
                            <tr>
                                <td>Age</td>
                                <td>:</td>
                                <td><?= $age ? $age . ' Years' : '' ?></td>
                            </tr>
                            <tr>
                                <td>Relationship Status</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['relationship_status']; ?></td>
                            </tr>
                            <tr>
                                <td>Interested In</td>
                                <td>:</td>
                                <td>
                                    <?php $interested_in = "";
                                    if ($users_data[0]['intrest_in_dating'] == 1) {
                                        $interested_in .= "Dating";
                                    }
                                    if ($users_data[0]['intrest_in_friends'] == 1) {
                                        if ($interested_in != "") {
                                            $interested_in .= ",Friends";
                                        } else {
                                            $interested_in .= "Friends";
                                        }
                                    }
                                    if ($users_data[0]['intrest_in_serious_relationship'] == 1) {
                                        if ($interested_in != "") {
                                            $interested_in .= ",Serious Relationship";
                                        } else {
                                            $interested_in .= "Serious Relationship";
                                        }
                                    }
                                    if ($users_data[0]['intrest_in_networking'] == 1) {
                                        if ($interested_in != "") {
                                            $interested_in .= ",Networking";
                                        } else {
                                            $interested_in .= "Networking";
                                        }
                                    }
                                    echo $interested_in;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Religion</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['religion']; ?></td>
                            </tr>
                            <tr>
                                <td>School</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['school']; ?></td>
                            </tr>
                            <tr>
                                <td>College</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['college']; ?></td>
                            </tr>
                            <tr>
                                <td>University</td>
                                <td>:</td>
                                <td><?php echo $users_data[0]['university']; ?></td>
                            </tr>
                        </table>
                        <br>
                        <ol class="breadcrumb">
                            <li><b>About me</b></li>
                        </ol>
                        <table style="width:100%;">
                            <tr>
                                <td>Music</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
									<?= $users_data[0]['music']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['music']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="music">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Movies</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['movies']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['movies']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="movies">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>TV</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['tv']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['tv']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="tv">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Books</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['books']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['books']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="books">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sports</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['sports']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['sports']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="sports">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Interests</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['interests']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['interests']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="interests">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Dreams</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
									<?= $users_data[0]['dreams']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['dreams']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="dreams">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Best Features</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['best_feature']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['best_feature']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>"
                                               data-col="best_feature">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>About Me</td>
                                <td>:</td>
                                <td><span class="sanjay_div">
										<?= $users_data[0]['about_me']; ?></span>
                                    <div class="edit_div" style="display:none;">
                                        <textarea style="width: 100%;"
                                                  class="edit_div_data"><?php echo $users_data[0]['about_me']; ?></textarea>
                                        <br/>
                                        <input type="submit" value="Save" class="save_edit_div"
                                               data-userid="<?php echo $users_data[0]['id']; ?>" data-col="about_me">
                                        <input type="submit" value="Close" class="close_edit_div">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('public/footer', null, true) ?>
<div id="myLuvInformation" points="<?= $me->points ?>" freeLuv="<?= $me->free_luv ?>" style="display: none;"></div>
<script>
    $('.open_edit_div').click(function () {
        $(this).siblings('.edit_div').toggle();
        $(this).css({'display': 'none'});
    });
    $('.close_edit_div').click(function () {
        $(this).parents('.edit_div').toggle();
        $(this).parents('.edit_div').siblings('.open_edit_div').toggle();
    });
    $('.save_edit_div').click(function () {
        var user_id = $(this).data('userid');
        var value = $(this).siblings('.edit_div_data').val();
        $(this).addClass('sanjaybhai');
        var col = $(this).data('col');
        var data = {
            "user_id": user_id,
            "col": col,
            "value": value
        };
        $.ajax(
            {
                type: "post",
                url: "<?php echo base_url('dashboard/edit_user_data'); ?>",//URL changed
                data: data,
                success: function (response) {
                    if (response == 1) {
                        $('.sanjaybhai').parents('.edit_div').siblings('.sanjay_div').text(value);
                        //$(this).parents('.edit_div').css({'display':'none'});
                        //$(this).parents('.edit_div').siblings('.open_edit_div').css({'display':'block'});
                        $('.sanjaybhai').siblings('.close_edit_div').trigger('click');
                        $('.sanjaybhai').removeClass('sanjaybhai');
                    }
                }
            });
    });
    $('#set_profile_url').click(function () {
        var user_id = $(this).data('userid');
        var profile_url = $('#profile_url').val();
        var data = {
            "user_id": user_id,
            "profile_url": profile_url
        };
        $.ajax(
            {
                type: "post",
                url: "<?php echo base_url('dashboard/set_profile_url'); ?>",//URL changed
                data: data,
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        $('.check_profile_url').css({'display': 'none'});
                        $('#profile_url').hide();
                        $('#set_profile_url').hide();
                        $('.profile_url').html('<a href="<?php echo base_url(); ?>' + profile_url + '"><?php echo base_url(); ?>' + profile_url + '</a>');
                    }
                    else {
                        $('.check_profile_url').css({'display': 'block'});
                    }
                }
            });
    });
    $('.edit_slider_wallpaper').click(function () {
        //alert('Hi Sanjay');
        $('#open_popup_wallpaper').trigger('click');
    });
    //Submit Form of WallPapers
    $('#wallpaper_form').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('dashboard/edit_profile_slider'); ?>',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("success");
                console.log(response);
                response = jQuery.parseJSON(response);
                console.log(response);
                //console.log(response.file1);
                if (response.file1 != "") {
                    $('.loading_thumb1').css({'display': 'none;'});
                    $('.profile_wallpaper1_thumb').attr('src', 'http://orriz.com/public/images/slider/' + response.file1 + '');
                }
                if (response.file2 != "") {
                    $('.loading_thumb2').css({'display': 'none;'});
                    $('.profile_wallpaper2_thumb').attr('src', 'http://orriz.com/public/images/slider/' + response.file2 + '');
                }
                if (response.file3 != "") {
                    $('.loading_thumb3').css({'display': 'none;'});
                    $('.profile_wallpaper3_thumb').attr('src', 'http://orriz.com/public/images/slider/' + response.file3 + '');
                }
            },
            error: function (data) {
                console.log("error");
                console.log(response);
            }
        });
    }));
    $('.profile_slider_image').change(function () {
        var id = $(this).data('id');
        $('.loading_thumb' + id).css({'display': 'inline-block;'});
        $("#wallpaper_form").submit();
    });
    $('.user_save_wallpapers').click(function () {
        //Save WallPapers DATA
        window.location.reload();
    });
    $('.delete_slider_image').click(function () {
        var col = $(this).data('col');
        var user_id = $(this).data('userid');
        var value = "";
        var data = {
            "user_id": user_id,
            "col": col,
            "value": value
        };
        $.ajax(
            {
                type: "post",
                url: "<?php echo base_url('dashboard/edit_user_data'); ?>",//URL changed
                data: data,
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        $(this).siblings('.' + col + '_thumb').attr('src', 'http://orriz.com/public/images/slider/noimage.jpg');
                    }
                    else {
                    }
                }
            });
    });
</script>
</body>
</html>