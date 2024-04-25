<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<?php $APPLICATION->ShowHead();?>
    <!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php $APPLICATION->ShowTitle()?></title>
	<meta name="description" content="">
	
    <!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- CSS
	================================================== -->

	<?php
	$asset = Bitrix\Main\Page\Asset::getInstance();
	$asset->addCss(SITE_TEMPLATE_PATH."/assets/css/zerogrid.css");
	$asset->addCss(SITE_TEMPLATE_PATH."/assets/css/style.css");
	$asset->addCss(SITE_TEMPLATE_PATH."/assets/font-awesome/css/font-awesome.min.css");
	$asset->addCss(SITE_TEMPLATE_PATH."/assets/css/menu.css");
	$asset->addJs(SITE_TEMPLATE_PATH."/assets/js/jquery1111.min.js");
	$asset->addJs(SITE_TEMPLATE_PATH."/assets/js/script.js");
/*
	<script src="<?=SITE_TEMPLATE_PATH;?>/assets/js/jquery1111.min.js" type="text/javascript"></script>
	<script src="<?=SITE_TEMPLATE_PATH;?>/assets/js/script.js"></script>
	*/?>


</head>


<?php
$rsSites = CSite::GetByID(SITE_ID);
$arSite = $rsSites->Fetch();
?>

<body class="home-page">
<div id="panel"><?=$APPLICATION->ShowPanel();?></div>
	<div class="wrap-body">
		<header class="">
			<div class="logo">
				<a href="/"><?=$arSite['SITE_NAME']?></a>
			</div>
			<div id="cssmenu" class="align-center">
				<ul>
					<li class="active"><a href="#"><span>Категория 1</span></a></li>
					<li><a href="#"><span>Категория 2</span></a></li>
					<li><a href="#"><span>Категория 3</span></a></li>
				</ul>
			</div>
		</header>


		<section id="container">
			<div class="wrap-container">

				<?php if(IS_INDEX):?>
				<!-----------------content-box-1-------------------->
				<section class="content-box box-1">

					<?php $APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "inc",
							"EDIT_TEMPLATE" => "",
							"PATH" => "main_text.php"
						)
					);?>

				</section>

				<?php endif;?>