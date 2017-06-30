<?= $this->load->view('public/scripts/ga', null, true) ?>
<div class="yellow-line"></div>
<div class="menu_responsive visible-xs">
	<span>Menus <i class="fa fa-angle-double-down arrow_down" aria-hidden="true"></i><i class="fa fa-angle-double-up arrow_up" aria-hidden="true"></i></span>
</div>
<div class="header-inner-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="navigations">
                    <ul>
                        <li><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                        <li><a href="<?php echo base_url('dashboard/wallet'); ?>">Wallet</a></li>
                        <li><a href="<?php echo base_url('dashboard/myprofile'); ?>">Profile</a></li>
                        <li><a href="<?php echo base_url('images/gallery'); ?>">Photos</a></li>
                        <li>
                            <?php $new_messages = $this->session->userdata('new_messages');
                            if ($new_messages >= 1) { ?>
                                <label id="new_messages_counter"
                                       style="color: white;background-color: red;min-width: 15px;text-align: center;float: right;margin-top: 10px;">
                                    <?php echo $new_messages; ?>
                                </label>
                            <?php } ?>
                            <a href="<?php echo base_url('messages/index'); ?>">Messages</a>
                        </li>
                        <li><a href="<?php echo base_url('dashboard/friends'); ?>">Friends</a></li>
                        <li><a href="<?php echo base_url('luv'); ?>">Luv</a></li>
                        <li><a href="<?php echo base_url('dashboard/browsefriends'); ?>">Browse</a></li>
                        <!--                        <li class="dropdown-submenu">-->
                        <!--                            <div class="dropdown">-->
                        <!--                                <a id="dLabel" role="button" data-toggle="dropdown" data-target="#">Browse <span-->
                        <!--                                            class="caret"></span></a>-->
                        <!--                                <ul class="dropdown-menu btn-block" role="menu" aria-labelledby="dropdownMenu">-->
                        <!--                                    <li class="btn-block"><a style="color:black"-->
                        <!--                                                             href="-->
                        <?php //echo base_url('dashboard/browsefriends'); ?><!--">Browse-->
                        <!--                                            Friends</a></li>-->
                        <!--                                    <li class="btn-block"><a style="color:black"-->
                        <!--                                                             href="-->
                        <?php //echo base_url('dashboard/browse'); ?><!--">Search</a>-->
                        <!--                                    </li>-->
                        <!--                                </ul>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                    </ul>
                </div>
                <div class="right-menu">
                    <div class="right-menu-button-container">
                        <button class="right-menu-button">
                            <img src="<?php echo base_url(); ?>public/images/setting-icon.png" alt="Settings"/>
                        </button>
                    </div>
                    <div class="pop-over-menu">
                        <ul>
                            <li><a href="<?php echo base_url('members/edit_profile'); ?>">Account Setting</a></li>                           
                            <li><a href="<?php echo base_url('members/logout'); ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
    window.setInterval(function () {
        iamonline();
    }, 30000);
    function iamonline() {
        $.ajax({
            url: "<?php echo base_url('members/iamonline'); ?>"
        });
    }

    $(".right-menu-button").click(function () {
        $(".pop-over-menu").slideToggle(500);
    });

    <?php if(!isset($_SESSION['timezoneOffset'])) {?>
    var time = new Date();
    var timezoneOffset = -time.getTimezoneOffset();
    $.ajax({
        type: "GET",
        url: "<?=base_url()?>members/set_timezone_offset",
        data: {timezoneOffset: timezoneOffset},
        success: function () {
        }
    });
    location.reload();
    <?php } ?>
</script>