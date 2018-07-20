<?php
/* @var $this UserController */

$this->breadcrumbs=array(
	'User'=>array('/user'),
	'Create',
);
$this->renderPartial('userMenu');
?>

<h1>Create User</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'profile' => $profile)); ?>
