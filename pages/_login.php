<?PHP
$_OPTIMIZATION["title"] = "�����������";
$_OPTIMIZATION["description"] = "���� � �������";
$_OPTIMIZATION["keywords"] = "���� � �������";

if(isset($_SESSION["user_id"])){ Header("Location: /account"); return; }
?>
<div class="s-bk-lf">
	<div class="acc-title">�����������</div>
</div>
<div class="silver-bk">
<?PHP

	if(isset($_POST["log_email"])){
	
	$lmail = $func->IsMail($_POST["log_email"]);
	
		if($lmail !== false){
		
			$db->Query("SELECT id, user, pass, referer_id, banned FROM db_users_a WHERE email = '$lmail'");
			if($db->NumRows() == 1){
			
			$log_data = $db->FetchArray();
			
				if(strtolower($log_data["pass"]) == strtolower($_POST["pass"])){
				
					if($log_data["banned"] == 0){
						
						# ������� ���������
						$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '".$log_data["id"]."'");
						$refs = $db->FetchRow();
						
						$db->Query("UPDATE db_users_a SET referals = '$refs', date_login = '".time()."', ip = INET_ATON('".$func->UserIP."') WHERE id = '".$log_data["id"]."'");
						
						$_SESSION["user_id"] = $log_data["id"];
						$_SESSION["user"] = $log_data["user"];
						$_SESSION["referer_id"] = $log_data["referer_id"];
						Header("Location: /account");
						
					}else echo "<center><font color = 'red'><b>�� ��������!</b></font></center><BR />";
				
				}else echo "<center><font color = 'red'><b>Email �/��� ������ ������ �������</b></font></center><BR />";
			
			}else echo "<center><font color = 'red'><b>��������� Email �� ��������������� � �������</b></font></center><BR />";
			
		}else echo "<center><font color = 'red'><b>Email ������ �������</b></font></center><BR />";
	
	}

?>


<div class="autoriz">
	<form action="" method="post"><br>
   
<table width="200" border="0" align="center">
  <tr>
    <td colspan="2">Email:<BR /><input name="log_email" type="text" size="23" maxlength="35" class="lg"/></td>
  </tr>
  
  <tr>
    <td colspan="2">������ [<a href="/recovery" class="rs-ps">������ ������?</a>]:<BR /><input name="pass" type="password" size="23" maxlength="35" class="ps"/></td>
  </tr>

  <tr height="5">
    <td align="center" valign="top"><input type="submit" value="�����" class="button-blue"/></form></td>
    <td align="center" valign="top"><form action="/signup" method="post"><input type="submit" value="�����������" class="button-blue"/></form></td>
  </tr>
  
</table>

</div>
</div>
<div class="clr"></div>	