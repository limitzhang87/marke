<?php if (!defined('THINK_PATH')) exit();?>
<span id="houses_span"><?php echo ($houses_title); ?></span> 
<input type="hidden" name="houses_id" id="houses_id" value="<?php echo ((isset($param["houses_id"]) && ($param["houses_id"] !== ""))?($param["houses_id"]):''); ?>"/>
<a  class="btn btn_map selectImg_map" data-event="houses">选择楼盘</a>


<link rel="stylesheet" href="/marke/Public/static/plugins/artDialog/css/ui-dialog.css" />
<script src="/marke/Public/static/plugins/artDialog/dist/dialog-plus.js"></script>
<script src="/marke/Public/static/plugins/artDialog/lib/sea.js"></script>

<script>
	$('a[data-event=houses]').on('click', function () {
		dialog({
			id: 'test-dialog',
			title: '楼盘选择',
			width: '900px',
			url: '<?php echo addons_url("HousesDialog://HousesDialog/HousesSelect",$param);?>&houses_id_new='+$('#houses_id').val(),
			//quickClose: true,
			onshow: function () {
				console.log('onshow');
			},
			oniframeload: function () {
				console.log('oniframeload');
			},
			onclose: function () {
				var houses_arr=this.returnValue.split("|");
				if(this.returnValue){
					 $('#houses_id').val(houses_arr[0]);
					 $('#houses_span').html(houses_arr[1]);
				}
				console.log('onclose');
			},
			onremove: function () {
				console.log('onremove');
			}
		})
		.showModal();
		return false;
	});
</script>