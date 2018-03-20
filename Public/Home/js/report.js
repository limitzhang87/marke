/**
 * 报表统计的JS文件
 * @type {String}
 */
var uid   = "*";
var year  = "*";
var month = "*";
var day   = "*";
var time = "*";
var page = 1;
var type = 1;
var append = 0;
var status = 1;
/**
 * 其中的year,month,day,time都是以两个时间戳以“-”拼接在一起
 */

/**
 * 初始化月份和年份
 */
$(document).ready(function(){
	$('.dropdown-backdrop').click(function(){
		$('.open').removeClass('open');
	});

	$('.filter>.button').click(function(){
		$(this).parent().addClass('open');
	});
	filterClick();
	if(uid != '*'){//某个会员的统计
		var uidClick = $('li>a[data-value="'+uid+'"]');
		uidClick.click();
		$('#uid>.button').html(uidClick.html());
		$('#uid>.button').data('value', uid);
	}else{
		getList();
	}
})

/**
 * 获取数据列表
 * @return {[type]} [description]
 */
function getList() {
	status = 0;
	//var data = {'uid':uid,'year':year,'month':month,'day':day,'page':page};
	var data = {'type':type, 'uid':uid,'time':time,'page':page};
	$.ajax({
		url:ThinkPHP.APP + 'Home/Report/getReportList',
		data:data,
		type:'POST',
		beforeSend:function(){
			$('#dialog_load').addClass('show');
		},
		complete:function(){
			$('#dialog_load').removeClass('show');
		},
		error:function(){
			alert('获取数据失败！');
		},
		success:function(msg){
			if(msg.status == 1){
				listHtml(msg.info);
			}else{
				alert('获取失败！');
			};
		}
	});
}

/**
 * 根据数据数组拼接HTML字符串
 * @param  {array} list 数组
 */
function listHtml(info) {
	var tip = $('li>a[data-value="'+uid+'"]').html();

	if(uid == '*'){
		var tip = '全部会员';
	}
	if(time != '*'){
		var timtArry = time.split('-');
		tip += '>'+time2str2(timtArry[0]) +' - ' + time2str2(timtArry[1]);
	}
	$('#total').html(tip + '>共' + info.total + '套');
	var html = '';
	var list = info.list;
	$(list).each(function(i,item){
		html += '<div class="item_s" onclick="toRoom(\''+item.id+'\');">'+
            '<div class="item_info" style="width: 100%;">'+
                '<div class="item_title_ss">'+item.b_name+'-'+item.u_name+'-'+item.room_number+'</div>'+
                '<div style="position: absolute;top: 0.4rem;right: 1rem;">审核人:'+item.check_name+'</div>'+
                '<div style="position: absolute;bottom: 0.1rem;left: 2rem;">'+(type == 1 ? '锁定人':'成交人')+':'+ item.nick_name +'</div>'+
                '<div style="position: absolute;bottom: 0.1rem;right: 1rem;">'+ time2str(  ( (item.submit_time == '' || item.submit_time == undefined) ? item.lock_time : item.submit_time)  )+'</div>'+
            '</div>'+
        '</div>';
	});
	if(list != null && list.length == 10){
		status = 1;
	}else{
		html += '<center>没有更多数据！</center>';
	}

	if(append == 0){
		$('#content').html(html);
	}else{
		$('#content').append(html);
	}
}

/**
 * 下载数据
 */
function downloadExcel(title) {

	 //定义一个form表单
    var myform = $("<form id='a'></form>");
    myform.attr('method','post')
    myform.attr('action',ThinkPHP.APP + 'Home/Report/downloadExcel');

	var data = {'title':title,'type':type, 'uid':uid,'time':time,'page':page};
	$.each(data,function(i,v){
		var item = $("<input type='hidden' name='"+i+"' />");
    	item.attr('value',v);
    	myform.append(item);
	})
	myform.appendTo('body').submit();

}

function toRoom(id){
    var url = ThinkPHP.APP + '/Home/Room/room_info/id/' + id;
    window.location.href = url;
}

/**
 * 点击过滤条件
 * @return {[type]} [description]
 */
function filterClick() {
	$('li>a').unbind("click"); //移除click
	$('li>a').click(function(){
		append = 0;
		var type = $('.open').data('type');
		var value = $(this).data('value');
		cleanSearch();
		if($('.open>.button').data('value') == value){//点击重复的按钮直接返回
			hideOpen();
			return ;
		}
		switch(type){
			case 'uid':
				uid = value;
				break;
			case 'year':
				yearChange(type, value);
				break;
			case 'month':
				monthChange(type, value);
				break;
			case 'day':
				dayChange(type, value);
				break;
			default:
				break;
		}
		$('.open>.button').html($(this).html());
		$('.open>.button').data('value', value);
		hideOpen();
		getList();
	});
}

//滚动条判断
$(document).scroll(function() {
    var Sbottom = $(document).height() - $(window).height() - $(window).scrollTop();
    if (Sbottom < 70 && status == 1) {
    	page +=1;
    	append = 1;
        getList();
    }
});
/**
 * 隐藏下拉框
 * @return {[type]} [description]
 */
function hideOpen() {
	$('.open').removeClass('open');
}
/**
 * 日期查询
 */
