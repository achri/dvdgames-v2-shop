<?php echo $headerContent;?>
<div style="padding: 0 10px 0 10px">
	<table id="newapi_track" class="scroll"></table>
	<div id="pnewapi_track" class="scroll" style="text-align:center;"></div>
</div>

<?php if ($inv_code) {?>
<script language="javascript">
$(document).ready(function() {
	$('#inv_no').val('<?php echo $inv_code?>');
});
</script>
<?php } ?>