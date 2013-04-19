<?php
if ($data_current_cart->num_rows() > 0):
?>
<div style="height:98px; overflow: auto">
	<table id="cart-items" width="100%" class="dvd-font-m cart-selectable" cellpadding=0 cellspacing=0 border=0>
	<?php
		foreach ($data_current_cart->result() as $row_cart):
	?>
		<tr valign="top" id="<?php echo $row_cart->cart_id.'|'.$row_cart->dvd_id?>" qtip-id="<?php echo $row_cart->dvd_id?>" alt="<?php echo $row_cart->dvd_nama?>">
			<td><?php echo character_limiter($row_cart->dvd_nama,11,'...')?></td>
			<td width="12px" align="right"><strong><?php echo $row_cart->qty?></strong>[<?php echo $row_cart->dvd_jumlah?>dvd]</td>
			<!--td width="20px" align="right">
				<a id="<?php echo $row_cart->dvd_id?>" href="javascript:void(0)" onclick="drop_dvd(<?php echo $row_cart->cart_id?>,<?php echo $row_cart->dvd_id?>,true);" class="drop_item">
					<img src="asset/images/icons/trash.png"/>
				</a>
			</td-->
		</tr>
	<?php
		endforeach;
	?>
	</table>
</div>
<hr class="ui-state-hover" height="5px"/>
<div>
	<table class="dvd-font-t" width="100%" cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td width="70px">Total</td>
			<td width="10px">:</td>
			<td><?php echo $cart_summary->row()->tot_dvd;?> DVD</td>
			<td>&nbsp;</td>
			<td align="right"><a href="#" onclick="menu_go(2)">detail</a></td>
		</tr>
		<tr>
			<td>Bonus</td>
			<td>:</td>
			<td><?php echo $cart_summary->row()->bonus_dvd;?> DVD</td>
			<td>&nbsp;</td>
			<td align="right"><a href="#" onclick="load_cart()">refresh</a></td>
		</tr>
		<tr>
			<td>Harga+Bonus</td>
			<td>:</td>
			<td>Rp.<?php echo number_format($cart_summary->row()->tot_harga,2);?></td>
			<td>&nbsp;</td>
			<td align="right"><a href="#" onclick="load_cart()">clear</a></td>
		</tr>
	</table>
</div>
<?php
else:
?>
	<table height=" 100%" width="100%" class="cart-selectable" cellpadding=0 cellspacing=0 border=0><tr><td valign="middle" align="center">Belum ada Pesanan.</td></tr></table>
<?php 
endif;?>