<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Orriz - Home</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/post.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/wall.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/screen.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/friends.css"/>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $(this).scrollTop(0);
            $total_records = <?php echo $this->data['total_records']; ?>;
            $records_per_page =<?php echo $this->data['records_per_page']; ?>;
            $number_of_pages =<?php echo $this->data['number_of_pages']; ?>;
            $current_page =<?php echo $this->data['current_page']; ?>;
            $start =<?php echo $this->data['start']; ?>;
            $friend_list =<?php echo json_encode($this->data['friends']); ?>;
            $privacy = localStorage.getItem('privacy_flag');
            if ($privacy == 'undefined') {
                $privacy =<?php echo $this->data['privacy']; ?>;
            }
            var privacyButtonObj = $('#' + $privacy + '.privacy_button');
            changePrivacyButtonLookFill(privacyButtonObj);
            //console.log($privacy);
            $('#popup1').hide();
            if (!$('.detailBox').length) {
                load_data($records_per_page, $start, $privacy, $friend_list);
            }
            $load_more = 0;
            localStorage.setItem('load_more_complete', 0);
            localStorage.setItem('load_more_ready', true);
            function load_data($records_per_page, $start, $privacy, $friend_list, $load_more) {
                localStorage.setItem('load_more_ready', false);
                $.ajax({
                    url: "<?php echo base_url('posts/ajex_load_posts'); ?>",
                    type: "post",
                    data: {
                        "records_per_page": $records_per_page,
                        "start": $start,
                        "privacy": $privacy,
                        "friends": $friend_list
                    },
                    dataType: "html",
                    beforeSend: function () {
                        $("#wallz").append("<span class='load'><img src='<?php echo base_url() . $this->config->item('loading_image_path');?>'/></span>");
                    },
                    complete: function () {
                        $(".load").remove();
                    },
                    success: function (response) {
                        if (!response) {
                            localStorage.setItem('load_more_complete', 1);
                        }
                        else {
                            localStorage.setItem('load_more_ready', true);
                        }
                        if ($load_more != 'scroll') {
                            $("#posts").html('');
                        }
                        $("#posts").append(response);
                        //alert(response);
                        var result = $('<div />').append(response).find('#posts').html();
                        $('#posts').html(result);
                        if (!$('.no_more_post').length) {
                            $('#no_post_container').show();
                        }
                    }
                });
            }

            $current_page = 2;
            $(window).scroll(function () {
                //if($(window).scrollTop() == $(document).height() - $(window).height()) {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                    //$start=($current_page * $records_per_page)-$records_per_page;
                    if (localStorage.getItem('load_more_ready') == false) return;
                    if (!$('.no_more_post').length) {
                        $start = 0;
                    }
                    else {
                        $start = $('.no_more_post').length;
                    }
                    //if($current_page<=$number_of_pages)
                    if (localStorage.getItem('load_more_complete') == "0" && localStorage.getItem('load_more_ready') == "true") {
                        load_data($records_per_page, $start, localStorage.getItem('privacy_flag'), $friend_list, 'scroll');
                        $current_page++;
                    }
                }
            });
            $('.privacy_button').click(function () {
                $('.privacy_button').removeClass('btn-success').addClass('btn-default');
                $('#no_post_container').hide();
                $('.privacy_button').attr('disabled', false);
                localStorage.setItem('load_more_complete', 0);
                changePrivacyButtonLookFill($(this));
                var privacyFlag = $(this).attr('id');
                localStorage.setItem('privacy_flag', privacyFlag);
                privacyFlag = localStorage.getItem('privacy_flag');
                load_data($records_per_page, 0, privacyFlag, $friend_list);
            });
            function changePrivacyButtonLookFill(obj) {
                obj.removeClass('btn-default').addClass('btn-success');
                obj.attr('disabled', true);
            }

            $('#status').on('keyup change', function () {
                if ($(this).val().length) {
                    changeSubmitPostAtt(false);
                }
                else {
                    changeSubmitPostAtt(true);
                }
            });
            $('#image').on('change', function () {
                if ($(this).val().length) {
                    //$('#submit').attr('disabled', false);
                    changeSubmitPostAtt(false);
                }
            });
            function changeSubmitPostAtt(attValue) {
                $('#submit').attr('disabled', attValue);
            }

            $('#myForm').submit(function (e) {
                $('#submit').attr('disabled', 'disabled');
                var data = new FormData(this);

                $.ajax({
                    url: '<?php echo base_url('posts/status_insert'); ?>',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $("#wallz1").append("<span class='load'><img src='<?php echo base_url() . $this->config->item('loading_image_path');?>'/></span>");
                    },
                    complete: function () {
                        $(".load").remove();
                    },
                    success: function (response) {
                        //If post found then remove that "no post" element
                        $('#status').val('');
                        $('#image').val('');
                        $("#posts").prepend(response);
                        if (!$('.detailBox').length) {
                            $('#no_post_container').show();
                        }
                        else {
                            $('#no_post_container').hide();
                        }
                        changeSubmitPostAtt(true);
                    }
                });
                e.preventDefault();
            });
        });
    </script>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true); ?>
