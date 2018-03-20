(function($){
    var $comments_wrapper = $('.document-comments');
    var $comments = $('.document-comments .comment-wrapper');
    var $comment_form = $('.addon-comment-form');
	var $sohu=$('#SOHUCS');
	var $sohu_wrapper=$('.block-cont-bg');
	var $sohu_form=$('.wrap-reply-gw');
    // 组织评论引用关系
    $comments.each(function(){
        var pid = $(this).attr('data-pid');
        if (pid != 0 ) {
            if ($('.comment-id-'+pid).length > 0) {
                $(this).addClass('comment-child').appendTo('.comment-id-'+pid);
            }
            else {
                $(this).find('.comment-content').eq(0).prepend('<div class="no-quote">引用评论已被删除或禁用</div>')
            }
        }
    });

    $comments.find('.card').on('mouseenter', function(){
        $(this).find('.quote').show();
    }).on('mouseleave', function(){
        $(this).find('.quote').hide();
    });
	//回复
    $comments.find('.quote').on('click', function(){
        $comment_form.appendTo($(this).parents('.comment-wrapper').eq(0).children('.comment-content'));
        $('.addon-comment-form input.cancel-quote').show();
        setPID($(this).attr('data-pid'));
        return false;
    });

    $('.addon-comment-form input.cancel-quote').on('click', function(){
        $comments_wrapper.after($comment_form);
        $(this).hide();
        setPID(0);
    });
    $('.addon-comment-form input.submit-comment').on('click', function(){
        var $form = $('.addon-comment-form form');
        var url = $form.attr('action');
        var data = {};
        data.did = $form.find('input[name="did"]').val();
        data.pid = $form.find('input[name="pid"]').val();
        data.content = $form.find('textarea[name="content"]').val();
        data.verify_code = $form.find('input[name="verify_code"]').val();
        $.post(url, data, function(r) {
            refreshVerify();
            if (r.status == 1) {
                commentMessage(r.info, true);
            }
            else {
                commentMessage(r.info, false);
            }
        }, 'json');
    });

    $('.verify-code img').eq(0).parent('div').on('click', function(){
        refreshVerify();
    });

    // 分页添加locationhash
    $('.addon-comment-pagination a').each(function(){
        $(this).attr('href', $(this).attr('href') + '#zf_comment_lists')
    });

    function refreshVerify() {
        // 刷新验证码
        var $verify_img = $('.verify-code img').eq(0);
        var verify_img_url = $verify_img.attr('src');
        $verify_img.attr('src', '').attr('src', verify_img_url+'&'+Date.parse (new Date ()));
    }

    function commentMessage(message, refresh) {
        alert(message);
        if (refresh)
            window.location.reload();
    }

    function setPID(id) {
        $('input[name="pid"]').val(id);
    }


$sohu.find(".evt-reply").on('click', function(){
		//console.log($(this).parents('.block-cont-bg').attr("data-uid"));
		zf_pid=$(this).parents('.block-cont-bg').attr("data-uid");
        $sohu_form.appendTo($(this).parents('.msg-wrap-gw'));
        $sohu_form.show();
        //setPID($(this).attr('data-pid'));
        return false;
    });

$sohu_wrapper.each(function(){
        var pid = $(this).attr('data-pid');
        if (pid != 0 ) {
            if ($('.comment-id-'+pid).length > 0) {
				$(this).removeClass('block-cont-gw');
                $(this).addClass('commchild').appendTo('.comment-id-'+pid);
				$(this).find(".action-click-gw").hide();
                
				
            }
            else {
                $(this).find('.comment-content').eq(0).prepend('<div class="no-quote">引用评论已被删除或禁用</div>')
            }
        }
    });
	
	
	
})(jQuery);