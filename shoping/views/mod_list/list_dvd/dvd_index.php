<?php 
	echo $headerContent;
?>
<form id='fcari' onsubmit='return false;'>
<div id="list-dvd-nav" class="mfont ui-widget-content ui-corner-bl ui-corner-br">
		<input type="hidden" id="dvd-page" name="page" value="<?php echo $page;?>" />
		<input type="hidden" id="dvd-page-total" value="<?php echo $total_pages;?>" />
		<table border=0 cellspacing=0 cellpadding=0 width="100%">
		<tr align="center" valign="top">
			<td width="200">
				Kategori :
				<select id="kat_id" name="kat_id" class="ui-state-hover">
				<option value="0">[ SEMUA ]</option>
				<?php 
				if (isset($data_categories)):
					if ($data_categories->num_rows() > 0):
					foreach ($data_categories->result() as $rkat):
				?>
					<option value="<?php echo $rkat->kat_id?>" <?php echo ($rkat->kat_id == (isset($kat_id)?($kat_id):('')))?('SELECTED'):('')?>>[ <?php echo $rkat->kat_nama;?> ]</option>
				<?php
					endforeach;
					endif;
				endif;
				?>
				</select>
			</td>
			<td width="180">
				Judul :
				<input id="dvd_nama" name="dvd_nama" class="ui-state-hover" value="<?php echo (isset($dvd_nama))?($dvd_nama):('')?>"></td>
			</td>
			<td>
					<a class="pagina ui-icon ui-icon-seek-start"></a>
					<a class="pagina ui-icon ui-icon-seek-prev"></a>
					<a class="pagina selpage">[<?php echo $page;?>/<?php echo $total_pages;?>]</a>
					<a class="pagina ui-icon ui-icon-seek-next"></a>
					<a class="pagina ui-icon ui-icon-seek-end"></a>
			</td>
		</tr>
		</table>
</div>
</form>

<div id="dvd-box">
	<ul id="dvd-box-list" class="dvd-box-list ui-helper-reset ui-helper-clearfix">
  <?php 
  if (isset($data_dvd)):
    if ($data_dvd->num_rows() > 0):
    foreach ($data_dvd->result() as $row_dvd):
    ?>
    <li id="<?php echo $row_dvd->dvd_id?>" dvd_id=<?php echo $row_dvd->dvd_id?> kat_id="<?php echo $row_dvd->kat_id?>" class="dvd-tooltip ui-widget-content dvd-box-list-corner" alt="<?php echo $row_dvd->dvd_nama?>">
			<div class="judul ui-widget-header"><?php echo character_limiter($row_dvd->dvd_nama,10,' ...')?></div>
			<div class="dvd-preloader">
				<img style="opacity:0" src="<?php echo $this->config->item('asset_upload');?>thumb/<?php echo ($row_dvd->dvd_gambar)?($row_dvd->dvd_gambar):('na.png')?>" judul="<?php echo $row_dvd->dvd_nama?>" qtip-id="<?php echo $row_dvd->dvd_id?>"/>
			</div>
			<span class="rating"><img src="<?php echo "asset/images/stars/".$row_dvd->dvd_rating.".png";?>" width="50"/></span>
			<a href="javascript:void(0)" title="Order" class="ui-icon ui-icon-cart" onclick="add_to_cart(<?php echo $row_dvd->dvd_id?>)">Order</a>
		</li>
    <?php
    endforeach;
    endif;
  endif;
  ?>
  </ul>
</div>
