<?PHP
$_OPTIMIZATION["title"] = "���������� ����� WM";
$_OPTIMIZATION["description"] = "���������� ����� WM";
$_OPTIMIZATION["keywords"] = "���������� ����� WM";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<div class="s-bk-lf">
	<div class="acc-title">���������� ����� WM</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
�1�� ���� ����� ��������� ������� ������ ����� WebMoney ��������� ������� ��������:</p><p>1. ������� �� ���� WebMoney �������.</p><p>2. ���������� ������ ��� ����� �� �������� ����: <font color="#ff0000">R421350229089</font> � � ���������� � ������� ������� "<b>���������� �� <?=$prof_data["user"]; ?></b>".</p><p>3.<font color="#ff0000"> </font>�������� ���������� �������.
				</div>
���������� ������� � ������ ������ ������ �� 1 ������ �� 12 �����.						
</div>
<div class="clr"></div>	