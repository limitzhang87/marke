$(function() {

    // $('.back').click(function() {
    //     history.go(-1);
    // })

    $('.showdialog').click(function() {
        showdialog();
    })

    $('.dialog_close').click(function() {
        hidedialog();
    })



});


/**模态框功能 ————START*/
function hidedialog() {
    $('.dialog').hide();
    $('.dialog').remove('show');
}

function showdialog(id) {
    $('#'+id).show();
}


function redirect($url) {
    window.location.href = $url;
}



function inputSelect() {
    // $('input').click(function() {
    //     $(this).select();
    // })
}

/**
 * 使底部高亮
 * @param  {[type]} $url [description]
 * @return {[type]}      [description]
 */
function hightLine($url) {
    $('.bottom_nav').each(function(i, item) {
        if ($(item).attr('onclick').indexOf($url) > 0) {
            $(item).children('li').addClass('bottom_icon_on');
            $(item).children('div').addClass('bottom_name_on');
        }
        //console.log($(item).children('div').html() );
    });
}


/**
 * 时间转化为几天前,几小时前，几分钟前
 * @param  {[type]} dateTimeStamp [description]
 * @return {[type]}               [description]
 */
function getDateDiff(dateTimeStamp){
    dateTimeStamp *= 1000;
    var minute = 1000 * 60;
    var hour = minute * 60;
    var day = hour * 24;
    var halfamonth = day * 15;
    var month = day * 30;
    var year = month*12;
    var now = new Date().getTime();
    var diffValue = now - dateTimeStamp;
    if(diffValue < 0){return;}
    var yearC = diffValue/year;
    var monthC =diffValue/month;
    var weekC =diffValue/(7*day);
    var dayC =diffValue/day;
    var hourC =diffValue/hour;
    var minC =diffValue/minute;
    if(yearC >= 1){
         result="" + parseInt(monthC) + "年前";
    }
    else if(monthC>=1){
        result="" + parseInt(monthC) + "月前";
    }
    else if(weekC>=1){
        result="" + parseInt(weekC) + "周前";
    }
    else if(dayC>=1){
        result=""+ parseInt(dayC) +"天前";
    }
    else if(hourC>=1){
        result=""+ parseInt(hourC) +"小时前";
    }
    else if(minC>=1){
        result=""+ parseInt(minC) +"分钟前";
    }else
    result="刚刚";
    return result;
}

/**
 * 时间转化为时间轴
 * @param  {[type]} dateStr [description]
 * @return {[type]}         [description]
 */
function getDateTimeStamp(dateStr){
    return Date.parse(dateStr.replace(/-/gi,"/"));
}


/**
 * 字符串转成日期
 * @param  {string} date 字符串日期
 * @return {int}      时间戳
 */
function str2time(date){
    date = date.substring(0,19); 
    date = date.replace(/-/g,'/'); 
    var timestamp = new Date(date).getTime();
    return timestamp/1000;
}

/**
 * 时间戳转字符串日期
 * @param  {int} time 时间戳
 * @return {string}      字符串日期
 */
function time2str(time) {
    //return new Date(parseInt(time) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');   
    var date =  new Date(time*1000);
    var y = 1900+date.getYear();
    var m = (date.getMonth()+1);
    var d =date.getDate();
    var h =date.getHours();
    var i =date.getMinutes();
    var s =date.getSeconds();
    return y+"年"+m+"月"+d +'日 ' + h +':'+i+':'+s;
}

/**
 * 时间戳转字符串日期
 * @param  {int} time 时间戳
 * @return {string}      字符串日期
 */
function msectime2str(time) {
    //return new Date(parseInt(time) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    time = parseInt(time);
    var date =  new Date(time);
    var y = 1900+date.getYear();
    var m = (date.getMonth()+1);
    var d =date.getDate();
    var h =date.getHours();
    var i =date.getMinutes();
    var s =date.getSeconds();
    return y+"年"+m+"月"+d +'日 ' + h +':'+i+':'+s;
}
/**
 * 时间戳转字符串日期没有秒
 * @param  {int} time 时间戳
 * @return {string}      字符串日期
 */
function time2str2(time) {
    //return new Date(parseInt(time) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');   
    var date =  new Date(time*1000);
    var y = 1900+date.getYear();
    var m = (date.getMonth()+1);
    var d =date.getDate();
    return y+"年"+m+"月"+d +'日';
}



function toRoom(id){
    var url = ThinkPHP.APP + '/Home/Room/room_info/id/' + id;
    window.location.href = url;
}


function blink(ele) {
    ele.addClass('shine');
    setTimeout(function(){unshine(ele)},500);
    setTimeout(function(){shine(ele)},1000);
    setTimeout(function(){unshine(ele)},1500);
    setTimeout(function(){shine(ele)},2000);
    setTimeout(function(){unshine(ele)},2500);
}

function shine(ele) {
    console.log(1);
    ele.addClass('shine');
}
function unshine(ele) {
    console.log(2);
    ele.removeClass('shine');
}