<div class="view">
    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::encode($data->username); ?>
    <br />

    <b><?php echo CHtml::encode($data['profile']->getAttributeLabel('first_name')); ?>:</b>
    <?php echo CHtml::encode($data['profile']->first_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->profile->getAttributeLabel('last_name')); ?>:</b>
    <?php echo CHtml::encode($data->profile->last_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->profile->getAttributeLabel('city')); ?>:</b>
    <?php echo CHtml::encode($data->profile->city); ?>
    <br />

    <b><?php echo CHtml::encode($data->profile->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->profile->email); ?>
    <br />

    <b>UserTags : </b>
    <?php if ([] != $data['userTags']) {
        foreach ($data->userTags as $userTags) {
            echo CHtml::encode($userTags->tags->name).',';
        }
    }?>
    <br />
</div>