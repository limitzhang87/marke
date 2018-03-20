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
                $('#building_list').html('<div style="width: 100%;text-align: center;font-size: 1.2rem;margin: 10px 0;">暂无楼栋信息！</div>');
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
             html += '<div class="button" button_on" onclick="selectUnit(\''+item.id+'\')">'+item.u_name+'</div>'
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
                $('#room_list').html('<li id="load" class="load_icon_3"></li>');
        },
        error:function(msg){
            $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
        },
        success:function(msg){
            $('#submit_u_id').val(u_id);
            if(msg.status == 1){
                roomHtml(msg.info);
            }else{
                $('#room_list').html('<div style="width: 100%;text-align: center;font-size: 1.5rem;margin: 10px 0;">暂无房号信息！</div>');
            }
        }
    });
}

/**
 * 为了能够选让用户可以多选，横着或者竖着
 * 需要在每一行和每一列最前面加上多选框
 * 在点击某一个全选框之后，判断他是横还是竖着，在获取第几行或者第几列
 * 在最上方的一行是选着竖着的，值为y_1,表示选择的第一列
 * 在最左边的一列是选择一行的，值为x_2，表示选择第二行
 * 而每一个房号前面的复选框也会带有特定的值，如x_1-y_1,这个代表的是第二行第一列
 * @param  {[type]} list [description]
 * @return {[type]}      [description]
 */
var y = 1;//水平数量
var x = 1;//垂直数量
function roomHtml(list){
    var html = '';
    var check = 1;
    x = 1;
    y = 1;
    for(var li in list){//循环层
        /*顶部加上付款狂*/
         if(type == 1){
            html += '<div class="floor_1">'+
                    '<div class="room_info_1">';
        }else{
            if(check == 1){
                html += '<div class="floor" style="margin:0 0;">'+
                        '<div class="room_info">';
                $(list[li]).each(function(i,item){//循环房数
                    html += '<input type="checkbox" name="selectAll" data-id="y_'+y+'">';
                     html += '<div class="room_number"></div>';
                     y++;
                });
                y = 1;
                html +=  '</div>'+
                        '</div>';
                check = 0;
            }
            html += '<div class="floor">'+
                        '<div class="floor_num" style="margin:0 0;">'+li+'</div>'+
                        '<input type="checkbox" name="selectAll" data-id="x_'+x+'">'+
                        '<div class="room_info">';
        }


        y = 1;
        $(list[li]).each(function(i,item){//循环房数
            var status = '';
            html += '<div style="display: -webkit-box;">';
            if(item.status == 0 ){
                html += '<input type="checkbox" name="ids[]" data-id="x_'+x+'-y_'+y+'" value="'+item.id+'">';
            }else if(item.status == 2){//已经销控
                html += '<input type="checkbox" name="ids[]" data-id="x_'+x+'-y_'+y+'" value="'+item.id+'" checked="checked">';
            }else{
                html += '<span style="padding-left:12px;"></span>';
            }
            html += '<div class="room_number '+item.statusCSS+'" >'+item.room_number+'</div>';
            y++;
             html += '</div>';
        });
        html +=   '</div>'+
                '</div>';
        x++;
    }
    $('#room_list').html(html);
    bindLister();
}

function bindLister(){
    $('input[name="selectAll"]').change(function(){
        var id = $(this).data('id');
        var array = id.split('_');
        if(array[0] == 'x'){
            for (var i = 1; i < y; i++) {
                if($(this).prop('checked')){
                    $('input[data-id="x_'+array[1]+'-y_'+i+'"]').prop('checked','checked');
                }else{
                     $('input[data-id="x_'+array[1]+'-y_'+i+'"]').prop('checked',false);
                }
            }
        }else{
            for (var i = 1; i < x; i++) {
                if($(this).prop('checked')){
                    $('input[data-id="x_'+i+'-y_'+array[1]+'"]').prop('checked','checked');
                }else{
                     $('input[data-id="x_'+i+'-y_'+array[1]+'"]').prop('checked',false);
                }
            }
        }
    });
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

function toRoom(id){
    var url = ThinkPHP.APP + '/Home/Room/room_info/id/' + id;
    window.location.href = url;
}