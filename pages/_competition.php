<?PHP
$_OPTIMIZATION["title"] = "������� ���������";
$_OPTIMIZATION["description"] = "������� ���������";
$_OPTIMIZATION["keywords"] = "�������, ������� ���������";
?>
<div class="s-bk-lf">
	<div class="acc-title">������� ���������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<center><a href="/competition" class="stn">������� ��������</a> || <a href="/competition/list" class="stn">�����������</a></center><BR />
<?PHP

# ������ ���������
if(isset($_GET["list"])){


	# ������ �������������
	$db->Query("SELECT * FROM db_competition WHERE status > 0");
	if($db->NumRows() > 0){
	
	?>
	
	
	<?PHP
		while($data = $db->FetchArray()){
		
		?>
			<table width="99%" border="0" align="center">
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">ID</td>
				<td align="center" class="m-tb">�����</td>
				<td align="center" class="m-tb">��������</td>
				<td align="center" class="m-tb">����</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=$data["id"]; ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_add"]); ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_end"]); ?></td>
				<td align="center"><?=$data["1m"]+$data["2m"]+$data["3m"]; ?> RUB</td>
		 	</tr>
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">������</td>
				<td align="center" class="m-tb">1 ����� / ����</td>
				<td align="center" class="m-tb">2 ����� / ����</td>
				<td align="center" class="m-tb">3 ����� / ����</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=($data["status"] > 1) ? "�������" : "��������"; ?></td>
				<td align="center"><?=$data["user_1"]; ?> / <?=$data["1m"]; ?></td>
				<td align="center"><?=$data["user_2"]; ?> / <?=$data["2m"]; ?></td>
				<td align="center"><?=$data["user_3"]; ?> / <?=$data["3m"]; ?></td>
		 	</tr>
			</table>
		<BR /><BR />
		<?PHP
		}

	}else echo "<center><b><font color = 'red'>��� ����������� ���������</font></b></center><BR />";


?>
</div>
<div class="clr"></div>	
<?PHP

return;
}


$db->Query("SELECT * FROM db_competition WHERE status = 0 LIMIT 1");
if($db->NumRows() == 1){
$comp = $db->FetchArray();	
	?>
<b>������� ��������� � <?=$comp["id"]; ?> � ����� �������� ������ <?=$comp["1m"]+$comp["2m"]+$comp["3m"]; ?> RUB<BR /><BR />
����� ��������: <?=date("d.m.Y � H:i:s", $comp["date_add"]); ?> <BR />����������: <?=date("d.m.Y � H:i:s", $comp["date_end"]); ?>
<BR /><BR />
<u>�������� �����:</u><BR />
<font color="red">1 - <?=$comp["1m"]; ?> RUB</font> <BR />
<font color="red">2 - <?=$comp["2m"]; ?> RUB</font> <BR />
<font color="red">3 - <?=$comp["3m"]; ?> RUB</font> <BR /><BR />
<b><font color=red>����� �������� �� ���� ��� �������.</font></b><br>
� �������� ����������� ������ �������� ��������, ������� ������������������ ����� ������� ��������. <BR ><BR />
����� ������ �� ���������� ���������� 1��� = 1����<BR ><BR />
<font color=red>���������� ���������� ������ ��� �������: 20 ������!</font><BR ><BR />
</b>
	<?PHP
	
	# ������ �������������
	$db->Query("SELECT * FROM db_competition_users ORDER BY points DESC LIMIT 10");
	if($db->NumRows() > 0){
	
	?>
	<center><h1><b>������� �������</b></h1></center>
<table width="99%" border="0" align="center">
  <tr bgcolor="#efefef">
    <td align="center" width="75" class="m-tb"><b>�������</b></td>
    <td align="center" class="m-tb"><b>������������</b></td>
    <td align="center" class="m-tb"><b>������</b></td>
	<td align="center" class="m-tb"><b>����</b></td>
  </tr>
	<?PHP
		$position = 1;
		while($data = $db->FetchArray()){
		
		?>
			<tr class="htt" >
				<td align="center" width="75"><?=$position; ?></td>
				<td align="center"><b><?=$data["user"]; ?></b></td>
				<td align="center"><b><font color="green"><?=sprintf("%.0f",$data["points"]); ?></font></b></td>
				<td align="center"><font color="red"><?=(intval($comp["{$position}m"]) > 0) ? $comp["{$position}m"]." RUB" : "-" ?></font></td>
		 	</tr>
		<?PHP
		$position++;
		}
	
	?>
</table>
<BR />
	<?PHP
	
	}else echo "<center><b><font color = 'red'>��� ���������� � ��������</font></b></center><BR />";

}else echo "<center><b><font color = 'red'>� ������ ������ ������� �� ����������</font></b></center><BR />";

?>
</div>
<div class="clr"></div>	