<!--Though we pass null to view variables, the view will access all variables that current view access-->
<?= $this->load->view('members/cover_picture_profile', null, true) ?>
<div class="container">
    <div class="row">
        <div class="col-sm-3">

            <!-- This is Google Ad Code, please do not make changes on following code -->


            <center><br/>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Orriz - Dashboard Ad -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:234px;height:60px"
                     data-ad-client="ca-pub-8451164086915508"
                     data-ad-slot="4813050679"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </center>

            <!-- Google Code End here -->


            <div class="post-ad-form-container">
                <div class="post-ad-form">
                    <form role="form" method="post" action="<?php echo base_url('dashboard/postad'); ?>
						">
                        <h5 class="post-ad-form-title hidden-xs">Post Your Ads:</h5>
                        <a href="#" id="mobile_ads" class="visible-xs"><h5 class="post-ad-form-title">Click Here To Post
                                Your Ads:</h5></a>
                        <div class="form_t_data">
                            <?php echo $this->
                            session->flashdata('success'); ?>
                            <div class="post-ad-form-group">
                                <input type="text" name="ad_title" class="post-ad-form-control" placeholder="Ad Title"
                                       maxlength="25" required/>
                            </div>
                            <div class="post-ad-form-group">
                                <input type="text" name="ad_description" class="post-ad-form-control"
                                       placeholder="Ad Description" maxlength="70" required/>
                            </div>
                            <div class="post-ad-form-group">
                                <input type="url" maxlength="250" name="ad_url" class="post-ad-form-control"
                                       value="http://"/>
                            </div>
                            <div>
                                <input type="hidden" name="points" value="<?php echo $points; ?>"/>
                            </div>
                            <div class="post-ad-form-group">
                                <input type="submit" class="post-ad-submit-button" value="Post Ad"/>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="hidden-xs">
                    <?php foreach ($ads as $ad) { ?>
                        <div style="border-bottom: dashed black 1px; margin-bottom: 10px;">
                            <a target="_blank" href="<?= $ad['ad_url'] ?>">
                                <p style="width:100%; word-wrap:break-word;">
                                    <strong style="color:blue;">
                                        <?= $ad['ad_title'] ?>
                                    </strong>
                                </p>
                                <p style="width:100%; word-wrap:break-word; color: black;">
                                    <?= $ad['ad_description'] ?>
                                </p>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="visible-xs">
                    <div class="w3-content w3-display-container">
                        <ul class="custom_slide">
                            <?php foreach ($ads as $ad) { ?>
                                <li class="mySlides">
                                    <a target="_blank" href="<?= $ad['ad_url'] ?>">
                                        <p style="width:100%; word-wrap:break-word;">
                                            <strong style="color:blue;">
                                                <?= $ad['ad_title'] ?>
                                            </strong>
                                        </p>
                                        <p style="width:100%; word-wrap:break-word; color: black;">
                                            <?= $ad['ad_description'] ?>
                                        </p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <button class="w3-button w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
                        <button class="w3-button w3-display-right" onclick="plusDivs(1)">&#10095;</button>
                    </div>
                    <script>
                        var myIndex = 0;
                        carousel();
                        function carousel() {
                            var i;
                            var x = document.getElementsByClassName("mySlides");
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                            }
                            myIndex++;
                            if (myIndex > x.length) {
                                myIndex = 1
                            }
                            x[myIndex - 1].style.display = "block";
                            setTimeout(carousel, 10000); // Change image every 2 seconds
                        }
                        var slideIndex = 1;
                        showDivs(slideIndex);

                        function plusDivs(n) {
                            showDivs(slideIndex += n);
                        }

                        function showDivs(n) {
                            var i;
                            var x = document.getElementsByClassName("mySlides");
                            if (n > x.length) {
                                slideIndex = 1
                            }
                            if (n < 1) {
                                slideIndex = x.length
                            }
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                            }
                            x[slideIndex - 1].style.display = "block";
                        }
                    </script>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
			<strong class="people-know">People You May Know</strong>
            <?php $i = 5;
            if (!empty($relatedUsers)) { ?>
                <div class="col-xs-12">
				<div class="row row-no-padding hidden-xs">
                    <?php foreach ($relatedUsers as $rows) {
                        $time = strtotime($rows['last_activity_timestamp']);
                        $curtime = time();
                        $firstCol = $i % 5 == 0 ? 'col-md-offset-1' : '';
                        $age = isset($rows['birthday']) ? (date('Y') - date('Y', strtotime($rows['birthday']))) : '';
                        $city = isset($rows['city']) ? ' ' . $rows['city'] : '';
                        $country = isset($rows['country']) ? ' ' . $rows['country'] : '';
                        $i++;
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
										class="btn btn-info btn-xs btn_add_friend"><i class="fa fa-user-plus" aria-hidden="true" title="Add friend"></i></a>
									</div>
									<div class="user-name-message">
										<a href="javascript:void(0);" class="msg-system"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
									</div>
								</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
				
				<div class="row row-no-padding visible-xs">
					<div class="w3-content w3-display-container">
                     <ul class="custom_slide_2">
                    <?php foreach ($relatedUsers as $rows) {
                        $time = strtotime($rows['last_activity_timestamp']);
                        $curtime = time();
                        $firstCol = $i % 5 == 0 ? 'col-md-offset-1' : '';
                        $age = isset($rows['birthday']) ? (date('Y') - date('Y', strtotime($rows['birthday']))) : '';
                        $city = isset($rows['city']) ? ' ' . $rows['city'] : '';
                        $country = isset($rows['country']) ? ' ' . $rows['country'] : '';
                        $i++;
                        $status = "statusdeactive";
                        if (($time - $curtime) > 1200 && $rows['is_login'] == 1) {
                            $status = "statusactive";
                        } ?>
						<li class="mySlides_2">
                        <div class="col-xs-12">
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
										class="btn btn-info btn-xs btn_add_friend"><i class="fa fa-user-plus" aria-hidden="true" title="Add friend"></i></a>
									</div>
									<div class="user-name-message">
										<a href="javascript:void(0);" class="msg-system"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
									</div>
								</div>
                            </div>
                        </div>
						</li>
                    <?php } ?>
					</ul>
					<button class="w3-button w3-display-left" onclick="plusDivs2(-1)">&#10094;</button>
                    <button class="w3-button w3-display-right" onclick="plusDivs2(1)">&#10095;</button>
					</div>
                </div>
				<script>
                        var myIndex = 0;
                        carousel2();
                        function carousel2() {
                            var i;
                            var x = document.getElementsByClassName("mySlides_2");
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                            }
                            myIndex++;
                            if (myIndex > x.length) {
                                myIndex = 1
                            }
                            x[myIndex - 1].style.display = "block";
                            setTimeout(carousel2, 10000); // Change image every 2 seconds
                        }
                        var slideIndex = 1;
                        showDivs2(slideIndex);

                        function plusDivs2(n) {
                            showDivs2(slideIndex += n);
                        }

                        function showDivs2(n) {
                            var i;
                            var x = document.getElementsByClassName("mySlides_2");
                            if (n > x.length) {
                                slideIndex = 1
                            }
                            if (n < 1) {
                                slideIndex = x.length
                            }
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                            }
                            x[slideIndex - 1].style.display = "block";
                        }
                    </script>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-9">
                    <div class="posts-ads-container">
                        <div class="wall-posts">
                            <form role="form" id="myForm" action="" enctype="multipart/form-data" method="post">
                                <ul class="nav nav-tabs" style="width: 96%">
                                    <li class="active"><a data-toggle="tab" href="#home">Status Update</a></li>
                                    <li><a data-toggle="tab" href="#menu1">Add Photo</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                <textarea name="status" cols="87" id="status" rows="3"
                                          placeholder="Whats is in Your Mind?"></textarea>
                                    </div>
                                    <div id="menu1" class="tab-pane fade" style="height: 71px;">
                                        <h5>Select Photo From Your Computer</h5>
                                        <input type="file" id="image" name="image"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <form role="form" method="post" action="<?php echo base_url('posts/privacy'); ?>
                                                            "><label class="btn-default">Show:</label>
                                            <button type="button" value="1" id="1"
                                                    class="btn-sm privacy_button btn-default defaultPrivacy"
                                                    name="privacy">Everyone
                                            </button>
                                            <button type="button" value="2" id="2"
                                                    class="btn-sm privacy_button btn-default"
                                                    name="privacy">Friends
                                            </button>
                                            <button type="button" value="3" id="3"
                                                    class="btn-sm privacy_button btn-default"
                                                    name="privacy">Me
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="margin-left :40px;">
                                            <select name="privacy" id="privacy"
                                                    class="form-control privacy-dropdown pull-left input-sm">
                                                <option value="1" selected="selected">Public</option>
                                                <option value="2">Only my friends</option>
                                                <option value="3">Only me</option>
                                            </select>
                                            <input type="submit" name="submit" id="submit" value="Post"
                                                   class="btn btn-primary pull-right" disabled="true">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <span id="please_wait"></span>
                        </div>
                        <br>
                        <div id="wallz1" class="fb_wall">
                            <ul id="posts1">
                            </ul>
                        </div>
                        <!--                <div id="amardev" ></div>-->
                        <div id="wallz" class="fb_wall">
                            <div id="posts"></div>
                        </div>
                        <div id="no_post_container" style="display: none;">
                            There are no posts available.
                        </div>
                        <span class="text-center">
					<ul class="pagination pagination-lg">
                        <?php echo $this->
                        pagination->create_links(); ?> </span>
                    </div>
                </div>
                <div class="col-sm-3 clearfix_responsive hidden-xs">

                    <!-- This is Google Ad Code, please do not make changes on following code -->


                    <center><br/>
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- Dashboard - Right -->
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:160px;height:600px"
                             data-ad-client="ca-pub-8451164086915508"
                             data-ad-slot="6150183070"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </center>

                    <!-- Google Code End here -->

                    <div class="sidebar-ads">
                        <img src="<?php echo base_url(); ?>public/images/sidebar-ad.jpg" alt="Sidebar Ad"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-8">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height:600px">
                        <i class="fa fa-times close_wall visible-xs" aria-hidden="true"></i>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
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
<script type="text/javascript">
    $('#myCarousel').carousel({interval: false});
    $('#wallz').on('click', '.photos .squarified', function (e) {
        var self = $(e.currentTarget);
        var photoId = self.attr('photoId');
        var memberId = self.attr('memberId');
//        $('#myCarousel .carousel-inner').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>images/get_user_photos_ajax',
            data: {
                memberId: memberId,
                photoId: photoId
            },
            success: function (data) {
                $('#myCarousel .carousel-inner').html(data);
                changePhotoDescription();
            },
            error: function (data) {
            }
        });
    });
    $(function () {
        $(".defaultPrivacy").trigger('click');
        $("#status").on("keypress", function (e) {
            if (e.which == 13) {
                if ($(this).val().trim() != '') {
                    $("#submit").click();
                }
            }
        });
        $(document).on("keypress", ".text_post_comment", function (e) {
            if (e.which == 13) {
                if ($(this).val().trim() != '') {
                    $(this).parent().parent().find(".button_post_comment").click();
                    //$(".button_post_comment").click();
                }
            }
        });
    });
    $(document).ready(function () {
        // you can use just jquery for this
        var active =<?php echo $active; ?>;
        if (active === 0) {
            $('#overlay-back').fadeIn(500, function () {
                $('#popup').show();
            });
        } else {
            $('#popup').hide();
        }
    });
    <?php if($message = trim($this->session->flashdata('myFlashMessage'))){
    $result_message = $this->session->flashdata('result_message');
    $notEnoughPoints = $this->session->flashdata('notEnoughPoints');?>
    $(document).ready(function () {
        if (<?= isset($notEnoughPoints) ? 1 : 0 ?>) {
            swal({
                title: 'You have less than 10 points',
                text: "",
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#30d674',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Get more points'
            }).then(function () {
                window.location.href = '<?=base_url()?>dashboard/wallet';
            });
        }
        else {
            swal({
                title: 'Info',
                text: "<?= $message ?>",
                type: '<?= $result_message ? $result_message : 'info'?>',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }
    });
    <?php } ?>
    function add_comment(post_id) {
        //console.log(post_id);
        $('#commentbox_' + post_id).find('.button_post_comment').off('click');
        $('#commentbox_' + post_id).find('.button_post_comment').attr('disabled', true);
        var comment = $('#comment_' + post_id).val();
        $.post('<?php echo base_url('posts/add_comment'); ?>', {post_id: post_id, comment: comment}, function (data) {
            if (data == 'success') {
                $('#comment_' + post_id).val('');
                get_comments(post_id);
            } else
                alert(data);
        });
    }
    function get_comments(post_id) {
        $.post('<?php echo base_url('posts/get_comments'); ?>', {post_id: post_id}, function (comments) {
            $('#view_' + post_id).hide();
            $('#get_comment_' + post_id).html(comments);
        });
    }
    type = "text/javascript" >
        function clear() {
            $("#myForm : input").each(function () {
                $(this).val("");
            });
        }
    function like_add(post_id) {
        $.post('<?php echo base_url('posts/like_post'); ?>', {post_id: post_id}, function (data) {
            //   alert(data);
            if (data == '1') {
                like_get(post_id);
                $('#hearts_' + post_id).hide();
                $('#heart_' + post_id).text('Unlike');
            } else {
                like_get(post_id);
                $('#hearts_' + post_id).hide();
                $('#heart_' + post_id).text('like');
            }
        });
    }
    function like_get(post_id) {
        $.post('<?php echo base_url('posts/get_like'); ?>', {post_id: post_id}, function (data) {
            $('#post_id_' + post_id + '_likes').text(data + '  Likes');
        });
    }

    $('.btn_add_friend').click(function () {
        self = $(this);
        var friend_id = self.attr("id");
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
                    self.html('<i class="fa fa-check-square-o" aria-hidden="true" title="Request sent"></i>');
//                    self.removeClass("btn_add_friend");
                    self.off('click');
                }
            }
        });
    });
</script>
<?= $this->load->view('public/scripts/gallery', ['me' => $me], true); ?>
<!--<script>
    function comment_add(post_id){
            comment=$("#commentbox_'+post_id' :input[name='comment']");
        $.post('<?php /*echo base_url('posts/add_comment'); */ ?>',{post_id:post_id,comment:comment},function(data){
            if(data=='success'){
                $('#comment_'+post_id).data()
            }else
                $('#comment_'+post_id).data()
        });
    }
</script>-->
<div class="hidden-footer">
    <?= $this->load->view('/public/footer', null, true); ?>
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"
   title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span
            class="glyphicon glyphicon-chevron-up"></span></a>
</body>
</html>