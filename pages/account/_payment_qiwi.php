<div class="s-bk-lf">
	<div class="acc-title">����� �������</div>
</div>
<div class="silver-bk">

<?PHP
$_OPTIMIZATION["title"] = "������� - ����� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_users_a WHERE id = '$usid' LIMIT 1");
$user_dataa = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$status_array = array( 0 => "�����������", 1 => "�������������", 2 => "��������", 3 => "���������");

# ��������� ��������!
$minPay = 2100; 

?>
<center><a href="/account/paymentz">�������� �� �������� ������ �������</a></center>
<center><h1><span style="font-size: 17pt;"><b>������� �� QIWI �������</b></span></h1></center> <BR />
<b>������� �� QIWI ������� �������������� � ��������� 3.9%.<br/>
��������� ��� ������� �� QIWI 2100<font color="blue"><b>C</b></font>.<br/>
<font color=red>������� ������������ �������������</font>.</b><BR />
<center><b>����� �������:</b></center><BR />

<?PHP
	
	function ViewPurse($purse){
		
         if( substr($purse,0,1) != "+" ) return false;
         if( !ereg("^[0-9]{11,13}$", substr($purse,1)) ) return false; 
         return $purse;
	}
	
	
	# ������� �������
	if(isset($_POST["purse"])){
		
		$purse = ViewPurse($_POST["purse"]);
		$sum = intval($_POST["sum"]);
		$plat_passs = intval($_POST["plat_pass"]);
		$plat_pass = md5($plat_passs);
		$val = "RUB";
		if($plat_pass == $user_dataa['plat_pass']) {
		if($purse !== false){
			
				if($sum >= $minPay){
				
					if($sum <= $user_data["money_p"]){
						
						# ��������� �� ������������ ������
						$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND (status = '0' OR status = '1')");
						if($db->FetchRow() == 0){
								
								
							### ������ ������� ###	
							$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
							if ($payeer->isAuth())
							{
								
								$arBalance = $payeer->getBalance();
								if($arBalance["auth_error"] == 0)
								{
									
									
									
									$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
									
									if( ($balance) >= ($sum_pay)){
									
									$sum_pay = round( ($sum / $sonfig_site["ser_per_wmr"]), 2);
									$sum_com = $sum_pay - ($sum_pay * 0.039);
									
									
									$initOutput = $payeer->initOutput(array(
		                            // id ��������� ������� ���������� �� ������ ��������� ������ 
		                            'ps' => '26808',
		                            // ����, � �������� ����� ������� ��������          
		                            'curIn' => 'RUB',
		                            // ����� ������ 
		                            'sumOut' => $sum_com,
		                            // ������ ������  
		                            'curOut' => 'RUB',
		                            // ������� ���������� �������  
		                            'param_ACCOUNT_NUMBER' => $purse,
	                            ));
 								if ($initOutput)
	{
		                            // ����� ������� 
		                            $historyId = $payeer->output();
		                            if ($historyId)
		                            {
			                            echo "<center>�����������!</center>";
										# ������� � ������������
											$db->Query("UPDATE db_users_b SET money_p = money_p - '$sum' WHERE id = '$usid'");
											
											# ��������� ������ � �������
											$da = time();
											$dd = $da + 60*60*24*15;
											
											$ppid = $historyId;
										
											$db->Query("INSERT INTO db_payment (user, user_id, purse, sum, valuta, serebro, payment_id, date_add, status) 
											VALUES ('$usname','$usid','$purse','$sum_pay','RUB', '$sum','$ppid','".time()."', '3')");

										
											
											
											
											$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum_pay' WHERE id = '$usid'");
											$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum_pay' WHERE id = '1'");
		                            }
		                            else
		                            {
			                            echo "<font color = 'red'>������:".iconv('utf-8', 'windows-1251', ('<pre>'.print_r($payeer->getErrors(), true).'</pre>'))."</font>";
		                            }
		                        }
		                        else
		                        {	                        
			                        echo "<font color = 'red'>������:".iconv('utf-8', 'windows-1251', ('<pre>'.print_r($payeer->getErrors(), true).'</pre>'))."</font>";
		                        }
								
	

									
										if (!empty($arTransfer["historyId"]))
										{	
										
										
											
											
											
											
											
											
											echo "<center><font color = 'green'><b>���������! ���������� �������� <a href=http://money-ferma.ru/otziv>�����</a>.</b></font></center><BR />";
											
										}
										else
										{
										
											echo "<center><font color = 'green'><b>���������! ���������� �������� <a href=http://money-ferma.ru/otziv>�����</a>.<b></font></center><BR />";	
										
										}
									
									
									}else echo "<center><font color = 'red'><b>��������� ������ - ���������� ���������!</b></font></center><BR />";
									
								}else echo "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
								
							}else echo "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
							
								
						}else echo "<center><font color = 'red'><b>� ��� ������� �������������� ������. ��������� �� ����������.</b></font></center><BR />";
							
						
					}else echo "<center><font color = 'red'><b>�� ������� ������, ��� ������� �� ����� �����</b></font></center><BR />";
				
				}else echo "<center><b><font color = 'red'>����������� ����� ��� ������� ���������� {$minPay} ��������!</font></b></center><BR />";
		
		}else echo "<center><b><font color = 'red'>������� Payeer ������ �������! �������� �������!</font></b></center><BR />";
		
		}else echo "<center><b><font color = 'red'>��������� ������ ������ �� �����!</font></b></center><BR />";
	}
?>
<?php
if($user_dataa['plat_pass'] == 0) {
echo "<center><b><font color = 'red'>������� ��������� ������ � �������!</font></b></center><BR />";
} else {

?>
<form action="" method="post">
<table width="99%" border="0" align="center">
  <tr>
    <td><font color="#000;">������� ������� [������: +7953155XXXX]</font>: </td>
	<td><input type="text" name="purse" size="15"/></td>
  </tr>
  <tr>
    <td><font color="#000;">������� ������� ��� ������</font> [���. 2100]<font color="#000;">:</font> </td>
	<td><input type="text" name="sum" id="sum" value="0" size="15" onkeyup="PaymentSum();" /></td>
  </tr>
  <tr>

    <td><font color="#000;">��������� [RUR]<span id="res_val"></span></font><font color="#000;">:</font> </td>
	<td>
	<input type="text" name="res" id="res_sum" value="0" size="15" disabled="disabled"/>
	<input type="hidden" name="per" id="RUB" value="<?=$sonfig_site["ser_per_wmr"]/0.96; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="min_sum_RUB" value="0.5" disabled="disabled"/>
	<input type="hidden" name="val_type" id="val_type" value="RUB" />
	</td>
  </tr>
  <tr>
    <td><font color="#000;">��������� ������[����������� � �������]</font>: </td>
	<td><input type="text" name="plat_pass" size="15"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="swap" value="�������� �������" style="height: 30px; margin-top:10px;" /></td>
  </tr>
</table>
</form>
<? } ?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h1>���� ��������� �������</h1></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">�����</td>
	<td align="center" class="m-tb">�����</td>
	<td align="center" class="m-tb">�������</td>
	<td align="center" class="m-tb">������</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td align="center"><?=$ref["sum"]; ?> RUB</td>
			<td align="center"><?=$ref["user"]; ?></td>
			<td align="center"><?=$ref["purse"]; ?></td>
    		<td align="center"><?=$status_array[$ref["status"]]; ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">��� �������</td></tr>'
  
  ?>

  
  
</table>

<div class="clr"></div>		
</div>