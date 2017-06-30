<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Profile</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/friends.css"/>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<div class="container">
    <a id="open_popup_wallpaper" data-toggle="modal" data-target="#WallpapersModal"
       style="font-weight:600!important;text-transform:uppercase;color:white;display:none;">Wallpapers</a>
    <div id="WallpapersModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">WallPapers</h4>
                </div>
                <div class="modal-body" style="">
                    <form method="post" enctype="multipart/form-data" id="wallpaper_form">
                        <?php
                        for ($m = 1; $m <= 3; $m++) {
                            echo '<div class="field" style="margin-bottom: 20px;">
								<span class="field_left" style="display:inline-block;width:25%;font-size:22px;">Image ' . $m . '</span>
								<span class="field_right" style=""><input type="file" class="profile_slider_image" name="profile_wallpaper' . $m . '" id="profile_wallpaper' . $m . '" data-col="profile_wallpaper' . $m . '" data-id="' . $m . '" data-userid="' . $users_data[0]['id'] . '" style="display: inline-block;"><i class="fa fa-spinner fa-spin loading_thumb' . $m . '" style="font-size:24px;display:none;"></i>';
                            if ($users_data[0]['profile_wallpaper' . $m] != "") {
                                echo '<img class="profile_wallpaper' . $m . '_thumb" src="' . base_url() . 'public/images/slider/' . $users_data[0]['profile_wallpaper' . $m] . '" style="width:100px;" />
									<span class="delete_slider_image" data-userid="' . $users_data[0]['id'] . '" data-col="profile_wallpaper' . $m . '" style="margin-left: 10px;background: red;border-radius: 10px;font-size: 18px;padding: 0px 5px;color: #fff;cursor: pointer;">X</span></span>';
                            } else {
                                echo '<img class="profile_wallpaper' . $m . '_thumb" src="' . base_url() . 'public/images/slider/noimage.jpg" style="width:100px;" />';
                            }
                            echo '</div>';
                        }
                        ?>
                        <div class="field" style="margin-top: 20px;">
                            <span class="field_left" style="display:inline-block;width:45%;text-align: center;"><input
                                        type="button" class="" id="close_schedule_popup" data-dismiss="modal"
                                        style="font-size: 20px;padding: 10px;background: lightblue;"
                                        value="Cancel"/></span>
                            <span class="field_right" style="display:inline-block;width:45%;text-align: center;"><input
                                        type="button" class="user_save_wallpapers" id="user_save_wallpapers"
                                        data-userid="<?php echo $users_data[0]['id']; ?>"
                                        style="font-size: 20px;padding: 10px 30px;;background: lightblue;"
                                        value="Save"/></span>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo $users_data[0]['id']; ?>">
                    </form>
                    <!--</div>
                <!--</div><!--.col-ms-12--->
                </div>
                <!--.modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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
                        <div class="edit_slider_wallpaper"
                             style="position: absolute;z-index: 999;padding-left: 10px;padding-top: 10px;font-weight: bold;cursor:pointer;">
                            Edit WallPaper
                        </div>
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
                                        <img
                                                src='<?php echo base_url(); ?>public/images/slider/<?php echo $users_data[0]['profile_wallpaper' . $i]; ?>'
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
                        }
                        ?>
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
                    <div class="col-sm-6">
                        <div class="referral-content-container">
                            <div class="referral-number">
                                <ul class="list-group">
                                    <li class="list-group-item"><a href="<?= base_url() ?>members/edit_profile">Edit
                                            Profile</a></li>
                                    <li class="list-group-item"><a href="<?= base_url() ?>images/gallery">Edit
                                            DP</a></li>
                                    <li class="list-group-item"><a class="edit_slider_wallpaper"
                                                                   style="cursor:pointer;">Edit
                                            Slider</a></li>
                                    <!--<li class="list-group-item"><a href="#">Add Friends</a> </li>
                                    <li class="list-group-item"><a href="#">Send Message</a> </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="referral-content-container">
                            <div class="referral-number">
                                <a href="<?php echo base_url() . $users_data[0]['profile_url']; ?>">
                                    <img
                                            src="<?php echo base_url(); ?>public/images/photos/<?php if (!empty($users_data[0]['image'])) {
                                                echo $users_data[0]['image'];
                                            } else echo "no.png"; ?>" alt="..." class="img-thumbnail"
                                            style="width: 100%;">
                                </a>
                            </div>
                        </div>
                        <div>Luv Reaches: <?= $users_data[0]['luv_points'] ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <hr>
                        <ol class="breadcrumb">
                            <li><b>Photos</b></li>
                        </ol>
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
                    <form id="fakeForm" method="post" type="hidden" action="<?= base_url() ?>images/gallery">
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
                            <li><b>My friends</b></li>
                        </ol>
                    </div>
                    <?php if (isset($friend_list)) { ?>
					<div class="col-xs-12">
                    <div class="row row-no-padding">
					<?php foreach ($friend_list as $rows) {
                            $age = isset($rows['birthday']) ? (date('Y') - date('Y', strtotime($rows['birthday']))) : '';
                            $city = isset($rows['city']) ? ' ' . $rows['city'] : '';
                            $country = isset($rows['country']) ? ' ' . $rows['country'] : ''; ?>
                            <div class="col-sm-4 col-xs-6">
                                <div class="browse_box">
                                    <div class="t-img-wrap">
										<div class="imgthumb img-responsive">
											<a href="<?= $rows['member_url'] ?>">
												<img src="<?php echo base_url(); ?>public/images/thumb/<?php if (($rows['image']) != null) echo $rows['image']; else echo "avatar-no-image.png"; ?>">
											</a>
										</div>
                                        <div class="up-text">
											<div class="user-name-col">
												<p><?php echo $rows['first_name'] . ' ' . $rows['last_name'] ?></p>
												<p><?php echo $age; ?> Years</p>
												<p><?php echo $city . $country ?></p>
											</div>
                                        </div>
									</div>	
									<div class="user-icon-row">	
										<div class="user-name-icon">
											<a class="btn btn-info btn-xs" role="button"
                                           href="<?php if ($rows['status'] == 2) {
                                               echo base_url('dashboard/unfriend') . '?friend_id=' . $rows['id'];;
                                           } ?>"><i class="fa fa-user-times" aria-hidden="true" title="Unfriend"></i></a>
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
                    <?php } ?>
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
                            <tr>
                                <td>Profile Url</td>
                                <td>:</td>
                                <td class="profile_url">
                                    <?php
                                    if ($users_data[0]['profile_url'] != "") {
                                        echo '<a href="' . base_url() . $users_data[0]['profile_url'] . '">' . base_url() . $users_data[0]['profile_url'] . '</a>';
                                    } else {
                                        echo base_url() . '<input type="text" id="profile_url"><input type="submit" value="save" id="set_profile_url" data-userid="' . $users_data[0]['id'] . '">';
                                    }
                                    ?>
                                    <p class="text-danger check_profile_url" style="display:none;">Already Exist, Please
                                        Try Another!!</p>
                                </td>
                            </tr>
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
									<?php
                                    echo $users_data[0]['music']; ?></span><?php
                                    if ($users_data[0]['music'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your favorite music types and artists...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['movies']; ?></span><?php
                                    if ($users_data[0]['movies'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your favorite movies and actors...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['tv']; ?></span><?php
                                    if ($users_data[0]['tv'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your favorite TV shows...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['books']; ?></span><?php
                                    if ($users_data[0]['books'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your favorite books and authors...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['sports']; ?></span><?php
                                    if ($users_data[0]['sports'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your favorite sports, teams, and athletes...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['interests']; ?></span><?php
                                    if ($users_data[0]['interests'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Add your interests...</a>	';
                                    }
                                    ?>
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
									<?php
                                    echo $users_data[0]['dreams']; ?></span><?php
                                    if ($users_data[0]['dreams'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Share your dreams...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['best_feature']; ?></span><?php
                                    if ($users_data[0]['best_feature'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Don`t be shy...</a>	';
                                    }
                                    ?>
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
										<?php
                                        echo $users_data[0]['about_me']; ?></span><?php
                                    if ($users_data[0]['about_me'] != "") {
                                        echo '<a class="open_edit_div" style="margin-left:10px;">Edit</a>	';
                                    } else {
                                        echo '<a class="open_edit_div">Write anything you want...</a>';
                                    }
                                    ?>
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