<div class="s-bk-lf">
	<div class="acc-title">������ ������ �� Payeer</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?


$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

function colorSum($sum){

	if($sum >= 100) return "red";
	return "#000000";
}

if(isset($_POST['pay_here']) && is_numeric($_POST['pay_here'])) {
	$payed=$_POST['pay_here'];
	$db->Query("SELECT * FROM `db_request_payment` WHERE `id` = '$payed' AND `status` = '0' LIMIT 1 ");
	if($db->NumRows() > 0){
		//�����������
		$db->Query("SELECT * FROM `db_request_payment` WHERE `id` = '$payed' AND `status` = '0' LIMIT 1 ");
		$paydata = $db->FetchArray();
		$sum_pay = $paydata['sum'];
		$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
		if($payeer->isAuth()) {
		$arBalance = $payeer->getBalance();
		$purse = $paydata['purse'];
		$usid = $paydata['user_id'];
		$usname = $paydata['user'];
		$paymentid = $paydata['payment_id'];
		if($arBalance["auth_error"] == 0) {
			$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
			if($balance >= $sum_pay){
									$arTransfer = $payeer->transfer(array(
									'curIn' => 'RUB', // ���� ��������
									'sum' => $sum_pay, // ����� ���������
									'curOut' => 'RUB', // ������ ���������
									'to' => $purse, // ���������� (email)
									//'to' => '+71112223344',  // ���������� (�������)
									//'to' => 'P1000000',  // ���������� (����� �����)
									'comment' => iconv('windows-1251', 'utf-8', "������� ������������ {$usname} � ������� Money-Ferma.RU")
									//'anonim' => 'Y', // ��������� �������
									//'protect' => 'Y', // ��������� ������
									//'protectPeriod' => '3', // ������ ��������� (�� 1 �� 30 ����)
									//'protectCode' => '12345', // ��� ���������
									));
				if (!empty($arTransfer["historyId"])) {
					$ppid = $arTransfer["historyId"];
					$db->Query("UPDATE  db_request_payment SET status = '3' WHERE id = '$payed'");
					$db->Query("UPDATE  db_payment SET status = '3' WHERE id = '$paymentid'");
					$db->Query("UPDATE  db_payment SET payment_id = '$ppid' WHERE id = '$paymentid'");
				} else echo '������ 4';
			} else echo '������ 3';
		} else echo '������ 2';
		} else echo '������ 1';
	} else echo '������ 0';
}
else if(isset($_POST['canc'])) {
	$payid = intval($_POST['canc']);
	$db->Query("SELECT * FROM `db_request_payment` WHERE `id` = '$payid' AND `status` = '0' LIMIT 1 ");
	if($db->NumRows() > 0){
		$paydata = $db->FetchArray();
		$usid = $paydata['user_id'];
		$db->Query("SELECT * FROM db_payment WHERE id = $paydata[payment_id] ");
		$tmpresid = $db->FetchArray();
		$sum = $tmpresid['serebro'];
		$db->Query("UPDATE db_users_b SET money_p = money_p + '$sum' WHERE id = '$usid'");
		$db->Query("UPDATE  db_request_payment SET status = '2' WHERE id = '$payid'");
		$paymentid = $paydata['payment_id'];
		$db->Query("UPDATE  db_payment SET status = '2' WHERE id = '$paymentid'");
	}
}

$db->Query("SELECT * FROM db_request_payment ORDER BY id DESC LIMIT {$lim}, 100");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb">������������</td>
	<td align="center" width="50" class="m-tb">�����</td>
	<td align="center" width="50" class="m-tb">�������</td>
	<td align="center" width="50" class="m-tb">���������</td>
	<td align="center" width="50" class="m-tb">��������</td>
	<td align="center" width="100" class="m-tb">����</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
	<td align="center"><a href="/?menu=admin384&sel=users&edit=<?=$data["user_id"]; ?>"<?php if($data['gardener']==1) {echo ' style="color: red;"';}  ?> class="stn"><?=$data["user"]; ?></a></td>
    <td align="center"><font color="<?=colorSum($data["sum"]); ?>"><?=sprintf("%.2f",$data["sum"]); ?> RUB</font></td>
	<td align="center"><?=$data["purse"]; ?></td>
	<td align="center">
	<?php
		if($data["status"]==0) {
	?>
	<form action="" method="post">
	<input type="hidden" name="pay_here" value="<?=$data["id"]; ?>" />
	<input type="submit" value="���������" />
	</form>
	<?php
	}
	else if($data["status"]==3) {
		echo "<center><font color = 'green'><b>���������!</b></font></center><BR />";
	}
	else if($data["status"]==2) {
		echo "<center><font color = 'red'><b>��������!</b></font></center><BR />";
	}
	?>
	</td>
	<td align="center">
	<?php
		if($data["status"]==0) {
	?>
	<form action="" method="post">
	<input type="hidden" name="canc" value="<?=$data["id"]; ?>" />
	<input type="submit" value="��������" />
	</form>
	<?php
	}
	else if($data["status"]==3) {
		echo "<center><font color = 'green'><b>���������!</b></font></center><BR />";
	}
	else if($data["status"]==2) {
		echo "<center><font color = 'red'><b>��������!</b></font></center><BR />";
	}
	?>
	</td>
	<td align="center"><?=date("d.m H:i:s",$data["date"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>�� ������ �������� ��� �������</b></center><BR />";

	
$db->Query("SELECT COUNT(*) FROM  db_request_payment");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/?menu=admin384&sel=payments_req&page="), "</center>";
	
	}
?>
</div><div class='clr'></div>
