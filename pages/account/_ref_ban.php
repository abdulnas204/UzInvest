<?PHP
$_OPTIMIZATION["title"] = "���. �������";
$_OPTIMIZATION["description"] = "���. �������";
$_OPTIMIZATION["keywords"] = "���. �������";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<div class="s-bk-lf">
	<div class="acc-title">���. ������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
����������� � ���� ����� ������ � ��������, �� ������ �������� 1% �� ������� ���������� �������  
������������ ���� ���������. ����� �� ��� �� ���������. ���� ��������� ������������ ����� 
�������� ��� ����� 1000 ������.<br><hr>
���� ������������ ������ ��� ����������� ���������.<br />
<img src="/img/piar-link.png" style="vertical-align:-2px; margin-right:5px;" /><font color="#000;"><b>http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?></b></font>


</div>

<div class="clr"></div>	
