<div class="yellow-line"></div>
<div class="header-inner-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="navigations admin">
                    <ul>
                        <li><a href="<?php echo base_url('admin'); ?>">HOME</a></li>
                        <li><a href="<?php echo base_url('admin/memberslist'); ?>">Members</a></li>
                        <li><a href="<?php echo base_url('admin/paypal'); ?>">Paypal</a></li>
                        <li><a href="<?php echo base_url('admin/payments'); ?>">Payments</a></li>
                        <li><a href="<?php echo base_url('admin/reports'); ?>">Reports</a></li>
                        <li><a href="<?php echo base_url('admin/prices'); ?>">Prices</a></li>
                        <li><a href="<?php echo base_url('admin/posts'); ?>">Posts</a></li>
                        <li><a href="<?php echo base_url('admin/top_text'); ?>">Top Text</a></li>
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
                            <li><a href="<?php echo base_url('admin/setting'); ?>">Account Setting</a></li>
                            <li><a href="#">Help</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="<?php echo base_url('admin/logout'); ?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<script>
    $(".right-menu-button").click(function(){
        $(".pop-over-menu").slideToggle(500);
    });
</script>