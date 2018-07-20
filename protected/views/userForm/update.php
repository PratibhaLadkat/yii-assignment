<?php
/* @var $this ProfileController */
/* @var $model Profile */


$this->breadcrumbs=array(
    'UserForm'=>array('/userForm'),
    $model->userId =>array('view','id'=>$model->userId),
    'Update',
);

$this->renderPartial('userMenu');
?>

<h1>Update User</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>