<?PHP
class config{

	public $HostDB = "localhost";
	 public $UserDB = "dbuser";
 public $PassDB = "dbpass";
 public $BaseDB = "dbname";
	
	public $SYSTEM_START_TIME = "1507285200";
	public $VAL = "���";
	
	# PAYEER ���������
	public $AccountNumber = 'P1234567';
	public $apiId = 'ApiID';
	public $apiKey = 'ApiKey';
	
	public $shopID = 'ShopID';
	public $secretW = "SecretWord";
	   # FREE-KASSA
    public $fk_merchant_id = 'Merchant ID'; //merchant_id ID �������� � free-kassa.ru (http://free-kassa.ru/merchant/cabinet/help/)
    public $fk_merchant_key = 'oil1'; //��������� ����� http://free-kassa.ru/merchant/cabinet/profile/tech.php
    public $fk_merchant_key2 = 'oil2'; //��������� �����2 (result) http://free-kassa.ru/merchant/cabinet/profile/tech.php
}
?>