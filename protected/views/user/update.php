<?php
/* @var $this ProfileController */
/* @var $model Profile */


$this->breadcrumbs=array(
    'User'=>array('/user'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->renderPartial('userMenu');
?>

<h1>Update User</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'profile' => $profile)); ?>