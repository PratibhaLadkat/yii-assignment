<?php
/* @var $this UserController */

$this->breadcrumbs=array(
    'UserForm'=>array('/userForm'),
    'index',
);
$this->renderPartial('userMenu');
foreach($data as $userData) {
    $this->renderPartial('_view', array('data' => $userData));
}
?>

