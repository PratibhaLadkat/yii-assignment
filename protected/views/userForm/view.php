<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs=array(
    'User'=>array('create'),
    $model->id,
);

$this->renderPartial('userMenu');
?>

    <h1>View Profile #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'profile.first_name',
        'profile.last_name',
        'profile.city',
        'profile.email',
        'tags'
    ),
)); ?>