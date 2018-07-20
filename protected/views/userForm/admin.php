<?php
$this->renderPartial('userMenu');
?>
<h1>Manage user</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'pager'=>array(
        'class'=>'CLinkPager',
        'pageSize' => 2,
        'firstPageLabel'=>'first',
        'lastPageLabel'=>'last',
        'nextPageLabel'=>'next',
        'prevPageLabel'=>'prev',
        'header'=>'',
    ),
    'filter'=> $model,
    'columns'=>array(
        array(
            'name'=> 'username',
            'value' => '$data->username',
        ),
        array(
            'name' => 'first_name',
            'value' => '$data->profile->first_name',
            'filter' => CHtml::textField('Profile[first_name]', $model->profileData->first_name)
        ),
        array(
            'name' => 'last_name',
            'value' => '$data->profile->last_name',
            'filter' => CHtml::textField('Profile[last_name]', $model->profileData->last_name)
        ),
        array(
            'name' => 'city',
            'value' => '$data->profile->city',
            'filter' => CHtml::textField('Profile[city]', $model->profileData->city)
        ),
        array(
            'name' => 'email',
            'value' => '$data->profile->email',
            'filter' => CHtml::textField('Profile[email]', $model->profileData->email)
        ),
        array(
            'name' => 'tags',
            'value'=> '$data->tags',
            'filter' => CHtml::dropDownList( 'User[tagIds]', $model->tagIds,
                CHtml::listData( Tags::model()->findAll( array( 'order' => 'name' ) ), 'id', 'name' ),
                array(
                    'options'=>array('$data->tagIds'=>'selected'),
                    'multiple' => 'multiple'
                )
            ),
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>