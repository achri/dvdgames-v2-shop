<?php
if ($data_invoice->num_rows() > 0) {
	$row_inv = $data_invoice->row();
?>
<div id="info-transfer">
	<?php if(isset($status)) {?>
	<table width="670" cellpadding="2" cellspacing="1" border="0">
	<tr>
		<td>
			<h2>INVOICE No.<?php echo $row_inv->inv_code;?></h2>
		</td>
	</tr>
	<tr><td><hr width="670"/></td></tr>
	<tr>
		<td>Untuk tracking di website kami, silahkan klik link ini <a href="<?php echo base_url().'tracking/'.$row_inv->inv_code;?>" target="_blank"><?php echo base_url().'tracking/'.$row_inv->inv_code;?></a></td>
	</tr>
	</table>
	<br/>
	<?php } ?>
	<fieldset class="tfont ui-widget-content ui-corner-all">
		<legend class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Informasi Transfer &nbsp;</legend>
		<table width="670" class="tfont ui-widget-content" style="margin-left:15px;border:0">
			<tr valign="top">
				<td width="100%">
				  <?php 
					if (isset($data_bank)) {
						if ($data_bank->num_rows() > 0) {					
							foreach($data_bank->result() as $rbank) {
					?>
					<br>
					<fieldset class="tfont ui-widget-content ui-corner-tr">
						<legend class="ui-state-active ui-corner-tr ui-corner-br">&nbsp; Bank <?php echo $rbank->bank_nama;?> &nbsp;</legend>
						<table width="93%" class="tfont ui-widget-content" style="margin-left:15px;border:0">
							<tr valign="top">
								<td>Cabang</td><td>:</td>
								<td>
									<?php echo $rbank->bank_wilayah;?>
								</td>
								<td valign="middle" align="right" rowspan=3><img src="<?php echo base_url();?>asset/images/<?php echo strtolower($rbank->bank_gambar);?>" height="50px"/></td>
							</tr>
							<tr valign="top">
								<td width="20%">No Rek</td><td>:</td>
								<td>
									<?php echo $rbank->bank_rekening;?>
								</td>
							</tr>
							<tr valign="top">
								<td>Atas Nama</td><td>:</td>
								<td>
									<?php echo $rbank->bank_atas_nama;?>
								</td>
							</tr>
						</table>
					</fieldset>
					<?php	}
						}
					}?>
					<br/>
				</td>
			</tr>
		</table>
	</fieldset>	
	<br/>
	<!-- TEST -->
	<fieldset class="tfont ui-widget-content ui-corner-tr" style="padding: 10px">
		<legend class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Informasi Pemesanan &nbsp;</legend>
		<table width="680" cellpadding="2" cellspacing="1" border="0">
		<tbody valign="top">
			<tr>
				<td>
					<table width="100%" cellpadding="2" cellspacing="1" border="0">
						<thead>
							<tr>
								<td width="100px"><strong>No.Invoice</strong></td>
								<td width="5px">:</td>
								<td>
									<strong><?php echo $row_inv->inv_code;?></strong>
								</td>
								<td width="">&nbsp;</td>
								<td width="100px">Tanggal</td>
								<td width="5px">:</td>
								<td width="100px">
									<?php echo date_format(date_create($row_inv->inv_tgl),'d/m/Y');?>
								</td>
							</tr>
						</thead>
						<thead class="ui-state-default">
							<tr class="table-header">	
								<td align="center" colspan="7"><strong>Data Pemesan</strong></td>
							</tr>
						</thead>
						<tbody valign="top">
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td>
									<?php echo $row_inv->user_nama;?>
								</td>
								<td>&nbsp;</td>
								<td>FB Site</td>
								<td>:</td>
								<td>
									<?php echo ($row_inv->user_fb_site!='' ? "<a href='http://www.facebook.com/".$row_inv->user_fb_site."' target='_blank'>".$row_inv->user_fb_site."</a>":'');?>
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>:</td>
								<td>
									<?php echo $row_inv->user_email;?>
								</td>
								<td>&nbsp;</td>
								<td>No.Telp</td>
								<td>:</td>
								<td>
									<?php echo $row_inv->user_telp;?>
								</td>
							</tr>
							<tr>
								<td>Wilayah</td>
								<td>:</td>
								<td colspan="2"><?php echo $row_inv->sync_name;?></td>
								<td>PO-BOX</td>
								<td>:</td>
								<td>
									<?php echo $row_inv->user_pobox;?>
								</td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td colspan="4">
									<?php echo $row_inv->user_alamat;?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="2" cellspacing="1" border="0">
						<thead class="ui-state-default">
							<tr class="table-header">
								<td align="center" colspan="6"><strong>Rincian Transaksi</strong></td>
							</tr>
						</thead>
						<thead>
						<tr>
						<td colspan="6">
						<table width="100%" cellpadding="2" cellspacing="1" border="0">
						<?php 
						// EMAIL TEMPLATE
						if(isset($status)):?>
						<thead class="ui-widget-header">
							<tr align="center" valign="bottom"  class="table-header-sub">
								<td width="2%" rowspan=2>No.</td>
								<td width="30%" rowspan=2>Nama<br/>DVD Games</td>
								<td width="10%" rowspan=2>Order</td>
								<td width="20%" colspan=2>DVD</td>
								<td width="20%" rowspan=2>Harga</td>
							</tr>
							<tr align="center" valign="bottom" class="table-header-sub">
								<td width="10%">Jumlah</td>
								<td width="10%">Total</td>
							</tr>
						</thead>
						<tbody>
						<?php 
						if($dvd_detail->num_rows() > 0):
							$i = 1;
							foreach ($dvd_detail->result() as $row_dvd):
						?>
							<tr align="right" valign="top">
								<td><?php echo $i?>.</td>
								<td align="left"><?php echo $row_dvd->dvd_nama?></td>
								<td><?php echo $row_dvd->qty?></td>
								<td><?php echo $row_dvd->dvd_jumlah?></td>
								<td><?php echo $row_dvd->jml_dvd?></td>
								<td>Rp.<?php echo number_format($row_dvd->total_harga,2)?></td>
							</tr>
						<?php 
							$i++;
							endforeach;
						endif;?>
						</tbody>
						<tfoot>
							<tr class="table-footer" align="right" valign="top">
								<td colspan=2>Total &nbsp;&nbsp; : &nbsp;</td>
								<td><?php echo $row_inv->qty_total;?></td>
								<td>&nbsp;</td>
								<td><?php echo $row_inv->dvd_total;?></td>
								<td>Rp.<?php echo number_format($row_inv->dvd_harga,2);?></td>
							</tr>
							<tr class="table-footer" align="right" valign="top">
								<td colspan="4">Bonus Potongan &nbsp;&nbsp; : &nbsp;</td>
								<td><?php echo $row_inv->bonus_total;?></td>
								<td>Rp.<?php echo number_format($row_inv->bonus_harga,2);?></td>
							</tr>
							<tr class="table-footer" align="right" valign="top">
								<td colspan="5">Total Harga &nbsp;&nbsp; : &nbsp;</td>
								<td>Rp.<?php echo number_format($row_inv->grand_total,2);?></td>
							</tr>
						<tfoot>
						<?php 
						// INFORMASI INVOICE TEMPLATE
						else:?>
						<thead class="ui-widget-header">
							<tr class="table-header-sub" align="center" valign="bottom">
								<td width="20%" rowspan=2>Jumlah Pesanan<br/>DVD Games</td>
								<td width="30%" colspan=2>DVD</td>
								<td width="30%" colspan=2>Bonus DVD</td>
								<td width="20%" rowspan=2>Grand<br>Total</td>
							</tr>
							<tr class="table-header-sub" align="center" valign="bottom">
								<td width="10%">Total</td>
								<td width="20%">Harga</td>
								<td width="10%">Total</td>
								<td width="20%">Harga</td>
							</tr>
						</thead>
						<tbody>
							<tr class="ui-state-hover" align="right" valign="top">
								<td><?php echo $row_inv->qty_total;?></td>
								<td><?php echo $row_inv->dvd_total;?></td>
								<td>Rp.<?php echo number_format($row_inv->dvd_harga,2);?></td>
								<td><?php echo $row_inv->bonus_total;?></td>
								<td>Rp.<?php echo number_format($row_inv->bonus_harga,2);?></td>
								<td>Rp.<?php echo number_format($row_inv->grand_total,2);?></td>
							</tr>
						</tbody>
						<?php endif;?>
						</table>
						</td>
						</tr>
						</thead>
						<thead class="ui-state-default">
							<tr class="table-header">
								<td align="center"  colspan="6"><strong>Jasa Pengiriman (Tiki JNE)</strong></td>
							</tr>
						</thead>
						<tbody>
							<tr class="ui-state-hover" align="right" valign="top">
								<td colspan="4">
									<table width="100%" cellpadding="2" cellspacing="1" border="0">
										<tr class="ui-state-highlight" align="center" valign="top">
											<td>Wilayah</td>
											<td><?php echo $row_inv->sync_name;?></td>
											<td>Jenis Paket</td>
											<td><?php echo $row_inv->tiki_paket;?></td>
										</tr>
									</table>
								</td>
								<td class="ui-widget-header">Tarif &nbsp;</td>
								<td>Rp.<?php echo number_format($row_inv->tiki_tariff,2);?></td>
							</tr>
						</tbody>
						<thead class="ui-state-hover">
							<tr class="table-footer" valign="top" align="right">
								<td colspan="5">Total Keseluruhan &nbsp;&nbsp; : &nbsp;</td>
								<td>Rp.<?php echo number_format($row_inv->grand_total_all,2);?></td>
							</tr>
							<tr class="ui-state-default" valign="top" align="center">
								<td colspan="6"><i><h2><?php echo terbilang($row_inv->grand_total_all,2)?></h2></i><br/></td>
							</tr>
						</thead>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	</fieldset>
	<br>
	<fieldset class="tfont ui-widget-content ui-corner-tr" style="padding: 10px">
		<legend style="text-decoration: blink;" class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Informasi Penting &nbsp;</legend>
		<table width="680" cellpadding="2" cellspacing="1" border="0">
		<tbody valign="top">
			<tr>
				<td>
				<ul style="margin:0 0 0 20px;">
					<li>Setiap kelipatan 5 dari total pemesanan dvd mendapat gratis potongan harga 1 dvd.</li>
					<li>Berapa rupiah dari total keseluruhan biaya diatas bertujuan untuk system mengkonfirmasi transaksi dan transfer anda.</li>
					<li>Bila anda ingin mengkonfirmasi manual transer anda silahkan hubungi support kami atau melalui menu tracking.</li>
					<li>Untuk melihat status pengiriman silahkan masuk ke menu tracking.</li>
					<li>Transaksi yang belum dibayar akan dibatalkan secara otomatis setelah 5 hari oleh system.</li>
					<li>Pengiriman pesanan akan dilakukan pada malam hari.</li>
					<li>Konfirmasi Pembayaran khusus luar Kota yang melewati pukul 17:00wib (Senin-Jumat) dan pukul 15:00wib (Sabtu), pengiriman akan dilakukan pada hari berikutnya.</li>
					<li>Untuk nomor RESI TIKI dapat diakses melalui email atau website pada hari berikutnya.</li>
					<li>Kami tidak melayani pengembalian uang atas klaim keterlambatan pihak jasa pengiriman barang.</li>
					<li>Mohon dicatat No.Invoice Anda untuk tracking status pengiriman dan informasi pemesanan Anda.</li>
					<li>Silahkan hubungi kami jika ada pertanyaan dan bantuan.</li>
				</ul>
				</td>
			</tr>
			<?php if(!isset($status)) {?>
			<tr><td><hr/></td></tr>
			<tr>
				<td align="center">
					<input id="order-agree" class="ui-state-error" type="checkbox"/> Saya Setuju akan mengkonfirmasi pemesanan ini.
				</td>
			</tr>
			<?php } else {?>
			<tr><td><hr/></td></tr>
			<tr>
				<td align="left">
				Terima Kasih,<br/>
				www.dvdgames-online.com
				<br/><br/>
				</td>
			</tr>
			<tr>
				<td>Admin : <?php echo config('email_admin')?></td>
			</tr>
			<tr>
				<td>Sales : <?php echo config('email_sales')?></td>
			</tr>
			<?php } ?>
		</tbody>
	</fieldset>
</div>
<?php }?>