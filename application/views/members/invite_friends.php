<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Invite Friend</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/friends.css"/>
    <style>
        .googleContactsButton {
            margin-top: 10px;
        }

        .Hotmail {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
<?= $this->load->view('public/scripts/googleAds', null, true) ?>

<div class="container">
    <div class="row">
        <div class="panel-body">
            <ul class="nav nav-tabs friends_tabs" role="tablist">
                <li><a href="<?php echo base_url('dashboard/friends'); ?>">Friends</a></li>
                <li><a href="<?php echo base_url('dashboard/friendrequests'); ?>">Friend Requests</a></li>
                <li><a href="<?php echo base_url('dashboard/onlinefriends'); ?>">Online Friends</a></li>
                <li class="active"><a href="<?php echo base_url('dashboard/invitefriends'); ?>">Invite Friends</a></li>
            </ul>
        </div>
        <div class="col-sm-10">
            <div style="display: none;" class="alert-success alert fade in" id="successs">
                <button aria-hidden="true" data-dismiss="alert" class="close" onclick="$(this).parent().hide();"
                        type="button">×
                </button>
                <span></span>
            </div>
            <div style="display: none;" class="alert-danger alert fade in" id="faield">
                <button type="button" onclick="$(this).parent().hide();" class="close"
                        data-dismiss="alert">&times;
                </button>
                <span></span>
            </div>
            <form role="form" METHOD="post" action="<?php echo base_url('dashboard/invitefriends'); ?>">
                <div class="form-group">
                    <label for="usr">
                        Invite to join orriz:</label>
                    <input type="email" class="form-control" id="email" required/>
                </div>
                <div class="step-input-field">
                    <button type="button" id="btn-email" class="btn btn-primary">Invite</button>
                </div>
            </form>
            <div class="clearfix"></div>
            <a type="button" href="javascript:void(0);" class="googleContactsButton btn btn-danger">Import Gmail
                Friends</a>
            <a href="javascript:void(0);" class="Hotmail btn btn-success" id="import">Import Hotmail contacts</a>
            <div class="row" id="listing_friends">
            </div>
        </div><!--/row-->
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
    ///
    $('#btn-email').click(function () {
        var email = $('#email').val();
        if (isEmail(email) == false) {
            $('#faield span').text('Please Enter Valid Email.');
            $('#faield').show();
            return false;
        } else {
            $('#faield').hide();
            $('.friend_invite p').remove();
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('dashboard/invitefriends'); ?>',
            data: {'email': email},
            success: function (data) {
                if (data == 0) {
                    $('#faield').hide();
                    $('#successs').hide();
                    $('#faield span').text('Something going wrong');
                    $('#faield').show();
                } else if (data == 1) {
                    $('#faield').hide();
                    $('#successs').hide();
                    $('#successs span').text('Invitation has been successfully sent.');
                    $('#successs').show();
                }
            },
        });
    });
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
<script type="text/javascript" src="https://apis.google.com/js/client.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
    // 1074175154926-pe504grbo95bk48i0ggkv33nfdska8on.apps.googleusercontent.com 
    //8qhiR2-gKZ4wWCq603u2P0F0 
    // client secrete  MDfRyKoVwqka8gGicG-LmKgI 
    //  5_ZhEFMbYbn4ZgcGgZSEgYHu 
    var clientId = '1074175154926-pe504grbo95bk48i0ggkv33nfdska8on.apps.googleusercontent.com';
    var apiKey = 'AIzaSyB6Pd4YgVw7Kmy_tWTuYWYHDPRGTPLeFlE';
    var scopes = 'https://www.googleapis.com/auth/contacts.readonly';
    $(document).on("click", ".googleContactsButton", function (e) {
        if ($('.fa-google .socialCheck').length == 0) {
            $('.fa-google').append('<span class="socialCheck"></span>');
        }
        gapi.client.setApiKey(apiKey);
        window.setTimeout(authorize);
    });
    function authorize() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthorization);
    }
    function handleAuthorization(authorizationResult) {
        if (authorizationResult && !authorizationResult.error) {
            $.get("https://www.google.com/m8/feeds/contacts/default/full?alt=json&access_token=" + authorizationResult.access_token + "&max-results=1000&alt=json",
                function (response) {
                    //process the response here
                    var arrContact = response.feed.entry;
                    $.each(arrContact, function (key, value) {
                        if (typeof(value.gd$email) != "undefined" && value.gd$email !== null) {
                            var email = value.gd$email[0].address;
                            var name = value.title.$t;
                            if (name == '') {
                                name = email;
                            }
                            var html = '<div id="friends_contact" class=' + email + '><div class="col-xs-12 col-md-8"><input onclick="invitegmail(\'' + email + '\',this)"  type="checkbox" /><label>' + name + ' </label></div></div>';
                            $('#listing_friends').append(html);
                        }
                    });
                });
            $('.googleContactsButton').prop('disabled', true);
        }
    }
</script>
<script src="//js.live.net/v5.0/wl.js"></script>
<script type="text/javascript">
    var APP_CLIENT_ID = '';
    var REDIRECT_URL = 'dlVbMXa48sA83H3aUIG7GOnY5-6wwnDh';
    WL.init({
        client_id: '000000004418101D',
        redirect_uri: 'http://localhost/orriz/dashboard/invitefriends',
        scope: ["wl.basic", "wl.contacts_emails"],
        response_type: "token"
    });
    $(document).ready(function () {
        //live.com api
        $('#import').click(function (e) {
            e.preventDefault();
            WL.login({
                scope: ["wl.basic", "wl.contacts_emails"]
            }).then(function (response) {
                    WL.api({
                        path: "me/contacts",
                        method: "GET"
                    }).then(
                        function (response) {
                            //your response data with contacts
                            var arrContact = response.data;
                            $.each(arrContact, function (key, value) {
                                console.log(value.emails.preferred);
                                if (typeof(value.emails.preferred) != "undefined" && value.emails.preferred !== null) {
                                    var email = value.emails.preferred;
                                    var name = value.emails.preferred;
                                    var html = '<div class=' + email + '><div class="col-xs-12 col-md-8"><input  onclick="invitegmail(\'' + email + '\',this)"  type="checkbox" /><label>' + name + ' </label></div></div>';
                                    $('#listing_friends').append(html);
                                }
                                // return false;
                            });
                            //  console.log(response.data);
                        },
                        function (responseFailed) {
                            //console.log(responseFailed);
                        }
                    );
                },
                function (responseFailed) {
                    console.log("Error signing in: " + responseFailed.error_description);
                });
            $('#import').prop('disabled', true);
        });
    });
    function invitegmail(email) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('dashboard/invitefriends'); ?>',
            data: {'email': email},
            success: function (data) {
                if (data == 0) {
                    $('#faield').hide();
                    $('#successs').hide();
                    $('#faield span').text('Something going wrong');
                    $('#faield').show();
                } else if (data == 1) {
                    $('#faield').hide();
                    $('#successs span').text('Invitation has been successfully sent.');
                    $('#successs').show();
                }
            },
        });
    }
</script>
</body>
</html>