<?php
$this->renderPartial('userMenu');
?>
<style>
    select, input[type = 'text'],
    input[type='password']{
        width:50%;
        box-sizing:border-box;
    }

</style>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary([$model]); ?>
    <?php $form->hiddenField($model, 'userId');?>
    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <?php $form->hiddenField($model, 'profileId');?>
    <div class="row">
        <?php echo $form->labelEx($model,'firstName'); ?>
        <?php echo $form->textField($model,'firstName',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'firstName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'lastName'); ?>
        <?php echo $form->textField($model,'lastName',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'lastName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'city'); ?>
        <?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'city'); ?>
    </div>


    <div class="row">
        <label>Tags:</label>
        <?php $list = CHtml::listData(Tags::model()->findAll(array('select'=>'id, name', 'order'=>'name')), 'id', 'name');
        echo $form->dropDownList($model, 'tagIds', $list, array('multiple' => true, 'selected' => 'selected'));
        ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'photos'); ?>
        <?php
        /*$this->widget('xupload.XUpload', array(
            'url' => Yii::app()->createUrl("/images/upload"),
            'model' => $model,
            'attribute' => 'file',
            'multiple' => true,
        ));*/
        $this->widget('CMultiFileUpload', array(
            'name' => 'images[]',
            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
            'duplicate' => 'Duplicate file!', // useful, i think
            'denied' => 'Invalid file type', // useful, i think
        ));
        ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<!-- form -->