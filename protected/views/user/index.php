<?php
/* @var $this UserController */

$this->breadcrumbs=array(
    'User'=>array('/user'),
    'index',
);
$this->renderPartial('userMenu');
?>
<?php foreach($data as $userData) {
    $this->renderPartial('_view', array('data' => $userData));
}
?>

