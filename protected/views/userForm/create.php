<?php
/* @var $this UserController */

$this->breadcrumbs=array(
    'UserForm'=>array('/userForm'),
    'Create',
);
$this->renderPartial('userMenu');
?>

<h1>Create User</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
