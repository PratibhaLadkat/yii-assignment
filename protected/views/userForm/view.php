<?php
/* @var $this ProfileController */
/* @var $model Profile */
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/picture.css');
Yii::app()->clientScript->registerCssFile('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');
Yii::app()->clientScript->registerScriptFile('https://code.jquery.com/jquery-1.12.4.js');
Yii::app()->clientScript->registerScriptFile('https://code.jquery.com/ui/1.12.1/jquery-ui.js');

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
        'username',
        'profile.first_name',
        'profile.last_name',
        'profile.city',
        'profile.email',
        'tags'
    ),
)); ?>
<b>Images : </b>
<span class="spanLink" id="images" data-id="<?php echo $model->id;?>">click here to see</span>
<div id="imageGallary" title="profile photo"></div>
<script type="text/javascript">
    var baseUrl = '<?php echo Yii::app()->baseUrl; ?>';
    $(document).ready( function() {
        $('#images').on('click', function(){
           getProfilePhotos(jQuery(this).data('id'));
        });
    });

    function getProfilePhotos(id)
    {
        var url = baseUrl + '/index.php?r=picture/view';
        var sliderConfig = {
            mode: 'fade',
            captions: true,
            pagerCustom: '#bx-pager',
            adaptiveHeight: true,
            slideWidth: 600,
            auto:true
        };
        $.ajax({
            url : url,
            data: { id : id },
            success: function(response) {
                $('#imageGallary').html(response);
                $('#imageGallary').dialog({
                        width:300
                    });
            }
        });
    }
</script>