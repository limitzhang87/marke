/**
 * AJAX获取楼盘房号
 */
var houses_id = '';
var b_id = '';
var u_id = '';
var status = 1;
var type = 0;//类型0-商品房,1-别墅

function changeSellStatus($status){
    if($status == status){
        return;
    }
    status = $status;
    // 改变按样式
    $('.sellStatus_on').removeClass('sellStatus_on');
    $('div[onclick="changeSellStatus('+status+')"]').addClass('sellStatus_on');
    getBuilding();
}

function getBuilding(){
    $.ajax({
        url:'./index.php?s=/Home/Room/getBuilding',
        type:'POST',
        data:{'houses_id':houses_id,'status':status},
        beforeSend:function(){
            $('#building_list').html(' <li class="load_icon_3"></li>');
        },
        error:function(msg){
             $('#building_list').html(msg.info);
        },
        success:function(msg){
            if(msg.status == 1){
                buildingHtml(msg.info);
            }else{
                $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
                $('#building_list').html('<div style="width: 100%;text-align: center;font-size: 1.2rem;margin: 10px 0;">暂无楼栋信息！</div>');
                $('#unit_list').html('<div style="width: 100%;text-align: center;font-size: 1.2rem;margin: 10px 0;">暂无单元信息！&nbsp;&nbsp;&nbsp;</div');
            }
        }
    });
}


function buildingHtml(list){
    var html = '';
    $(list).each(function(i, item){
        if(i == 0){
            html += '<div   class="button button_on" onclick="selectBuilding(\''+item.id+'\','+item.type+')">'+item.b_name+'</div>';
            b_id = item.id;
        }else{
             html += '<div class="button" onclick="selectBuilding(\''+item.id+'\','+item.type+')">'+item.b_name+'</div>'
        }
    });
    getUnit();
    $('#building_list').html(html);
}

/**
 * 根据b_id获取单元
 * @return {[type]} [description]
 */
function getUnit(){
    $.ajax({
        url:'./index.php?s=/Home/Room/getUnit',
        type:'POST',
        data:{'houses_id':houses_id,'b_id' : b_id,'status':status},
        beforeSend:function(){
            $('#unit_list').html('<li class="load_icon_3"></li>');
        },
        error:function(msg){
             $('#unit_list').html(msg.info);
        },
        success:function(msg){
            if(msg.status == 1){
                unitHtml(msg.info);
            }else{
                $('#unit_list').html('<div style="width: 100%;text-align: center;font-size: 1.2rem;margin: 10px 0;">暂无单元信息！&nbsp;&nbsp;&nbsp;</div');
                $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
            }
        }
    });
}

function unitHtml(list){
    var html = '';
    $(list).each(function(i, item){
        if(i == 0){
            html += '<div class="button button_on" button_on" onclick="selectUnit(\''+item.id+'\')">'+item.u_name+'</div>';
            u_id = item.id;
        }else{
             html += '<div class="button" onclick="selectUnit(\''+item.id+'\')">'+item.u_name+'</div>'
        }
    });
    $('#unit_list').html(html);
    getRoom();
}


/**
 * 根据u_id获取房号
 */
function getRoom(){
    $.ajax({
        url:'./index.php?s=/Home/Room/getRoom',
        type:'POST',
        data: {'houses_id':houses_id , 'u_id':u_id,'status':status},
        beforeSend:function(){

        },
        error:function(msg){
            $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
        },
        success:function(msg){
            if(msg.status == 1){
                roomHtml(msg.info);
            }else{
                $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
            }
        }
    });
}

function roomHtml(list){
    var html = '';
    for(var li in list){
        if(type == 1){
            html += '<div class="floor_1">'+
                    '<div class="room_info_1">';
        }else{
            html += '<div class="floor">'+
                    '<div class="floor_num">'+li+'</div>'+
                    '<div class="room_info">';
        }
            $(list[li]).each(function(i,item){
                var status = '';
                html += '<div onclick="toRoom(\''+item.id+'\');">';
                if(item.status == 1){
                    html += '<div class="room_number lock_icon '+item.statusCSS+ '">'+item.room_number+'</div>';
                    html += '<div class="room_nick_name" >'+item.nick_name+'</div>';
                }else if(item.status == 9){
                    html += '<div class="room_number submit_icon '+item.statusCSS+ '">'+item.room_number+'</div>';
                    html += '<div class="room_nick_name_s" >'+item.nick_name+'</div>';
                }else if(item.status == 2){
                    html += '<div class="room_number  submit_icon '+item.statusCSS+ '">'+item.room_number+'</div>';
                    html += '<div class="room_nick_name_s" >'+item.nick_name+'</div>';
                }else {
                    html += '<div class="room_number '+item.statusCSS+ '">'+item.room_number+'</div>';
                }
                html += '</div>';
            });
        html +=   '</div>'+
                '</div>';
    }
    $('#room_list').html(html);
}


/**
 * 点击栋号按钮
 * @param  {int} $id 栋号ID b_id
 * @return {function}     根据新的栋号ID去搜索单元
 */
function selectBuilding($id,t){
    if($id == b_id){ //如果点击的是当前的，就直接返回
        return ;
    }

    $('#building_list .button_on').removeClass('button_on');//
    $('div[onclick="selectBuilding(\''+$id+'\','+t+')"]').addClass('button_on');
    console.log('div[onclick="selectBuilding(\''+$id+'\','+t+')"]');
    b_id = $id;
    type = t;
    getUnit();
}


/**
 * 点击单元按钮
 * @param  {int} $id 单元ID u_id
 * @return {function}     根据新的单元ID去搜索房号
 */
function selectUnit($id){
    if($id == u_id){ //如果点击的是当前的，就直接返回
        return ;
    }

    $('#unit_list .button_on').removeClass('button_on');//
    $('div[onclick="selectUnit(\''+$id+'\')"]').addClass('button_on');
    u_id = $id;
    getRoom();
}
