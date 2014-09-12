<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>
<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'О проекте', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Контакты', 'url'=>array('/site/contact')),
                array('label'=>'FAQ', 'url'=>array('/site/page', 'view' => 'faq')),
				array('label'=>'Вход / Регистрация', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Профиль', 'url'=>array('/site/profile'), 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),
        '<div style="padding-top: 12px; float: right;">' . 
            $this->widget('UloginWidget', array('params' => array(
                'redirect' => 'http://'.$_SERVER['HTTP_HOST'].'/ulogin/login'
            )), true) .
        '</div>' ,
    ),
)); ?>
    
<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>
	<div id="footer">
        <a href="http://mtb.dn.ua/" target="_blank"><img src="/images/mtb-donetsk-button.png" alt="МТБ Донецк"/></a>
        <br/>
        <p style="margin-top: 10px;"><?php echo date('Y'); ?> &copy; <?php echo Yii::powered(); ?></p>
	</div><!-- footer -->
</div><!-- page -->
</body>
</html>
