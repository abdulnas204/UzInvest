<div class="s-bk-lf">
	<div class="acc-title">������������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?PHP
# ���������� ������� + ���� � �������

if(isset($_GET['ochar'])) {
	if(!empty($_POST['ocharlogin']) && !empty($_POST['ocharsum'])) {
		if(preg_match('#[a-z0-9]{4,10}#si', $_POST['ocharlogin'])) {
			if(is_numeric($_POST['ocharsum']) && $_POST['ocharsum']>1) {
				$db->Query("SELECT * FROM db_users_a WHERE user = '$_POST[ocharlogin]' ");
				if($db->NumRows() > 0) {
					# ��������� ������
						$db->Query("SELECT id FROM db_users_a WHERE user = '$_POST[ocharlogin]' ");
						$tmpdata = $db->FetchArray();
						$eid = $tmpdata['id'];
						$ename = $tmpdata['user'];
						$limitPercent=50; # ������� ������
						$rub=intval($_POST['ocharsum']);
						$sum = $rub*135;
						$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
						$data=$db->FetchArray();
						if(intval($data["insert_sum"])<=0.01){$sum=$sum+$sum*0.10;} // ���� ������ - +20% �����
						$db->Query("UPDATE db_users_b SET money_b = money_b + {$sum} WHERE id = '$eid'");
						$db->Query("UPDATE db_users_b SET insert_sum = insert_sum + {$rub} WHERE id = '$eid'");
						$newlimit=(intval($data["insert_sum"])+$rub)*$limitPercent/100;
						$db->Query("UPDATE db_users_b SET curlimit = '$newlimit' WHERE id = '$eid'");
						$refstr="";
						if(!empty($data["referer"])) {
							$rid=$data["referer_id"];
							$rname=$data["referer"];
							$rsum=$sum*0.01;
							$db->Query("UPDATE db_users_b SET money_b = money_b + {$rsum} WHERE id = '$rid'"); // + 20% ��������
						
							$db->Query("UPDATE db_users_b SET to_referer = to_referer + {$rsum} WHERE id = '$eid'"); // + � ��� �����
							$db->Query("UPDATE db_users_b SET from_referals = from_referals + {$rsum} WHERE id = '$rid'"); // + � ��� ��������
							
							
								# ��������� ���� �� ������������ � ��������
				
				$db->Query("SELECT COUNT(*) FROM db_competition_users WHERE user_id = '{$rid}'");
				if($db->FetchRow() == 1){
				
					$db->Query("UPDATE db_competition_users SET points = points + '{$rub}' WHERE user_id = '{$rid}'");
				
				}else $db->Query("INSERT INTO db_competition_users (user, user_id, points) VALUES ('{$rname}','{$rid}','$rub')");
							//$db->Query("UPDATE db_competition_users SET points = points + {$rub} WHERE user_id = '$rid'"); // + � ������� ���������
							//$db->Query("UPDATE db_users_b SET from_referals = from_referals + {$rsum} WHERE id = '$rid'"); // + � ��� ��������
							$refstr=", ������� $rname ������� $rsum ������� � 1 ������";
						}
						
						$db->Query("UPDATE db_users_b SET money_b = money_b, money_p = money_p, last_sbor = '$lsb' WHERE id = '$eid'");
						$wmsetstr = ", ����� �� ������� WM set ".$marray["desc"];
						$competition = new competition($db);
						$competition->UpdatePoints($rid, $rub);
						$string = "������������ ��������� {$sum} �������".$wmsetstr.$refstr;
						$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
						$da = time();
						$dd = $da + 60*60*24*15;
						$db->Query("INSERT INTO db_insert_money (user, user_id, money, serebro, date_add, date_del) 
						VALUES ('$ename','$eid','$rub','$sum','$da','$dd')");
						echo "<center><b>$string</b></center><BR />";
				}
			}
		}
	}
}

# �������������� ������������
if(isset($_GET["edit"])){

$eid = intval($_GET["edit"]);

$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");

# ��������� �� �������������
if($db->NumRows() != 1){ echo "<center><b>��������� ������������ �� ������</b></center><BR />"; }

# ��������� ������
if(isset($_POST["set_tree"])){
if(preg_match('#[a-g]{1}+_t#', $_POST["set_tree"])) {
	$tree = $_POST["set_tree"];
	$type = ($_POST["type"] == 1) ? "-1" : "+1";

	$db->Query("UPDATE db_users_b SET {$tree} = {$tree} {$type} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>������ ���������</b></center><BR />";
	}
	else
	{
		echo "<center><b>������� �� ��������</b></center><BR />";
	}
}


# ��������� ������
if(isset($_POST["opt_bal"]) AND !empty($_POST["sum"])){

$sum = intval($_POST["sum"]);
$bal = $_POST["schet"];
$type = ($_POST["balance_set"] == 1) ? "-" : "+";

$string = ($type == "-") ? "� ������������ ����� {$sum} �������" : "������������ ��������� {$sum} �������";

	$db->Query("UPDATE db_users_b SET {$bal} = {$bal} {$type} {$sum} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>$string</b></center><BR />";
	
}

//var_dump($_POST);die();

# �������������� #KURS belgilash #BONUS
if(isset($_POST["auto_bal"]) AND !empty($_POST["a_sum"]))
{
	$limitPercent=50; # ������� ������
	
	$rub=intval($_POST["a_sum"]);$sum = $rub*145;
	$data=$db->FetchArray();
	if(intval($data["insert_sum"])<=0.01){$sum=$sum+$sum*0.10;} // ���� ������ - +10% �����

	$db->Query("UPDATE db_users_b SET money_b = money_b + {$sum} WHERE id = '$eid'");
	$db->Query("UPDATE db_users_b SET insert_sum = insert_sum + {$rub} WHERE id = '$eid'");
	

	$newlimit=(intval($data["insert_sum"])+$rub)*$limitPercent/100;
	$db->Query("UPDATE db_users_b SET curlimit = '$newlimit' WHERE id = '$eid'");
	$refstr="";
	if(!empty($data["referer"]))
	{
		$rid=$data["referer_id"];$rname=$data["referer"];$rsum=$sum*0.05; // +5% referalga
		$db->Query("UPDATE db_users_b SET money_b = money_b + {$rsum} WHERE id = '$rid'"); // + 1% ��������
		$db->Query("UPDATE db_users_b SET to_referer = to_referer + {$rsum} WHERE id = '$eid'"); // + � ��� �����
		$db->Query("UPDATE db_users_b SET from_referals = from_referals + {$rsum} WHERE id = '$rid'"); // + � ��� ��������
		
			
								# ��������� ���� �� ������������ � ��������
				
				$db->Query("SELECT COUNT(*) FROM db_competition_users WHERE user_id = '{$rid}'");
				if($db->FetchRow() == 1){
				
					$db->Query("UPDATE db_competition_users SET points = points + '{$rub}' WHERE user_id = '{$rid}'");
				
				}else $db->Query("INSERT INTO db_competition_users (user, user_id, points) VALUES ('{$rname}','{$rid}','$rub')");
							//$db->Query("UPDATE db_competition_users SET points = points + {$rub} WHERE user_id = '$rid'"); // + � ������� ���������
							//$db->Query("UPDATE db_users_b SET from_referals = from_referals + {$rsum} WHERE id = '$rid'"); // + � ��� ��������
		
		$refstr=", ������� $rname ������� $rsum �������";
	}

	$string = "������������ ��������� {$sum} �������".$refstr;
	
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>$string</b></center><BR />";
}

# INSERT_SUM
if(isset($_POST["i_bal"]) AND !empty($_POST["i_sum"]))
{
	$rub=intval($_POST["i_sum"]);
	$db->Query("UPDATE db_users_b SET insert_sum = insert_sum + {$rub} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>INSERT SUCCESS!</b></center><BR />";
}

# �������� ������������
if(isset($_POST["banned"])){

	$db->Query("UPDATE db_users_a SET banned = '".intval($_POST["banned"])."' WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>������������ ".($_POST["banned"] > 0 ? "�������" : "��������")."</b></center><BR />";
	
}

if(isset($_POST['plat_pass'])) {
/*
function pl_pas($pl_pas){
		if(!preg_match("/^[0-9]{4}$/", $pl_pas)) return false;
		     return $pl_pas;
		}
		*/
$pl_pas = intval($_POST['plat_pass']);
$id = $_POST['iddd'];
$plat_pass = md5($pl_pas);
	if($plat_pass){
	
			$db->Query("UPDATE db_users_a SET plat_pass = '$plat_pass' WHERE id = '$id'");
			$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
			echo "<center><font color = 'green'><b>��������� ������ �������!</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>��������� ������ ����� �������� ������!</b></font></center><BR />";
}

$data = $db->FetchArray();

?>

<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">ID:</td>
    <td width="200" align="center"><?=$data["id"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">�����:</td>
    <td width="200" align="center"><?=$data["user"]; ?></td>
  </tr>
  <?php
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a WHERE ip IN (SELECT ip FROM db_users_a GROUP BY ip HAVING COUNT(*) > 1) AND ip = $data[ip] AND id != $data[id] ");
	if($db->NumRows()>0) {
		while($mult = $db->FetchArray()) {
			echo '<tr>
			<td style="padding-left:10px;">�����:</td>
			<td width="200" align="center">';
			echo '<a href="/?menu=admin384&sel=users&edit='.$mult['id'].'" class="stn"';
			if($mult['banned']==1) { 
				echo ' style="color: red;"';
			}
			echo '>'.$mult["user"].'</a>';
			echo '</td>
			</tr>';
		}
	}
  ?>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">Email:</td>
    <td width="200" align="center"><?=$data["email"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������:</td>
    <td width="200" align="center"><?=$data["pass"]; ?></td>
  </tr>
  
  <tr>
	
    <td style="padding-left:10px;">��������� ������:</td>
	<form action="" method="post">
	<input type="hidden" name="plat_pass">
	<input type="hidden" name="iddd" value="<?=$data["id"]; ?>">
    <td width="100" align="center"><input type="text" name="pl_pass" value=""></td>
    <td width="100" align="center"><input type="submit"  value="���������"></td>
	</form>
  </tr>
  
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� (�������):</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["money_b"]); ?></td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">������� (�����):</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["money_p"]); ?></td>
  </tr>
  
  
  
  
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ �� ������ (�������):</td>
    <td width="200" align="center"><?=$data["a_b"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������ �� ������ (�������):</td>
    <td width="200" align="center"><?=$data["b_b"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ �� ������ (�������):</td>
    <td width="200" align="center"><?=$data["c_b"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������ �� ������ (�������):</td>
    <td width="200" align="center"><?=$data["d_b"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ �� ������ (���������):</td>
    <td width="200" align="center"><?=$data["f_b"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ �� ������ (����):</td>
    <td width="200" align="center"><?=$data["e_b"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ �� ������ (����������):</td>
    <td width="200" align="center"><?=$data["g_b"]; ?></td>
  </tr>
  
  
  <tr>
    <td style="padding-left:10px;">�������� (�������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="a_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["a_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="a_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">�������� (�������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="b_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["b_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="b_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr>
    <td style="padding-left:10px;">�������� (�������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="c_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["c_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="c_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">�������� (�������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="d_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["d_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="d_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr>
    <td style="padding-left:10px;">�������� (���������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="f_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["f_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="f_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">�������� (����):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="e_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["e_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="e_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">�������� (����������):</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="g_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["g_t"]; ?> ��.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="g_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>
  
  
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� �� ��� ����� (�������):</td>
    <td width="200" align="center"><?=$data["all_time_a"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������� �� ��� ����� (�������):</td>
    <td width="200" align="center"><?=$data["all_time_b"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� �� ��� ����� (�������):</td>
    <td width="200" align="center"><?=$data["all_time_c"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������� �� ��� ����� (�������):</td>
    <td width="200" align="center"><?=$data["all_time_d"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� �� ��� ����� (���������):</td>
    <td width="200" align="center"><?=$data["all_time_f"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� �� ��� ����� (����):</td>
    <td width="200" align="center"><?=$data["all_time_e"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� �� ��� ����� (����������):</td>
    <td width="200" align="center"><?=$data["all_time_g"]; ?></td>
  </tr>
  
  
  <tr>
    <td style="padding-left:10px;">Referer:</td>
    <td width="200" align="center">[<?=$data["referer_id"]; ?>]<?=$data["referer"]; ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">���������:</td>
	
	<?PHP
	$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '".$data["id"]."'");
	$counter_res = $db->FetchRow();
	?>
	
    <td width="200" align="center"><?=$data["referals"]; ?> [<?=$counter_res; ?>] ���.</td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">��������� �� ���������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["from_referals"]); ?> ���.</td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ ��������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["to_referer"]); ?> ���.</td>
  </tr>
  
  
  
  <tr>
    <td style="padding-left:10px;">���������������:</td>
    <td width="200" align="center"><?=date("d.m.Y � H:i:s",$data["date_reg"]); ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">��������� ����:</td>
    <td width="200" align="center"><?=date("d.m.Y � H:i:s",$data["date_login"]); ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">��������� IP:</td>
    <td width="200" align="center"><?=$data["uip"]; ?></td>
  </tr>
  
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">��������� �� ������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">��������� �� �������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� (<?=($data["banned"] > 0) ? '<font color = "red"><b>��</b></font>' : '<font color = "green"><b>���</b></font>'; ?>):</td>
    <td width="200" align="center">
	<form action="" method="post">
	<input type="hidden" name="banned" value="<?=($data["banned"] > 0) ? 0 : 1 ;?>" />
	<input type="submit" value="<?=($data["banned"] > 0) ? '���������' : '��������'; ?>" />
	</form>
	</td>
  </tr>
  
  
</table>
<BR />
<BR />
<form action="" method="post">
<table width="100%" border="0">
  <tr bgcolor="#EFEFEF">
    <td align="center" colspan="4"><b>�������� � ��������:</b></td>
  </tr>
  <tr>
    <td align="center">
		<select name="balance_set">
			<option value="2">�������� �� ������</option>
			<option value="1">����� � �������</option>
		</select>
	</td>
	<td align="center">
		<select name="schet">
			<option value="money_b">��� �������</option>
			<option value="money_p">��� ������</option>
		</select>
	</td>
    <td align="center"><input type="text" name="sum" value="100" size="7"/></td>
    <td align="center"><input type="submit" name="opt_bal" value="���������" /></td>
  </tr>
  <tr bgcolor="#55CC55">
    <td align="center" colspan="3">�������������� (�����):
    <input type="text" name="a_sum" value="" size="7"/></td>
    <td align="center" colspan=""><input type="submit" name="auto_bal" value="���������" /></td>
  </tr>
  
</table>
</form>
</div>
<div class="clr"></div>	
<?PHP

return;
}

?>
<form action="/?menu=admin384&sel=users&search" method="post">
<table width="250" border="0" align="center">
  <tr>
    <td><b>�����:</b></td>
    <td><input type="text" name="sear" /></td>
	<td><input type="submit" value="�����" /></td>
  </tr>
</table>
</form>
<br/>
<form action="/?menu=admin384&sel=users&ochar" method="post">
<table width="200" border="0" align="center">
  <tr>
    <td><b>�����:</b></td>
    <td><input type="text" name="ocharlogin" /></td>
	<td><b>�����:</b></td>
    <td><input type="text" name="ocharsum" /></td>
	<td><input type="submit" value="���������" /></td>
  </tr>
</table>
</form>
<BR />
<?PHP

function sort_b($int_s){
	
	$int_s = intval($int_s);
	
	switch($int_s){
	
		case 1: return "db_users_a.user";
		case 2: return "all_serebro";
		case 3: return "all_trees";
		case 4: return "db_users_a.date_reg";
		
		default: return "db_users_a.id";
	}

}
$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;

$str_sort = sort_b($sort_b);


$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

if(isset($_GET["search"])){
$search = $_POST["sear"];
$db->Query("SELECT *, (db_users_b.a_t + db_users_b.b_t + db_users_b.c_t + db_users_b.d_t + db_users_b.e_t) all_trees, (db_users_b.money_b + db_users_b.money_p) all_serebro 
FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.user = '$search' ORDER BY {$str_sort} DESC LIMIT {$lim}, 100");

}else $db->Query("SELECT *, (db_users_b.a_t + db_users_b.b_t + db_users_b.c_t + db_users_b.d_t + db_users_b.e_t) all_trees, (db_users_b.money_b + db_users_b.money_p) all_serebro 
FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id ORDER BY {$str_sort} DESC LIMIT {$lim}, 100");



if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb"><a href="/?menu=admin384&sel=users&sort=0" class="stn-sort">ID</a></td>
    <td align="center" class="m-tb"><a href="/?menu=admin384&sel=users&sort=1" class="stn-sort">User</a></td>
    <td align="center" width="90" class="m-tb"><a href="/?menu=admin384&sel=users&sort=2" class="stn-sort">�������</a></td>
	<td align="center" width="75" class="m-tb"><a href="/?menu=admin384&sel=users&sort=3" class="stn-sort">��������</a></td>
	<td align="center" width="100" class="m-tb"><a href="/?menu=admin384&sel=users&sort=4" class="stn-sort">���������������</a></td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"><?=$data["id"]; ?></td>
    <td align="center">
	<a href="/?menu=admin384&sel=users&edit=<?=$data["id"]; ?>" class="stn"<?php if($data['banned']==1) { echo ' style="color: red;"'; } ?>><?=$data["user"]; ?></a>
	</td>
    <td align="center"><?=sprintf("%.2f",$data["all_serebro"]); ?></td>
	<td align="center"><?=$data["all_trees"]; ?></td>
	<td align="center"><?=date("d.m.Y",$data["date_reg"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>�� ������ �������� ��� �������</b></center><BR />";

	if(isset($_GET["search"])){
	
	?>
	</div>
	<div class="clr"></div>	
	<?PHP
	
		return;
	
	}
	
$db->Query("SELECT COUNT(*) FROM db_users_a");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/?menu=admin384&sel=users&sort={$sort_b}&page="), "</center>";
	
	}
?>
</div>
<div class="clr"></div>
<?
$db->Query("SELECT * FROM db_users_a WHERE plat_pass != 0");
while($all = $db->FetchArray()) {
echo $all['user'].'<br>';
}

?>