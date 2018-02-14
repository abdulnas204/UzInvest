<!Doctype html>

<head>
        
        
    
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <![endif]-->


  
    
		<title>UZCHANGE.RU - {!TITLE!}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>

   

  <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/ipro/common.css">
    <link rel="stylesheet" href="/css/main.css">
	
	
	<link href="/style/style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/functions.js"></script>

    
    
      <script type="text/javascript">
        function dtime(d)
        {
          var dayNames = new Array ("�����������", "�����������", "�������", "�����", "�������", "�������", "�������");
          var monthNames = new Array ("������", "�������", "�����", "������", "���", "����", "����", "�������", "��������", "�������", "������", "�������");
          var now = new Date();
        
          now.setDate(now.getDate() + d + 1);
          document.write((now.getDate()) + " " + monthNames[now.getMonth()] + " " + now.getFullYear() + " �.");
        }
      </script>       

</head>
<body>

  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "../connect.facebook.net/ru_RU/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
    
<script>
  // Pixels snippet
  
  </script>

<div class="pixels-box" style="position: absolute; ">
</div>


<div class="wrapper">
  <!--Header-->
  <header class="main-header row-fluid">
    <div class="logo span4"><a href="/"><img
            src="/img/logo.png" alt=""/></a></div>

    <div class="social-block span8">
      <div class="social-block_btn">
                
        </a>
                          <a href="/login" class="btn btn-large userinfo"><img
            class="ico" src="/img/layout/ico_login.png" alt="����"/> <span>
			<?php
			if(isset($_SESSION["user"]) OR isset($_SESSION["admin"])) {
			echo 'Mening hisobim';
			} else {
			echo 'Tizimga kirish';
			}
			?>
			
			</span></a>
              </div>


     

      <div class="fb-like" data-href="index.htm" data-width="150"
           data-layout="button_count" data-show-faces="true"
           data-send="false"></div>


    </div>
                  <ul class="nav nav-tabs clearfix">
                        <li>
      <a href="/">i</a>
      </li>
                            <li>
      <a href="/news">Yangiliklar </a>
      </li>
                            <li>
      <li>
      <a href="/about">FAQ </a>
      </li>
             <li>
      <a href="/otziv"><b>Fikrlar</b></a>
      </li>
	                              <li>
      <a href="/top">Top 10</a>
      </li>
      
      <li>
	        <a href="/payments">To`lovlar</a>
      </li>
      
	  <li>
	        <a href="/rules">Qoidalar</a>
      </li>
	  
	  <li>
	        <a href="/stat">Statistika</a>
      </li>
                   
                                                                  
  
</ul>            </header>
  <!--/Header-->
<?php
if (!isset($_GET["menu"]) OR strtolower($_GET["menu"]) == "index") {
?>
<section class="promo">
  <div class="promo-main">

      </div>
  <div class="img-wrap">
        <a href="/signup"><img src="/img/banner_to_video.png" alt=""/></a>
      </div>
  <div class="img-wrap">
  <div style="background: #FFF8DC;
text-shadow: none;
border-radius: 7px;
width: 265px; float:right; padding-left:10px;">
<?PHP
$_OPTIMIZATION["title"] = "Bosh sahifa";

$tfstats = time() - 60*60*48;
$db->Query("SELECT 
(SELECT COUNT(*) FROM db_users_a) all_users,
(SELECT SUM(insert_sum) FROM db_users_b) all_insert, 
(SELECT SUM(payment_sum) FROM db_users_b) all_payment, 
(SELECT COUNT(*) FROM db_users_a WHERE date_reg > '$tfstats') new_users");
$stats_data = $db->FetchArray();

?>

<center><h1>Statistika</h1></center>
Investorlar: <font color="#000"><b><?=$stats_data["all_users"]; ?></b> kishi</font><br>
So`nggi 48 soatda: <font color="#000"><b><?=($stats_data["new_users"]+0); ?></b> kishi</font><br>
Jami sarmoya: <font color="#000"><b><?=sprintf("%.2f",$stats_data["all_insert"]*145); ?></b><font color="#000"> so`m</font></font><br>
To`landi: <font color="#000"><b><?=sprintf("%.2f",$stats_data["all_payment"]*150); ?></b></font><font color="#000"> so`m</font><br>
Start:	<font color="#000"><b>04.12.2017</b></font><br><br>
</div>
  
  </div>
  
  </section>

<aside class="reviews">
  <div class="wrapper">
    <div class="item">
    <div class="bq-wrap">
        <blockquote>Ishonchli serverda va yuqori darajada himoyaga ega tizim 24 soat uzluksiz ishlaydi. Loyiha menejmenti to`liq hisoblab chiqilgan va <b>doimiy daromadingiz</b> kafolatlanadi!
        </blockquote>
    </div>
    <div class="pic"><img src="/img/img_user_1.png" alt="image"></div>
    <div class="author"><strong>Ishonchli<br> tizim</strong></div>
</div>
<div class="item">
    <div class="bq-wrap">
        <blockquote>Loyiha haqidagi barcha savollarga javobni "Texnik ko`mak"dan olishingiz mumkin. Ish vaqti<b>9:00 dan 17:00gacha</b>. Qo`llab-quvvatlash markazi loyihaga oid barcha savollaringizga javob berishga tayyor.
        </blockquote>
    </div>
    <div class="pic"><img src="/img/img_user_2.png" alt="image"></div>
    <div class="author"><strong>Texnik<br> ko`mak</strong></div>
</div>
<div class="item">
    <div class="bq-wrap">
        <blockquote>Sarmoyalar <b>real biznesga</b> sarflanadi, shu sababdan sarmoyalar xavfsizligi ta`minlanadi. Do`stlaringizni loyihaga taklif etib, qo`shimcha daromadga ega bo`lishingiz mumkin.
        </blockquote>
    </div>
    <div class="pic"><img src="/img/img_user_3.png" alt="image"></div>
    <div class="author"><strong>Real<br> biznes</strong></div>
</div>  </div>
</aside>
<?php } ?>

<?php
if ((!isset($_GET["menu"]) or strtolower($_GET["menu"]) == "index") or (isset($_GET["menu"]) and strtolower($_GET["menu"]) == "signup")) { 
echo "";
} else {
?>
<section class="news-block content-wrap clearfix">
 

 <article class="news-item row-fluid">


 
<div class="article_item">

  <div class="span8">

    
<? } ?>

    
   