function dateSearch(){
	var date1 = $('input[name="date1"]').val();
	var date2 = $('input[name="date2"]').val();
	if(date1 == '' || date2 == ''){
		alert('请选择日期！');
		return ;
	}
	date1 = str2time(date1) ;
	date2 = str2time(date2 + ' 23:59:59');

	if(date1 > date2){
		alert('结束日期在开始日期之前，无效查询！@');
		return ;
	}
	/**
	 * 将筛选条件的年月日清空
	 */
	cleanFilter('year');
	cleanFilter('month');
	cleanFilter('day');

	time = date1 + '-' + date2;

	append = 0;
	$(this).parent().removeClass('open');
	getList();
}

/**
 * 清除搜索框内容
 */
function cleanSearch(){
	$('input[name="date1"]').val('');
	$('input[name="date2"]').val('');
	time = '*';
}

function cleanFilter(filter) {
	var fhtml = '';
	switch(filter){
		case 'uid':
			fhtml = '会员';
			uid = '*';
			break;
		case 'year':
			fhtml = '年份';
			year = '*';
			break;
		case 'month':
			fhtml = '月份';
			month = '*';
			break;
		case 'day':
			fhtml = '日期';
			day = '*';
			break;
	}
	$('#'+filter+'>.button').html(fhtml);
	$('#'+filter+'>.button').data('value', '*');
	time = '*';
}

/**
 * 点击年份处理数据
 */
function yearChange(type, value) {
	time = value;
	year = value;
	if(year == '*'){
		//选着的是所有年限，月份和日期初始化。
		month = '*';
		day = '*';
		$('#month>.dropdown-menu>li>a').each(function(i, item){
		if(i == 0){
			return 1;//跳出本次循环
		}
			$(item).data('value','*');
		});

		$('#day>.dropdown-menu>li>a').each(function(i, item){
			if(i == 0){
				return 1;//跳出本次循环
			}
			$(item).data('value','*');
		});

		//月份清空
		var monthhtml =  '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="*">月份</a>'+
	                '</li>';
		$('#month>.dropdown-menu').html(monthhtml);
		$('#month>.button').html('月份');
		$('#month>.button').data('value', '*');
		//日期清空
		var dayhtml =  '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="*">日期</a>'+
	                '</li>';
		$('#day>.dropdown-menu').html(dayhtml);
		$('#day>.button').html('日期');
		$('#day>.button').data('value', '*');
		return;
	}

	/**
	 * 选中年份，计算当年各个月份1好的时间戳
	 */
	var temp = year.split('-');
	var d = new Date(temp[0] * 1000);    //根据时间戳生成的时间对象
	var yearStr = (d.getFullYear());
	var monthValue = new Array();
	for (var i = 1; i <= 12; i++) {
		var  day = new Date(yearStr,i,0);
    	var daycount = day.getDate();//获取当月天数
    	/*获取每个月第一天和最后一天的时间戳*/
		monthValue[i-1] = str2time(yearStr+'-'+i+'-01') +'-'+ str2time(yearStr+'-'+i+'-' + daycount + ' 23:59:59');
	}
	$('#month>.dropdown-menu>li>a').each(function(i, item){
		if(i == 0){
			return 1;//跳出本次循环
		}
		$(item).data('value',monthValue[i-1]);
	});

	var html = '';
	for (var i = 0; i <= 12; i++) {
		if(i == 0){
			html += '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="*">月份</a>'+
	                '</li>';
		}else{
			html += '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="'+monthValue[i-1]+'">'+i+'</a>'+
	                '</li>';
            }
	}
	$('#month>.dropdown-menu').html(html);
	filterClick();//月份数据已更新，需要重新绑定点击事件
}

/**
 * 点击月份处理数据
 */
function monthChange(type, value) {
	if(year == '*'){
		hideOpen();
		alert('您还没有选择年份！');
		return;
	}
	time = value;
	month = value;
	if(month == '*'){
		time = year;//如果选中所有月份，时间修改为当前年份；
		day = '*';
		$('#day>.dropdown-menu>li>a').each(function(i, item){
		if(i == 0){
			return 1;//跳出本次循环
		}
			$(item).data('value','*');
		});
		//日期清空
		var html =  '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="*">日期</a>'+
	                '</li>';
		$('#day>.dropdown-menu').html(html);
		$('#day>.button').html('日期');
		$('#day>.button').data('value', '*');
		return;
	}
	/**
	 * 选中月份，获取将当前月份的日期的时间戳
	 */
	var temp = month.split('-');
	var d = new Date(temp[0] * 1000);    //根据时间戳生成的时间对象
	var yearStr = d.getFullYear();	//获取年份
	var monthStr = d.getMonth()+1;	//获取月份

	var  day = new Date(yearStr,monthStr,0);
    var daycount = day.getDate();//获取当月天数

	var dayValue = new Array();
	for (var i = 1; i <= daycount; i++) {
		dayValue[i-1] = str2time(yearStr+'-'+monthStr+'-' + i) + '-' + str2time(yearStr+'-'+monthStr+'-' + i + ' 23:59:59');
	}
	var html = '';
	for (var i = 0; i <= daycount; i++) {
		if(i == 0){
			html += '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="*">日期</a>'+
	                '</li>';
		}else{
			html += '<li role="presentation">'+
	                    '<a tabindex="-1" href="#" data-value="'+dayValue[i-1]+'">'+i+'</a>'+
	                '</li>';
            }
	}
	$('#day>.dropdown-menu').html(html);
	filterClick();
}

/**
 * 点击日期处理数据
 */
function dayChange(type, value) {
	if(year == '*'){
		hideOpen();
		alert('您还没有选择年份！');
		return;
	}

	if(month == '*'){
		hideOpen();
		alert('您还没有选择月份！');
		return;
	}
	time = value;
	day = value;
}

