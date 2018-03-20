var search_key = '';//搜索类型
var kw = '';//搜索关键词
var fields = '*';//列表搜索字段
var sfields = '*';//统计搜索字段
var unfields = '';//去除的字段
var order = '';//排序
var where = {};//列表搜索条件
var swhere = {};//统计搜索条件
var page = 1;//页数
var field = '*';
var time = '*';
var uid = '';
var time_style = '*';

/**
 * 获取客户列表
 */
function getList(url){
	if(url == '' || url == undefined){
		url =ThinkPHP.APP + '/Home/Customer/getList';
	}
	if(time == "*"){
		time = '0-' + Date.parse(new Date())/1000;
	}
	$.ajax({
		url:url,
		type:'POST',
		data:{'uid':uid, 'search_key':search_key,'kw':kw,'order':order,'where':where,'page':page,'fields':fields,'unfields':unfields,'field':field,'name':name,'time':time,'time_style':time_style},
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
				alert('获取数据失败');
			}
		},
	})
}

/**
 * 渲染客户信息列表
 */
function listHtml(info){
	var tip = $('li>a[data-value="'+name+'"]').html();
	if(name == '*'){
		var tip = '全部';
	}
	if(time != '*'){
		var timtArry = time.split('-');
		if(timtArry.length == 2)
			tip += '>'+time2str2(timtArry[0]) +' - ' + time2str2(timtArry[1]);
	}
	$('#total').html(tip + '>共' + info._total + '条');

	var html = '<div class="table-striped">'+
            '<table border="0" cellspacing="0" cellpadding="0">'+
                '<thead>'+
                    '<tr>'+
                    	'%head%'+
                    '</tr>'+
                '</thead>'+
                '<tbody>'+
                	'%body%'+
                '</tbody>'+
            '</table>'+
        '</div>';
    var head = '';
    head += '<th style="min-width:2.5rem !important;">编号</th>';
    head += '<th style="min-width:2.5rem !important;">操作</th>';
    $.each(info._grids,function(i,item){
    	head += '<th>'+item.title+'</th>';
    });
    //head += '<th>操作</th>';
    var body = '';
    if(info._data != '' && info._data != null){
    	$.each(info._data,function(i,item){
    		if(i >= info._data.length-1){
    			/*最后一行统计底色为灰色*/
    			body += '<tr style="background-color:rgb(200,200,200);">';
    			body += '<td>合计：</td>';
    			body += '<td>-</td>';
    			$.each(info._grids,function(ii,itemG){
	    			body += '<td>'+get_list_field2(item,itemG)+'</td>'
	    		});
	    		//body += '<td></td>';
    		}else{
    			body += '<tr onclick="redirect(\''+ThinkPHP.APP+'/Home/Customer/detail/id/'+item.id+'\')">';
    			body += '<td>'+((page-1)*10 +1+i)+'</td>';
    			body += '<td style="color:blue;" onclick="redirect(\''+ThinkPHP.APP+'/Home/Customer/edit/id/'+item.id+'\')">编辑</td>';
    			$.each(info._grids,function(ii,itemG){
	    			body += '<td>'+get_list_field(item,itemG)+'</td>'
	    		});
	    		//body += '<td style="color:blue;" onclick="redirect(\''+ThinkPHP.APP+'/Home/Customer/edit/id/'+item.id+'\')">编辑</td>';
    		}
	    	body += '</tr>';
	    });
    }

    if(body == ''){
    	body = '<td colspan="'+(info._grids.length+3)+'"  style="text-align:left;"> aOh! 暂时还没有内容! </td>'
    }
    html = html.replace('%head%',head);
    html = html.replace('%body%',body);

    pageHtml(info._page);
    $('.data-table').html(html);
}

/**
 * 修改渲染页码样式
 */
function pageHtml(page) {
	$('.pageShow').html(page);
	$('.pageShow a').each(function(i, item){
		var href = $(item).attr('href');
		$(item).removeAttr('href');
		var index1 = href.indexOf('p/');
		var index2 = href.indexOf('.html');
		var p = href.substring(index1+2,index2);
		$(item).attr('onclick','getListByPage("'+p+'")');
	})
}

function getListByPage(p){
	page = p;
	var url = ThinkPHP.APP + '/Home/Customer/getList/p/' + p;
	getList(url);
}

function listenScroll(){
	$('#tabledata').scroll(function(event){
		var left = $(this).scrollLeft();
		$('#thead').scrollLeft(left);
    });
}

/**
 * 获取统计数据
 */
