<?PHP
######################################
# ������ Fruit Farm
# ����� Rufus
# ICQ: 819-374
# Skype: Rufus272
######################################
$_OPTIMIZATION["title"] = "�������";
$_OPTIMIZATION["description"] = "������� ������������";
$_OPTIMIZATION["keywords"] = "�������, ������ �������, ������������";

# ���������� ������
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // �������� ������
		case "stats": include("pages/account/_story.php"); break; // ����������
		case "referals": include("pages/account/_referals.php"); break; // ��������
		case "farm": include("pages/account/_farm.php"); break; // ��� �����
		case "store": include("pages/account/_store.php"); break; // �����
		case "swap": include("pages/account/_swap.php"); break; // �������� �����
		case "market": include("pages/account/_market.php"); break; // �����
		case "payment": include("pages/account/_payment.php"); break; // ������� WM
		case "payment_yandex": include("pages/account/_payment_yandex.php"); break; // ������� yandex
		case "payment_qiwi": include("pages/account/_payment_qiwi.php"); break; // ������� qiwi
		case "payment_pm": include("pages/account/_payment_pm.php"); break; // ������� PerfectMoney
		case "payment_payeer": include("pages/account/_payment_payeer.php"); break; // ������� payeer
		case "insert": include("pages/account/_insert.php"); break; // ���������� �������
		case "insertwm": include("pages/account/_insertwm.php"); break; // ���������� �������
		case "config": include("pages/account/_config.php"); break; // ���������
		case "bonus": include("pages/account/_bonus.php"); break; // ���������� �����
        case "set": include("pages/account/_set.php"); break; // ���� 
		case "lottery": include("pages/account/_lottery.php"); break; // �������
		case "paymentwm": include("pages/account/_paymentwm.php"); break; // ������� WM
		case "otziv": include("pages/_otziv.php"); break; // ������
		case "book": include("pages/_book.php"); break; // FAQ
		case "ref_ban": include("pages/account/_ref_ban.php"); break; // ������
        case "chat": include("pages/account/_chat.php"); break; // ���
        case "actions": include("pages/account/_actions.php"); break; // �����
        case "faq": include("pages/_faq.php"); break; // FAQ
		case "faq_faq": include("pages/_faq_faq.php"); break; // FAQ_FAQ
		case "knb": include("pages/account/_knb.php"); break; // ���
		case "donations": include("pages/account/_donations.php"); break; // �������������
		case "rul": include("pages/account/_rul.php"); break; // ���������
		case "games": include("pages/account/_games.php"); break; // ������� ������
        case "jobs": include("pages/account/_jobs.php"); break; // �������
		case "info": include("pages/account/_info.php"); break; // ������
        case "wm_insert": include("pages/account/_wm_insert.php"); break; // �� ����������
		case "paymentz": include("pages/account/_paymentz.php"); break; // paymentz
		case "other": include("pages/account/_others.php"); break; // ������
		case "pm": include("pages/account/_pm.php"); break; // �����
		case "life": include("pages/account/_life.php"); break; // �����
		case "exit": @session_destroy(); Header("Location: /"); return; break; // �����
				
	# �������� ������
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/account/_user_account.php");

?>