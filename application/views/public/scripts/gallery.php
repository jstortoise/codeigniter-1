<script type="text/javascript">
    $('.submit-comment').click(function (e) {
        var self = $(e.currentTarget);
        var photoId = $('.carousel-inner .item.active').attr('photoId');
        var comment = self.parents().eq(1).find('.photo_comment_textarea').val().trim();
        self.parents().eq(1).find('.photo_comment_textarea').val('');
        if (comment) {
            var com = $('#commentTemplate').clone();
            com.attr('id', '');
            com.find('.orriztime-comment-left').attr('href', '<?=$me->member_url?>');
            com.find('.orriztime-user-name').attr('href', '<?=$me->member_url?>').html('<?=$me->first_name . ' ' . $me->last_name?>');
            <?php $im = $me->image ? $me->image : 'no.png'?>
            com.find('img.thumbnail').attr('src', '<?=base_url() . 'public/images/thumb/' . $im?>');
            com.find('.orriztime-container .truncate p').html(comment);

            var com2 = com.clone();

            $('#photoData').append(com);
            $('#myCarousel .active .hidden-info-comments').append(com2);
            $("#photoData").animate({scrollTop: $('#photoData').prop("scrollHeight")}, 300);
            com.fadeIn();
            com2.show();

            addCommentsCount(photoId);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>images/save_comment_ajax',
                dataType: 'json',
                data: {
                    photoId: photoId,
                    comment: comment
                },
                success: function (data) {
                    if (data.result == 'ok') {
                        com.find('.orriztime-container .actions .comment-time').html('on ' + data.date);
                        com2.find('.orriztime-container .actions .comment-time').html('on ' + data.date);
                    }
                },
                error: function (data) {
                }
            });
        }
    });

    $('#myModal .photo_comment_textarea').keypress(function (e) {
        var key = e.which;
        if (key == 13) {
            e.preventDefault();
            $('#myModal .submit-comment').trigger('click');
        }
    });

    $('#photoData2').on('click', '.action', function (e) {
        var self = $(e.currentTarget);
        var photoId = self.attr('photoId');
        likeToggle(self, photoId);

        var url = self.hasClass('like') ? '<?php echo base_url(); ?>images/like_ajax' : '<?php echo base_url(); ?>images/unlike_ajax';
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {photoId: photoId},
            success: function (data) {
                if (data.result == 'ok') {

                }
            },
            error: function (data) {
            }
        });
    });

    $('#myCarousel').bind('slid.bs.carousel', function (e) {
        changePhotoDescription();
    });

    function changePhotoDescription() {
        var comments = $('#myModal .carousel-inner .active .hidden-info .hidden-info-comments').html();
        var info = $('#myModal .carousel-inner .active .hidden-info .hidden-info-info').html();
        $('#photoData').html(comments);
        $('#photoData2').html(info);
    }

    function likeToggle(el, photoId) {
        el.hide();
        var countEl = el.parents().eq(2).find('.likes-count-for' + photoId);
        var count = countEl.attr('count') ? countEl.attr('count') : 0;
        var hidden = $('.class' + photoId + ' .hidden-info-info');

        var countElHidden = hidden.find('.likes-count-for' + photoId);
        var countElTile = $('#' + photoId).find('.likes-count-for' + photoId);

        if (el.hasClass('like')) {    //like pressed
            el.siblings('.unlike').show();
            count++;
            countEl.attr('count', count).html('&nbsp;&nbsp;&nbsp; Likes: ' + count).show();
            countElTile.html('&nbsp;&nbsp;&nbsp; Likes: ' + count).show();
            countElHidden.html('&nbsp;&nbsp;&nbsp; Likes: ' + count).attr('count', count).show();
            hidden.find('.unlike').show();
            hidden.find('.like').hide();
        } else {     //unlike pressed
            el.siblings('.like').show();
            if (count > 1) {
                count--;
                countEl.attr('count', count);
                countEl.html('&nbsp;&nbsp;&nbsp; Likes: ' + count);
                countElTile.html('&nbsp;&nbsp;&nbsp; Likes: ' + count);
                countElHidden.html('&nbsp;&nbsp;&nbsp; Likes: ' + count).attr('count', count);
            } else {
                count = 0;
                countEl.hide().attr('count', count);
                countElTile.hide();
                countElHidden.attr('count', count).hide();
            }
            hidden.find('.like').show();
            hidden.find('.unlike').hide();
        }
    }

    function addCommentsCount(photoId) {
        var el = $('.comments-count-for' + photoId);
        var count = $(el[0]).attr('count') ? parseInt(el.attr('count')) : 0;
        count++;
        el.each(function () {
            $(this).attr('count', count).show().html('Comments: ' + count);
        });
    }
</script>

<div class="photo-comment" id="commentTemplate" style="display: none;">
    <a class="orriztime-comment-left" href="">
        <img class="thumbnail" src="" alt="">
    </a>
    <div class="orriztime-container orriztime-comment-container orriztime-comment-triangle">
        <a class="orriztime-user-name" href=""></a>
        <div class="truncate" style="word-wrap: break-word;">
            <p></p>
        </div>
        <div class="actions mts">
            <span class="bar"></span>
            <span class="comment-time" style="font-size: 10px; color: #898989;"></span>
        </div>
    </div>
</div>