function getStastics(){
	$.ajax({
		url:ThinkPHP.APP + '/Home/Customer/getStastics',
		type:'POST',
		//data:{'where':where,'search_key':search_key,'kw':kw,'fields':fields,'unfields':unfields},
		data:{'uid':uid, 'search_key':search_key,'kw':kw,'order':order,'where':where,'page':page,'fields':fields,'unfields':unfields,'field':field,'name':name,'time':time,'time_style':time_style},
		beforeSend:function(){

		},
		error:function(){
			alert('获取数据失败！');
		},
		success:function(msg){
			if(msg.status == 1){
				stasticsHtml(msg.info);
			}else{
				alert('获取统计数据失败');
			}
		}

	})
}

/**
 * 渲染统计数据
 * @param  {array} info 统计的数据
 */
function stasticsHtml(data){
	var Shtml = '';
	var i = 1;
	$.each(data,function(key,value){
		var html = '<div style="float:left;margin-left:10px;"><table border="0" cellspacing="0" cellpadding="2" >'+
			    	'<tr><td style="min-width:230px">'+(i)+'.'+value.title+'：</td>'+
					'<td style="min-width:100px">'+value.value+'</td></tr>';
			    '</table></div>';
			 i++;
		// var td = '';
		// $.each(value,function(k,val){
		// 	td += '<tr><td style="min-width:230px">'+(i)+'.'+val.title+'：</td>'+
		// 	'<td style="min-width:100px">'+val.value+'</td></tr>';
		// 	i++;
		// })
		// html = html.replace('%td%',td);
		Shtml += html;
	});
	$('#statistics').html(Shtml);
}



/**
 * 下载数据
 */
function downloadExcel(title) {

	 //定义一个form表单
    var myform = $("<form id='a'></form>");
    myform.attr('method','post')
    myform.attr('action',ThinkPHP.APP + '/Home/Customer/getList');

	var data = {'title':title,'uid':uid, 'search_key':search_key,'kw':kw,'order':order,'where':where,'page':page,'fields':fields,'unfields':unfields,'field':field,'name':name,'time':time};
	$.each(data,function(i,v){
		var item = $("<input type='hidden' name='"+i+"' />");
    	item.attr('value',v);
    	myform.append(item);
	})
	myform.appendTo('body').submit();

}

function downloadStastic(title) {
	 //定义一个form表单
    var myform = $("<form id='a'></form>");
    myform.attr('method','post')
    myform.attr('action',ThinkPHP.APP + '/Home/Customer/getStastics');

	var data = {'title':title,'uid':uid, 'search_key':search_key,'kw':kw,'order':order,'where':where,'page':page,'fields':fields,'unfields':unfields,'field':field,'name':name,'time':time};
	$.each(data,function(i,v){
		var item = $("<input type='hidden' name='"+i+"' />");
    	item.attr('value',v);
    	myform.append(item);
	})
	myform.appendTo('body').submit();
}

/* 解析列表定义规则*/
function get_list_field(data, grid){
	/**
	 * data是一行的数据，而$grid是一行中每一个的数据
	 * 需要根据当前的grid获取到在data中对应的数据
	 */
	var array = '';
	var temp = '';
	var data2 = new Array();
	$(grid.field).each(function(i,item){
		array  =   item.split('|');
        temp  =	data[array[0]];
        // 函数支持
        if( array.length >= 2 ){
            //temp = call_user_func($array[1], $temp);
            temp = window[array[1]](temp);
        }
        data2[array[0]]    =   temp;
	});
	if(temp == '' || typeof(temp)=="undefined"){
		return '-'
	}else{
		return temp;
	}
}
/* 解析列表定义规则*/
function get_list_field2(data, grid){
	/**
	 * data是一行的数据，而$grid是一行中每一个的数据
	 * 需要根据当前的grid获取到在data中对应的数据
	 */
	var array = '';
	var temp = '';
	var data2 = new Array();
	$(grid.field).each(function(i,item){
		array  =   item.split('|');
        temp  =	data[array[0]];
	});
	if(temp == '' || typeof(temp)=="undefined"){
		return '-'
	}else{
		return temp;
	}
}


function getYN(v) {
	if(v == 1){
		return '是';
	}else{
		return '否';
	}
}

function time_format2(v) {
	if(v == 0 || v == '' || v == null){
		return '-';
	}
	var date = new Date(v*1000);
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    m = m < 10 ? ('0' + m) : m;
    var d = date.getDate();
    d = d < 10 ? ('0' + d) : d;
    return y + '-' + m + '-' + d;
}

/**
 * 获取性别
 * @param  int $type 类型
 * @return [type]       [description]
 */
function getSex($type)
{
    if($type == 1){
        return '男';
    }else if($type==2){
        return '女';
    }else{
        return '未知';
    }
}

