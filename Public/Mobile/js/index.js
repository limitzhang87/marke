/**
 * 首页JS文件
 * @type {Swiper}
 */

/*首页轮播图*/
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true
});
var swiper_mune = new Swiper('.swiper-container_mune', {
    pagination: '.swiper-pagination_mune',
    paginationClickable: true
});
var search_type = 1; //1：栋号搜索，2：单元搜索
//点击栋号显示搜索框
$('#search_b').on('click', function() {
    if ($('#search_input').hasClass('hide')) {
        $('#search_input').removeClass('hide');
        // $('#search_input input').css("width", "1px");
        $('#search_input input').animate({ width: '6rem' });
        //$('#search_input input').css("width", "100px");
    }
    search_type = 1;

});

//点击单元显示搜索框
$('#search_u').on('click', function() {
    if ($('#search_input').hasClass('hide')) {
        $('#search_input').removeClass('hide');
        // $('#search_input input').css("width", "1px");;
        $('#search_input input').animate({ width: '6rem' });
    }
    search_type = 2;
});

//搜索
$('#search').on('click', function() {
    if (!$('#search_input').hasClass('hide')) {
        var $kw = $('#search_kw').val();
        alert(search_type + ' ' + $kw);
    }
});