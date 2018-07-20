<?php
class PictureController extends Controller
{
	public function actionView($id)
	{
        $this->layout = false;
        $pictures = Picture::model()->findAll('user_id = :userId', [':userId' =>$id]);

        $this->render('view',array('images'=> Picture::model()->getImages($pictures)));
    }
}