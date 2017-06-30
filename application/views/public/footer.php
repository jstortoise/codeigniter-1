<div class="clearfix"></div>
<div class="footer">
    <div class="copyright" style="height: 25px;">
        &copy 2017 Orriz. All rights reserved. <a href="#">Privacy Policy</a> | <a href="#">Terms of
            Service</a>
    </div>
    <div class="yellow-line"></div>
</div>
<?php  if ($this->config->item('active') === '0') { ?>
    <script>
        $(document).ready(function () {
            var url = window.location.href;
            if (url.search(/memberdetail/) > 0 || url.search(/aboutyourself/) > 0 || url.search(/uploadimage/) > 0) {
                return false;
            }
            swal({
                title: 'Hello <?= isset($me) ? $me->first_name : '' ?>',
                html: "<h3>Welcome to Orriz!</h3>" +
                "<p>Your account is not verified yet. " +
                "Please check your email and click on the activation link to verify your account.</p>" +
                "<p class='pull-right' id='resend_activation_email'><a href='#'>Resend activation email</a></p>",
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false
            });
        });

        $(document).ready(function () {
            $('#resend_activation_email').click(function () {
                var self = $(this);
                self.html('');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('members/resend_activation_email') ?>',
                    data: {},
                    success: function (data) {
                        self.html("Email sent");
                    },
                    error: function (data) {
                        self.html("Error sendig email");
                    }
                });
            });

            $('#resend_activation_email a').click(function (e) {
                e.preventDefault();
            });
        });
	</script>
<?php } ?>
<script>
	$(document).ready(function(){
		$(".menu_responsive").click(function(){
			$(this).toggleClass("active");
			$(".header-inner-page").slideToggle("slow");
		});
		$(".close_wall").click(function(){
			$("#myModal").removeClass("in");
			$("#myModal").hide();
			$("#luvDetails").hide();
			$("#myModalForAvatar").hide();
			$(".modal-backdrop").remove();
			$("body").removeClass("modal-open");
			$("body").css("padding-right", "0px");
		});
		$("#mobile_ads").click(function(event){
			event.preventDefault();
			$(".form_t_data").slideToggle();
		});
		
	});
</script>
<script>
$(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        $('#back-to-top').tooltip('show');

});
</script>