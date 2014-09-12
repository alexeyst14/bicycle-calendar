<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Регистрация';
$this->breadcrumbs=array(
	'Регистрация',
);
?>

<h1>Регистрация</h1>

<p>Вы можете зайти без регистрации через соц сети, 
для этого достаточно кликнуть на подходящую вам иконку справа вверху.
</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'users-register-form',
    'type'=>'horizontal',
    'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <p class="note">Поля со звездочками <span class="required">*</span> являются обязательными</p>
    
    <?php echo $form->textFieldRow($model,'primaryemail'); ?>
    <?php echo $form->passwordFieldRow($model,'password'); ?>
    <?php echo $form->passwordFieldRow($model,'repeatpassword'); ?>
    <?php echo $form->textFieldRow($model,'fullname'); ?>
    <?php echo $form->textFieldRow($model,'nickname'); ?>
    
	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'Пожалуйста введите антиспам код.<br/>Код не чувствителен к регистру.',
        )); ?>
	<?php endif; ?>    

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Зарегистрироваться',
        )); ?>
	</div>    

<?php $this->endWidget(); ?>

</div><!-- form -->