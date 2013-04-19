<?php echo $extraContent;?>
<script language="javascript">$('#destination').focus();</script>

<div style="display: table; width: 100%;">
<fieldset class="tfont ui-widget-content ui-corner-tr" style="padding: 10px; float: left; width:380px">
	<legend class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Tujuan Pengiriman &nbsp;</legend>
	<table width="100%">
	<tbody valign="top">
		<tr>
			<td width="100px">Wilayah</td>
			<td width="5px">:</td>
			<td>
				<input type="hidden" id="origin_code" name="from" value="QkRPMTAwMDBK">
				<input type="text" id="destination" name="to" class="inputcheck ac_input autosave ui-state-hover" qtip-pos="top" value="<?php if (fb_user('location,name')) echo fb_user('location,name');?>" autocomplete="off" style="width:200px">
				<input type="hidden" id="destination_code" name="to_code" class="autosave-hidden">
				<input type="hidden" id="weight" name="weight" value="1" class="inputcheck">
				<span class="cek-tariff" style="display:none;text-decoration: blink;">&nbsp; Cek tarif</span>
			</td>
		</tr>
		<tr>
			<td>Jenis Paket</td>
			<td>:</td>
			<td>
				<input type="hidden" id="sync_id" name="order[wilayah][sync_id]"/>
				<select name="order[wilayah][tariff]" id="jenis_paket" class="ui-state-hover autosave" qtip-pos="bottom" style="width:200px">
					<option value=""></option>
				</select>
				<span class="cek-tariff" style="display:none;"><img src="asset/images/layout/spin4.gif" height="18px" style="margin-bottom: -5px;"/></span>
			</td>
		</tr>
		<tr>
			<td colspan="3">Daftar tarif langsung dari <a href="http://www.jne.co.id" target="_blank">www.jne.co.id</a></td>
		</tr>
	</tbody>
	</table>
</fieldset>

<fieldset class="tfont ui-state-highlight ui-corner-tr" style="padding: 10px; float: right; width: 260px;">
	<legend class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Jasa Pengiriman &nbsp;</legend>
	<table width="100%" height="100%"><tr><td valign="middle" align="center">
	<a href="http://www.jne.co.id" target="_blank"><img src="asset/images/tikijne.png" title="Daftar tarif legal dan sessuai dari www.jne.co.id" height="70px"/></a>
	</td></tr></table>
</fieldset>	

</div>
<br/>

<fieldset class="tfont ui-widget-content ui-corner-tr" style="padding: 10px;">
	<legend class="ui-state-hover ui-corner-tr ui-corner-br">&nbsp; Data Pemesan &nbsp;</legend>
	<table width="100%">
	<tbody valign="top">
		<tr>
			<td width="120px">Nama Lengkap</td>
			<td width="5px">:</td>
			<td>
				<input id="user_fuid" type="hidden" name="order[info][user_fuid]" value="<?php echo fb_user('id');?>"/>
				<input id="user_fb_site" type="hidden" name="order[info][user_fb_site]" value="<?php echo fb_user('username');?>"/>
				<input class="ui-state-hover autosave" id="user_nama" type="text" name="order[info][user_nama]" value="<?php echo fb_user('name');?>"/>
			</td>
			<td width="90px">&nbsp;</td>
			<td width="120px">No.Telp</td>
			<td width="5px">:</td>
			<td>
				<input id="user_telp" class="ui-state-hover autosave" type="text" name="order[info][user_telp]"/>
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>
				<input id="user_email" class="ui-state-hover autosave" type="text" name="order[info][user_email]" value="<?php echo fb_user('email');?>"/>
			</td>
			<td>&nbsp;</td>
			<td>PO.BOX</td>
			<td>:</td>
			<td>
				<input id="user_pobox" class="ui-state-hover autosave" type="text" name="order[info][user_pobox]"/>
			</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td>
				<textarea id="user_alamat" class="ui-state-hover autosave" name="order[info][user_alamat]" style="width: 196px !important;" rows="1" qtip-pos="bottom"></textarea>
			</td>
			<td>&nbsp;</td>
			<td>Keterangan</td>
			<td>:</td>
			<td>
				<textarea id="user_keterangan" class="ui-state-hover autosave" name="order[wilayah][keterangan]" style="width: 196px !important;" rows="1" qtip-pos="bottom"></textarea>
			</td>
		</tr>
	</tbody>
	</table>
</fieldset>
