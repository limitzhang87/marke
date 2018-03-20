 /**
  * 触发文件上传选择框架
  */
 function fileSelect() {
     $('#fileUpload').click();
 }
 /**
  * 触发图片选择框架
  */
 function picSelect() {
    $('#picUpload').click();
 }

 /**
  * 当图片选择框选择文件时自动上传。
  */
 function pic2Upload() {
     var formData = new FormData($('#formPic')[0]); //获取表单
     //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
     //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
     $.ajax({
         url: ThinkPHP.APP + '/Home/UploadPic/uploadPicture',
         type: 'POST',
         data: formData, // Form数据
         cache: false,
         contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
         processData: false, // 告诉jQuery不要去处理发送的数据
         beforeSend: function() {
             var html = '<div class="img_div" id="loading">' +
                 '<img class="up_pic"  src="'+ThinkPHP.ROOT+'/Public/Mobile/images/icon/load.gif">' +
                 '</div>';
             $('#showPic').append(html);
         },
         success: function(msg) {
             $('#loading').remove();
             if (msg.status == 1) {
                 $(msg.info).each(function(i,msg){
                    var html = '<div class="img_div"  data-id="' + msg.id + '">' +
                     '<div class="close" onclick="delImg(' + msg.id + ')">X</div>' +
                     '<img class="up_pic" src=".' + msg.path + '">' +
                     '</div>';
                     $('#showPic').append(html);
                     $('#showPic').removeClass('hide');
                 });
                 var idA = new Array();
                 $('#showPic>div').each(function(i, item) {
                     idA[i] = $(item).data('id');
                 });
                 var ids = idA.join(',');
                 $('input[name="pictures"]').val(ids);
             } else {
                 alert(msg.info);
             }
         },
         error: function() {
             alert('上传失败');
         },
     });
 }
 /**
  * 删除图片
  * @param  {[type]} pic_path [description]
  * @return {[type]}          [description]
  */
 function delImg(pid) {
     $.ajax({
         type: 'POST',
         data: 'id=' + pid,
         url: ThinkPHP.APP + '/Home/UploadPic/del_Img',
         success: function(msg) {
             $('div[data-id="' + pid + '"]').remove(); //清除图片

             var idA = new Array();
             $('#showPic>div').each(function(i, item) {
                 idA[i] = $(item).data('id');
             });
             var ids = idA.join(',');
             $('input[name="pictures"]').val(ids);
             if (ids == '') {
                 $('#showPic').addClass('hide');
             }
         }
     });
 }
 /**
  * 当文件选择框选择文件时自动上传。
  */
 function file2Upload() {
     var formData = new FormData($('#formFile')[0]); //获取表单
     //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
     //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
     $.ajax({
         url: ThinkPHP.APP + '/Home/File/upload',
         type: 'POST',
         data: formData, // Form数据
         cache: false,
         contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
         processData: false, // 告诉jQuery不要去处理发送的数据
         beforeSend: function() {
             var html = '<div class="img_div" id="loadingF">' +
                '<img class="up_pic"  src="'+ThinkPHP.ROOT+'/Public/Mobile/images/icon/load.gif">' +
                '</div>';
             $('#showFile').append(html);
         },
         success: function(msg) {
             $('#loadingF').remove();
             var msg = msg.info;
             var html = '<div class="file_div" data-fid="' + msg.id + '">' +
                 '<span>' + msg.name + '</span>' +
                 '<button type="button" class="close1" onclick="delFile(' + msg.id + ')">×</button>' +
                 '</div>';
             $('#showFile').append(html);
             $('#showFile').removeClass('hide');
             var idA = new Array();
             $('#showFile>div').each(function(i, item) {
                 idA[i] = $(item).data('fid');
             });
             var ids = idA.join(',');
             $('input[name="file"]').val(ids);
         },
         error: function() {
             alert('上传失败');
         },
     });
 }

 /**
  * 删除文件
  */
 function delFile(fid) {
     $.ajax({
         type: 'POST',
         data: 'id=' + fid,
         url: ThinkPHP.APP + '/Home/File/del_File',
         success: function(msg) {
             $('div[data-fid="' + fid + '"]').remove(); //清除图片
             var idA = new Array();
             $('#showFile>div').each(function(i, item) {
                 idA[i] = $(item).data('fid');
             });
             var ids = idA.join(',');
             $('input[name="file"]').val(ids);
             if (ids == '') {
                 $('#showFile').addClass('hide');
             }
         }
     });
 }