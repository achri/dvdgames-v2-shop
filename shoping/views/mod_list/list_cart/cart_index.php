<?php 
echo $headerContent;
if ($headerContent):
?>
<form id="fOrder" onSubmit="return false;">
<div id="tab-cart">
	<ul>
		<li><a href="index.php/<?php echo $link_controller;?>/info_pemesanan">1.Daftar Pemesanan</a></li>
		<li><a href="index.php/<?php echo $link_controller;?>/info_pengiriman">2.Info Pengiriman</a></li>
		<li><a href="index.php/<?php echo $link_controller;?>/info_pembayaran">3.Info Pembayaran</a></li>
	</ul>	
	<div align="center">
		<input class="ui-state-active" type="button" value="TAMBAH PESANAN" id="order-ubah" style="display:none">
		<input class="tab-nav ui-state-active" type="button" value="Lanjut Proses 2" id="next">
		<input class="ui-state-error" type="button" value="PEMBATALAN PESANAN" id="order-batal" style="display:none">
		<input type="submit" id="fOSubmit" style="display:none">
	</div>
</div>
</form>
<?php
endif;
?>