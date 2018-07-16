
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
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary([$model, $profile]); ?>

    <?php echo $form->hiddenField($model, 'id');?>
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
        <?php echo $form->labelEx($profile,'email'); ?>
        <?php echo $form->textField($profile,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($profile,'email'); ?>
    </div>
    <?php echo $form->hiddenField($profile, 'id');?>
    <div class="row">
        <?php echo $form->labelEx($profile,'first_name'); ?>
        <?php echo $form->textField($profile,'first_name',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($profile,'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'last_name'); ?>
        <?php echo $form->textField($profile,'last_name',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($profile,'last_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'city'); ?>
        <?php echo $form->textField($profile,'city',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($profile,'city'); ?>
    </div>

    <div class="row">
        <label>Tags:</label>
        <?php $list = CHtml::listData(Tags::model()->findAll(array('select'=>'id, name', 'order'=>'name')), 'id', 'name');
            echo $form->dropDownList($model, 'tagIds', $list, array('multiple' => true, 'selected' => 'selected'));
         ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->