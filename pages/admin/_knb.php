<?php
$_OPTIMIZATION["title"] = "������� - ������-�������-������";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];

$knbItem[1] = '������';
$knbItem[2] = '�������';
$knbItem[3] = '������';
if(isset($_POST['del'])) {
	$del=intval($_POST['del']);
	$db->Query("SELECT * FROM `db_games_knb` WHERE `id` = ".$del);
	$row = $db->FetchArray();
	$db->Query("UPDATE `db_users_b` SET `money_b` = `money_b` + ".$row["summa"]." WHERE `user`  = '".$row["login"]."'");
	$db->Query("DELETE FROM `db_games_knb` WHERE `id` = ".$del);
	$deleted=1;
}
if(isset($_POST['del2'])) {
	$del=intval($_POST['del2']);
	$db->Query("DELETE FROM `db_games_knb` WHERE `id` = ".$del);
	$deleted=1;
}
?>
<div class="s-bk-lf">
	<div class="acc-title">����� ������� ���</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?php
$db->Query("SELECT * FROM `db_games_knb` WHERE `last`='0' ORDER BY `id`");
if($deleted) {
	echo '<font color="red">�������!</font><br/>';
}
if($db->NumRows() == 0){
	echo '<ul><li>��� ���</li></ul>';
}
else
{
?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
<?php
	echo '<tr>';
	echo '<td class="m-tb" align="center">�����</td>';
	echo '<td class="m-tb" align="center">�� ������������</td>';
	echo '<td class="m-tb" align="center">�������</td>';
	echo '</tr>';
	while($row = $db->FetchArray()){
	echo "<div id='play-".$row["id"]."'>
	<tr class='htt'>
	<td align='center'>".$row["summa"]."</td>
	<td align='center'>".htmlspecialchars($row["login"])."</td>
	<td align='center'>
	<form action='' method='post'>
	<input type='hidden' name='del' value=".$row['id']." />
	<input type='submit' value='�������' />
	</form>
	</td></tr></div>";
	}
	echo '</table>';
}
?>
</div>
<br/><br/>
<div class="s-bk-lf">
	<div class="acc-title">����� ����������</div>
</div>
<div class="silver-bk"><div class="clr"></div>
<?php
$db->Query("SELECT * FROM `db_games_knb` WHERE `last`='1' ORDER BY `id`");
if($db->NumRows() == 0){
	echo '<ul><li>��� ���</li></ul>';
}
else
{
?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
<?php
	echo '<tr>';
	echo '<td class="m-tb" align="center">�����</td>';
	echo '<td class="m-tb" align="center">�� ������������</td>';
	echo '<td class="m-tb" align="center">������</td>';
	echo '<td class="m-tb" align="center">�������</td>';
	echo '</tr>';
	while($row = $db->FetchArray()){
	echo "<div id='play-".$row["id"]."'>
	<tr class='htt'>
	<td align='center'>".$row["summa"]."</td>
	<td align='center'>".htmlspecialchars($row["login"])."</td><td align='center'>";
	if($row['win']==1) {
		echo '<font color="red">���������</font>';
	}
	else if($row['win']==2) {
		echo '<font color="blue">�����</font>';
	}
	else if($row['win']==3) {
		echo '<font color="green">������</font>';
	}
	echo "</td><td align='center'>
	<form action='' method='post'>
	<input type='hidden' name='del2' value=".$row['id']." />
	<input type='submit' value='�������' />
	</form>
	</td></tr></div>";
	}
	echo '</table>';
}
?>
</div>