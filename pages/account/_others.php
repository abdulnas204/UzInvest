<div class="section_w500">
<div class="s-bk-lf">
	<div class="acc-title1">��������� �����</div>
</div>
<div class="silver-bk0"><div class="clr"></div>
<p><font color="black">� ���� �������� �� ������ ������ �������������� ������, ������� � ��� ��� ���� ���� ������� ���� ���� ����� �������� ��� ���.</font></p>
</div>
</div>
<br/>

<?PHP
$_OPTIMIZATION["title"] = "������� - ��������� �����";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

if(isset($_POST["item"])){
	if($_POST['item'] == 1) {
		$need_money = $sonfig_site["amount_gardener"];
		if($need_money <= $user_data["money_b"]) {
			if($user_data['gardener'] == 0) {
				if(isset($_POST['wm'])) {
					$type=2;
				}
				else
				{
					$type=1;
				}
				$time=time();
				$db->Query("UPDATE db_users_b SET money_b = money_b - $need_money WHERE id = '$usid'");
				$db->Query("UPDATE db_users_b SET gardener = 1 WHERE id = '$usid'");
				$db->Query("UPDATE db_users_b SET gardener_type = $type WHERE id = '$usid'");
				$db->Query("UPDATE db_users_b SET gardener_time = '$time' WHERE id = '$usid'");
				echo "<center><font color = 'green'><b>�� ������� ������ �������� �����</b></font></center><BR />";
				$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();
			} else echo "<center><font color = 'red'><b>�� ��� ������ �������� �����</b></font></center><BR />";
		} else echo "<center><font color = 'red'><b>������������ ������� ��� �������</b></font></center><BR />";
	}
}

?>
<div class="s-bk-lf">
	<div class="acc-title1">������� ����</div>
</div>
<div class="silver-bk0"><div class="clr"></div><center>
<div class="fr-block">
	<form action="" method="post">
	<div class="cl-fr-lf">
		<img src="/img/fruit/gardener.jpg" />
	</div>
	
	<div class="cl-fr-rg" style="padding-left:20px;">
		<div class="fr-te-gr-title"><font color="green"><b>��������� �1</b></font></div>
		<div class="fr-te-gr"><font color="green">������������:</font> <font color="#000000">1 ���.</font></div>
		<div class="fr-te-gr"><font color="green">���������:</font> <font color="#000000"><?=$sonfig_site["amount_gardener"]; ?> �������</font></div>
		<input type="hidden" name="item" value="1" />
		<?php
			if($user_data['gardener'] == 0) {
				echo '<input type="submit" name="wm" value="������ ��� WM" style="height: 30px; margin-top:10px;"> <input type="submit" name="pay" value="������ ��� Payeer" style="height: 30px; margin-top:10px;">';
			}
			else
			{
				echo '<font color="red">�� ��� ������ �������� �����!</font>';
			}
		?>
	</div>
	</form>
	</center>
	<h1>�������� - �������� ���������� ������� ��������� ������������ ���� ���������������� �� �������, ����� ��� ����� 1 ��� �� ����� ����� ������ �� ������������ ��� ��� ���� ����� �������� � ����, �������� �����, ��������� � �������� ��������. ������� ������� ��� ��� ��� �� ����� ������ ���� �������� � ����. ��� ���� ��� �� ������ �������� ����� �� ������ ������� ���� �� 1 ������� ��� ���� ��� �� ������� ��������������.</h1>

</div>
</div>
</div>
<div class="clr"></div>