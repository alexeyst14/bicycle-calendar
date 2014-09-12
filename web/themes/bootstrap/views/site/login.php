<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Вход';
$this->breadcrumbs=array(
	'Вход',
);
?>

<h1>Вход</h1>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Поля со звездочками <span class="required">*</span> являются обязательными</p>

	<?php echo $form->textFieldRow($model,'email'); ?>
	<?php echo $form->passwordFieldRow($model,'password'); ?>
	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Вход',
        )); ?>
        
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'label'=>'Регистрация',
            'url' => '/site/register'
        )); ?>
        
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
