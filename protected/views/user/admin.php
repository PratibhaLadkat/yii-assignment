<?php
$this->renderPartial('userMenu');
?>
<h1>Manage user</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=> $model->profileData,
    'pager'=>array(
        'class'=>'CLinkPager',
        'pageSize' => 10,
        'firstPageLabel'=>'first',
        'lastPageLabel'=>'last',
        'nextPageLabel'=>'next',
        'prevPageLabel'=>'prev',
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name' => 'id',
            'value' =>'$data->id',
            'filter' => ''
        ),
        array(
            'name'=> 'username',
            'value' => '$data->username',
            'filter' => '',
        ),
        array(
            'name' => 'first_name',
            'value' => '$data->profile->first_name',
        ),
        array(
            'name' => 'last_name',
            'value' => '$data->profile->last_name',
        ),
        array(
            'name' => 'city',
            'value' => '$data->profile->city',
        ),
        array(
            'name' => 'email',
            'value' => '$data->profile->email'
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