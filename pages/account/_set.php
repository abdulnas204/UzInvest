<?PHP
$_OPTIMIZATION["title"] = "������";
$_OPTIMIZATION["description"] = "������ �������";
?>
<div class="s-bk-lf">
	<div class="acc-title">������ �������</div>
</div>
<div class="silver-bkpay">
<table style="border-collapse:collapse;width:100%;"><tbody><tr align="center"><td>
<img src="http://hyip-investment.ru/bonus/p_b_1.png" alt="" style="width:200px;"><br></td><td>

<img src="http://hyip-investment.ru/bonus/p_b_4.png" alt="" style="width:200px;"><br></td></tr></tbody></table><br>
<div class="clr"></div>		
</div><br>
<div class="s-bk-lf">
	<div class="acc-title">WM SET</div>
</div>
<div class="silver-bk">
<b>WM SET - ��� ���������� ��������, ������� ������ ������������ ��� ���������� �������. <BR /></b>
WM SET ����������� � �������������� ������ ����� ������� ���������� �������. �������� ����� �������� ������ 1 WM SET �� 1 ����������.<BR />
<BR />
<b><font color = "red">�����:</font> ������� ������ ��� �����! � ��� �� ���������� ����������� �����.</b> 
<div class="clr"></div>		
</div>
<BR />

<div class="silver-bk">
<b><center>�������� ���������� �����</center></b><BR />
<form action="" method="post">
	
	<center>����������� �����: <input type="text" name="sum" value="<?=(isset($_POST["sum"])) ? intval($_POST["sum"]) : 100;?>" />
	<BR /><BR />
	<input type="submit" value="��������� �����">
	</center>
	
</form>
<div class="clr"></div>		
</div>

<?PHP
$wmset = new wmset();

if(isset($_POST["sum"])){

$insum = (intval($_POST["sum"]) > 0 AND intval($_POST["sum"]) <= 100000) ? intval($_POST["sum"]) : 0;

$marray = $wmset->GetSet($insum);



?>
<BR /><BR />
<div class="silver-bk">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" align="center" style="padding:5px;"><b>��� ���������� �� ����� <?=$insum; ?> RUB �� ��������� ��������:</b></td>
    </tr>
  <tr>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/lime-small.jpg" /> +<?=$marray["t_a"];?> ��.</div></td>
	<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/cherry-small.jpg" /> +<?=$marray["t_b"];?> ��.</div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/strawberries-small.jpg" /> +<?=$marray["t_c"];?> ��.</div></td>
	<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/kiwi-small.jpg" /> +<?=$marray["t_d"];?> ��.</div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/peach-small.jpg" /> +<?=$marray["t_e"];?> ��.</div></td>

    
  </tr>
</table>

<BR />
<div class="clr"></div>		
</div>

<?PHP
return;

}

$array = $wmset->SetsList();
	
	
	foreach($array as $index => $marray){
	
	?>
	<BR /><BR />
<div class="silver-bk">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" align="center" style="padding:5px;"><b>��� ���������� <?=$marray["desc"];?> �� ��������� ��������:</b></td>
    </tr>
  <tr>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/lime-small.jpg" /> +<?=$marray["t_a"];?> ��.</div></td>
	<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/cherry-small.jpg" /> +<?=$marray["t_b"];?> ��.</div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/strawberries-small.jpg" /> +<?=$marray["t_c"];?> ��.</div></td>
	<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/kiwi-small.jpg" /> +<?=$marray["t_d"];?> ��.</div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/peach-small.jpg" /> +<?=$marray["t_e"];?> ��.</div></td>


    
  </tr>
</table>

<BR />
<div class="clr"></div>		
</div>
	
	<?PHP
	
	}
	
?>