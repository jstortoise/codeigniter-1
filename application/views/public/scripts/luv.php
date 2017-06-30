<script type="text/javascript">
    $(document).on('click', '.heart', function (e) {
        var self = $(e.currentTarget);
        var userId = $(self).attr('userId');
        if (!self.find('.give').length) {
            var myLuvInformation = $('#myLuvInformation');
            var freeLuv = myLuvInformation.attr('freeLuv');
            var points = myLuvInformation.attr('points');
            if (freeLuv > 0) {
                giveLuv(userId);
            } else if (points >= 5) {
                noFreeLuv(userId);
            } else {
                noSitePoints();
            }
        }
    });

    function giveLuv(to_member_id, forPoints=null) {
        $('.luv-give' + to_member_id).addClass('give');
        $('.luv-give' + to_member_id).parent().find('img').addClass('give');
        setTimeout(function () {
            $('.luv-give' + to_member_id).removeClass('give');
            $('.luv-give' + to_member_id).parent().find('img').removeClass('give');
        }, 2000);
        var myLuvInformation = $('#myLuvInformation');
        myLuvInformation.attr('freeLuv', parseInt(myLuvInformation.attr('freeLuv')) - 1);
        if (forPoints) {
            myLuvInformation.attr('points', parseInt(myLuvInformation.attr('points')) - 5);
        }
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>luv/give_luv_ajax',
            dataType: 'json',
            data: {
                to_member_id: to_member_id,
                forPoints: forPoints
            },
            success: function (data) {
                if (data.result == 'ok') {
                    giveLuvFrontend(to_member_id);
                }
            },
            error: function (data) {
                swal(
                    'Error',
                    "Sorry, we can't send Luv now. Try later please",
                    'error'
                );
            }
        });
    }

    function noFreeLuv(userId) {
        swal({
            title: 'You have no free Luv',
            text: "You can give Luv for 5 points",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Give for points'
        }).then(function () {
            giveLuv(userId, true);
        });
    }

    function noSitePoints() {
        swal({
            title: 'You have no free Luv',
            text: "You have less than 5 points",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#30d674',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Get more points'
        }).then(function () {
            window.location.href = '<?=base_url()?>dashboard/wallet';
        });
    }

    function giveLuvFrontend(to_member_id) {
        $('.luv-points' + to_member_id).html(parseInt($('.luv-points' + to_member_id).html()) + 25);
        $('.my-luv-points').html(parseInt($('.my-luv-points').html()) + 10);
        var name = $('.I-gave-luv' + to_member_id).attr('memberName');
        $('.I-gave-luv' + to_member_id).html('You gave ' + name + 'a Luv moment ago');
        var count = parseInt($('.I-gave-luv-count' + to_member_id).attr('count')) + 1;
        $('.I-gave-luv-count' + to_member_id).attr('count', count);
        $('.I-gave-luv-count' + to_member_id).html('You have sent ' + count + ' Luv to this member');

        var det = $($('#luvDetailsTemplate').html());
        det.find('.userName').html('You have sent ' + name + ' a Luv moment ago');
        $('#luvDetails .for-details-inner').prepend(det);
        $('.member-list'+to_member_id+' .for-details-inner').prepend(det.clone());

        var freeLuv=parseInt($('.my-free-luv-count').text());
        if(freeLuv<1 || isNaN(freeLuv)){
            freeLuv='no';
        }else{
            freeLuv--;
        }
        $('.my-free-luv-count').text(freeLuv);
    }


</script>