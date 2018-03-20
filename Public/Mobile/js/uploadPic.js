/**
 * 触发文件选择框架
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
function fileSelect() {
    $('#fileToUpload').click();
}

/**
 * 当文件选择框选择文件时自动上传。
 */
function fileUpload() {
    var formData = new FormData($('#form')[0]); //获取表单
    //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
    //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
    $.ajax({
        url: ThinkPHP.APP + '/Home/UploadPic/upload_img',
        type: 'POST',
        data: formData, // Form数据
        cache: false,
        contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
        processData: false, // 告诉jQuery不要去处理发送的数据
        beforeSend: function() {
            var html = '<div class="img_div" id="loading">' +
                '<img class="up_pic"  src="./Public/Home/images/load.gif">' +
                '</div>';
            $('.pic_scoll').append(html);
        },
        success: function(msg) {
            $('#loading').remove();
            console.log(msg);
        },
        error: function() {
            alert('上传失败');
        },
    });
}

function delImg(id) {
    //$('div[data-id="'+id+'"]').remove();
    var pic_path = $('div[data-id="' + id + '"]').children().eq(1).attr('src');
    $.ajax({
        type: 'POST',
        data: 'id=' + id + '&pic_path=' + pic_path,
        url: '{:U("del_Img")}',
        success: function(msg) {
            if (msg.error == 0) {
                $('div[data-id="' + id + '"]').remove();
            }
        }
    });
}