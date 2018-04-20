<?
// echo '<pre>';
// print_r($d);
// echo '</pre>';
?>

<table style="border:1px solid #888;width:100%">
	<tr>
		<th rowspan="3">No</th>
		<th rowspan="3">Pertanyaan</th>
		<th colspan="5">Jawaban</th>
	</tr>	
	<tr>
		<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th>
	</tr>	
	<tr>
		<th>Sangat Tidak Setuju</th>
		<th>Tidak Setuju</th>
		<th>Kurang Setuju</th>
		<th>Setuju</th>
		<th>Sangat Setuju</th>
	</tr>
	<?
	$x=1;
	foreach ($d as $k => $v) 
	{
	?>
	<tr>
		<td style="text-align:left;font-weight:bold;" colspan="7"><?=$k?></td>
	</tr>	
	<?
		foreach ($v as $kv => $vv) 
		{
			if(strpos($vv->question, 'Saran')!==false)
			{
		?>
		<tr>
			<td style="text-align:center;"><?=$x?></td>
			<td style="text-align:left;"><?=$vv->question?></td>
			<td style="text-align:center;" colspan="5">
				<textarea name="saran[<?=$vv->id?>]" style="width:95%;height:80px;padding:10px;"></textarea>
			</td>
		</tr>			
		<?		
			}
			else
			{
		?>

		<tr>
			<td style="text-align:center;"><?=$x?></td>
			<td style="text-align:left;"><?=$vv->question?></td>
			<td style="text-align:center;width:100px;"><input type="radio" name="pilihan[<?=$vv->id?>]" value="sts" style="display:inline;margin-left:40px !important;float:left"></td>
			<td style="text-align:center;width:100px;"><input type="radio" name="pilihan[<?=$vv->id?>]" value="ts" style="display:inline;margin-left:40px !important;float:left"></td>
			<td style="text-align:center;width:100px;"><input type="radio" name="pilihan[<?=$vv->id?>]" value="ks" style="display:inline;margin-left:40px !important;float:left"></td>
			<td style="text-align:center;width:100px;"><input type="radio" name="pilihan[<?=$vv->id?>]" value="s" style="display:inline;margin-left:40px !important;float:left"></td>
			<td style="text-align:center;width:100px;"><input type="radio" name="pilihan[<?=$vv->id?>]" value="ss" style="display:inline;margin-left:40px !important;float:left"></td>
		</tr>
		<?	# code...
			}
		$x++;
		}
	}
	// if($d['jenis']=='khusus')
	// {
	?>
	
	<?
	// }
	?>
</table>

<style type="text/css">
	table th
	{
		border:1px solid #888;
		background:#eee;
	}	
	table td
	{
		border:1px solid #888;
		/*background:#eee;*/
	}
</style>