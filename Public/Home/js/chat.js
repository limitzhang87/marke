    /**
     * 获取聊天记录
     */
    $(function() {
        getChatList(); //界面加载完成获取最新10条记录
        firstTime = (new Date()).valueOf(); //时间登录当前时间
        setTimeout('getNewChat()', 5000);
    });
    /**
     * 计时器获取最新聊天记录
     * @return {[type]} [description]
     */
    var time = 5000;
    function getNewChat() {
        getChatList(2);
        setTimeout('getNewChat()', time);
    }
    var lastTime = (new Date()).valueOf();; //最后一条聊天记录的时间。
    var firstTime = (new Date()).valueOf(); //最前面一条聊天记录的时间
    var user = '';
    var bg_color = '';
    /**
     * type == 1，获取以前的10条的聊天记录，参数是最前面一条消息的时间。
     * type == 2, 获取最新时间的的聊天记录
     * @type {String}
     */
    var $data = '';
    var status  = 1;
    function getChatList(type) {
        type = type || 1;
        if (type == 1) {
            $data = { 'type': 1, 'firstTime': firstTime, 'limit': 10 };
        } else {
            var type = 2;
            $data = { 'type': 2, 'lastTime': lastTime };
        }
        if(status == 0){
            return ;
        }
        status = 0;//将status赋值为0,是为了在上一次获取没有成功返回时有马上获取信息的
        $.ajax({
            url: ThinkPHP.APP + '/Home/Chat/getChatList',
            data: $data,
            type: 'POST',
            error: function() {
                alert('获取失败!');
            },
            success: function(msg) {
                if (msg.status == 1){
                    status = 1;
                    chatHtml(msg.info, type);
                } else {
                    alert('获取失败!');
                }
            }
        });
    }

    /**
     * 发送聊天
     */
    $('#send').on('click', function() {
        var content = $('#content').val();
        if (content == '') {
            return;
        }
        $('#content').val('');
        $.ajax({
            url: ThinkPHP.APP + '/Home/Chat/send',
            data: 'content=' + content,
            type: 'POST',
            error: function() {
                alert('发送失败!');
            },
            success: function(msg) {
                if (msg.status == 1) {
                    getChatList(2);
                } else {
                    alert('发送失败!');
                }
            }
        });
    });
    var is_first = true; //是否是第一次获取聊天记录，以便将滚动条拉倒底部和获取第一次中的最新时间
    /**
     * 渲染聊天记录
     * @param  {string } list [聊天记录]
     * @param  {Number} type [类型，1：以前的聊天记录，2：最新聊天记录]
     * @return {[type]}      [description]
     */
    function chatHtml(list, type) {
        type = type || 1;
        if (list == null) {
            time += 2000;
            return;
        }
        var html = '';
        $(list).each(function(i, item) {
            if (type == 1) {
                firstTime = list[0].send_time; //在获取之前10条记录之后，最早时间要等于第一条时间
            } else {
                lastTime = list[list.length - 1].send_time; //在获取最新记录之后，最晚时间要等于最后一条
            }
            if (item.uid == user.uid) {
                html += '<div class="chat_user right">' +
                    '<div class="chat_info">' +
                    '<div class="chat_content" style="background-color: ' + bg_color + ';color: #fff;">' + item.content + '</div>' +
                    '<div class="chat_user_info">' + time2str(item.send_time / 1000) + '</div>' +
                    '</div>' +
                    '<div class="chat_head">' +
                    '<img src="' + ThinkPHP.ROOT + user.head_img + '">' +
                    '</div>' +
                    '</div>';
            } else {
                //var date = new Date(item.send_time);
                html += '<div class="chat_user">' +
                    '<div class="chat_head">' +
                    '<img src="' + ThinkPHP.ROOT + item.head_img + '">' +
                    '</div>' +
                    '<div class="chat_info">' +
                    '<div class="chat_user_info">' + item.nick_name + '|' + item.phone + '</div>' +
                    '<div class="chat_content" >' + item.content + '</div>' +
                    '<div class="chat_user_info">' + msectime2str(item.send_time) + '</div>' +
                    '</div>' +
                    '</div>';
            }
        });
        if (type != 1) {
            $('.chatHtml').append(html);
            $('#chatHtml').scrollTop($('#chatHtml')[0].scrollHeight);
        } else {
            //$(html).appendTo('#oldChat');
            $('.loading-warp').after(html);
            if (is_first) {
                $('#chatHtml').scrollTop($('#chatHtml')[0].scrollHeight);
                is_first = false; //防止获取以前的数据的时候改变了最新一次记录的时间
            }
        }
    }
    $('#chatHtml').scroll(function(){
        var scroll= $(this).scrollTop();
        if(scroll == 0 && status == 1){
            status = 0;
            $('.loading-warp').animate({margin:'0 0 0 0'},'normal');
            $data = { 'type': 1, 'firstTime': firstTime, 'limit': 10 };
            setTimeout('getListScroll()',700);
        }
    });
    function getListScroll(){
        $.ajax({
            url: ThinkPHP.APP + '/Home/Chat/getChatList',
            data: $data,
            type: 'POST',
            error: function() {
                alert('获取失败!');
            },
            success: function(msg) {
                if (msg.status == 1) {
                    if(msg.info == null|| msg.info.length != 10){
                        status = 0;
                    }else{
                        status = 1;
                    }
                    chatHtml(msg.info, 1);
                    $('.loading-warp').animate({margin:'-50px 0 0 0'},'fast');
                } else {
                    $('.loading-warp').animate({margin:'-50px 0 0 0'},'fast');
                    alert('获取失败!');
                }
            }
        });
    }

    // var $statu = $('.loading-warp .text');
    // var pullRefresh = $('.chatHtml').pPullRefresh({
    //     $el: $('.chatHtml'),
    //     $loadingEl: $('.loading-warp'),
    //     url: ThinkPHP.APP + '/Home/Chat/getChatList',
    //     sendData: {'type':1,'firstTime':firstTime,'limit':10},
    //     //sendData: 'type=1&' + 'firstTime='+firstTime+'&limit=10',
    //     callbacks: {
    //         pullStart: function() {
    //             $statu.text('松开开始刷新');
    //         },
    //         start: function() {
    //             console.log( 'type=1&' + 'firstTime='+firstTime+'&limit=10');
    //             $statu.text('数据刷新中···');
    //         },
    //         success: function(msg) {
    //             if (msg.status == 1) {
    //                 //chatHtml(msg.info);
    //                 $statu.text('数据刷新成功！');
    //             } else {
    //                 $statu.text('下拉刷新结束');
    //             }
    //         },
    //         end: function() {
    //             $statu.text('下拉刷新结束');
    //         },
    //         error: function() {
    //             $statu.text('找不到请求地址,数据刷新失败');
    //         }
    //     }
    // });