<?php
echo $extraContent;
if ($data_dvd->num_rows() > 0):
$row_dvd = $data_dvd->row();
?>
	<script language="javascript">
	$('.dvd-detail-preloader').preloader();
	$(function(){
		<?php if(config('youtube')):?>
		var start = 1; max = 20;
		var a = search_youtube('<?php echo $row_dvd->dvd_nama;?>',start,max); // this get a youtube video thumbnails with carousel 
		a = a/20;
		//$('#yt-page').text(a);
		<?php endif;?>
	});
	</script>

<table id='dvd_detail' cellspacing="0" cellpadding="0" border="0" width="500px" height="200px" style="margin: 5px;">
<tr>
  <td height="180px" width="155px" align="center" valign="middle" class="ui-widget-content dvd-detail-preloader" nowrap>
		<img style="opacity:0" height="200px" src="<?php echo $this->config->item('asset_upload');?>dvd/<?php echo ($row_dvd->dvd_gambar)?($row_dvd->dvd_gambar):('na.png')?>" title="<?php echo $row_dvd->dvd_nama?>" judul="<?php echo $row_dvd->dvd_nama?>"/>			
  </td>
  <td align="center" valign="top" style="padding:0 10px 0 10px;">
    <table cellspacing="2" cellpadding="2" border="0" width="100%" height="100%">
    <tr align="center" valign="top" class="dvd_item">
      <td colspan="3"><strong><?php echo $row_dvd->dvd_nama;?></strong></td>
    </tr>
    <tr>
      <td colspan="3" style="height:20px"><hr></td>
    </tr>
    <tr align="left" valign="top" class="tfont">
      <td width="70px">Jml. DVD</td>
      <td width="5px">&nbsp;:&nbsp;</td>
      <td><?php echo $row_dvd->dvd_jumlah;?> dvd</td>
    </tr>
    <tr align="left" valign="top" class="tfont">
      <td>Deskripsi</td>
      <td width="5px">&nbsp;:&nbsp;</td>
      <td><div style="overflow:auto; height:100px" class="tfont"><?php echo $row_dvd->dvd_review;?></div></td>
    </tr>
		<tr>
			<td colspan="3" align="right" valign="bottom">
				<table border="0" cellpadding="0" cellspacing="0" width="0">				
				<?php if ($row_dvd->cart_id): ?>
				<tr><td>
				<button class="drop-dvd ui-state-default" onclick="drop_dvd(<?php echo $row_dvd->cart_id.",".$row_dvd->dvd_id.",true"?>);$('.dvd-items-tooltips').qtip('hide');">Batal</button>
				</td></tr>
				<?php else: ?>
				<tr><td>
				<button class="add-to-cart ui-state-default" onclick="add_to_cart(<?php echo $row_dvd->dvd_id?>);$('.dvd-items-tooltips').qtip('hide');">Order</button>
				</td></tr>
				<?php endif;?>
				</table>
			</td>			
    </tr>
    </table>
  </td>
</tr>
<?php if(config('youtube')):?>
<tr>
	<td height="95px" colspan="2" align="center" valign="middle">
		<div id="youtube-container">
			<div class="youtube-carousel">
				<div class="youtube-auto-thumbnails"></div>
				<!--img id="youtube-waiting" style="margin:0 auto" src="asset/images/layout/progressbar_microsoft.gif"/-->
			</div>
		</div>
		<div id="yt-page"></div>
	</td>
</tr>
<?php endif;?>
</table>
<?php
endif;
?>