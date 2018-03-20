var field  = '*';//过滤器选择的字段
var name   = "*";//过滤器选择字段的值
var year   = "*";
var month  = "*";
var day    = "*";
var time   = "*";
var time_style = '*';

var funName = 'getList';
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
})

/**
 * 点击过滤条件
 * @return {[type]} [description]
 */
function filterClick() {
	$('li>a').unbind("click"); //移除click
	$('li>a').click(function(){
		var type = $('.open').data('type');
		var value = $(this).data('value');
		cleanSearch();//清楚搜搜索框
		if($('.open>.button').data('value') == value){//点击重复的按钮直接返回
			hideOpen();
			return ;
		}
		switch(type){
			case 'name':
				name = value;
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
			case 'order':
				order = value;
				break;
			case 'time_style':
				time_style = value;
				break;
			default:
				break;
		}
		$('.open>.button').html($(this).html());
		$('.open>.button').data('value', value);
		hideOpen();
		window[funName]();//执行获取列表函数
	});
}

/**
 * 隐藏下拉框
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
		alert('结束日期在开始日期之前，无效查询！');
		return ;
	}
	/* 将筛选条件的年月日清空*/
	cleanFilter('year');
	cleanFilter('month');
	cleanFilter('day');

	time = date1 + '-' + date2;

	append = 0;
	$(this).parent().removeClass('open');
	//getList();
	window[funName]();
}

/*清除搜索框内容*/
function cleanSearch(){
	$('input[name="date1"]').val('');
	$('input[name="date2"]').val('');
	//time = '*';
}

function cleanFilter(filter) {
	var fhtml = '';
	switch(filter){
		case 'name':
			fhtml = '会员';
			name = '*';
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

	if(day == '*'){
		time = month;//如果选中所有日期，时间修改为当前月份；
		day = '*';
		return;
	}
}
