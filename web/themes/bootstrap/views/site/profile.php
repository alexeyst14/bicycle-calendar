<?php

$this->pageTitle=Yii::app()->name . ' - Профиль';
$this->breadcrumbs=array(
	'Профиль',
);
?>

<h1>Профиль</h1>

<div class="form">

<?php if(Yii::app()->user->hasFlash('saved')): ?>
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('saved'),
    )); ?>
<?php endif; ?>
    
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'profile-form',
    'type'=>'horizontal',
    //'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <p class="note">Поля со звездочками <span class="required">*</span> являются обязательными</p>
    
    
    
    <?php echo $form->textFieldRow($model,'primaryemail', array('readonly' => true, 'autocomplete' => 'off')); ?>
    <?php echo $form->passwordFieldRow($model,'password', array('autocomplete' => 'off')); ?>
    <?php echo $form->passwordFieldRow($model,'repeatpassword', array('autocomplete' => 'off')); ?>
    <?php echo $form->textFieldRow($model,'fullname'); ?>
    <?php echo $form->textFieldRow($model,'nickname'); ?>
    
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Сохранить',
        )); ?>
	</div>    

<?php $this->endWidget(); ?>

</div><!-- form -->