<?php
class UserController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    public function actionIndex()
    {
        $userData = User::model()->with('profile','userTags')->findAll();

        $this->render('index', array(
            'data'=> $userData
        ));
    }

    /**
     * View user of specified id
     *
     * @param integer $id
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        $this->render('view', array(
            'model'=> $model,
        ));
    }

    /**
     * Create user profile
     */
	public function actionCreate()
	{
        $user = new User;
        $profile = new Profile;

        if(isset($_POST['User'], $_POST['Profile']))
        {

            $user->attributes = $_POST['User'];
            $user->tagIds = isset($_POST['User']['tagIds']) ? $_POST['User']['tagIds'] :[];
            $profile->attributes = $_POST['Profile'];

            // validate BOTH $a and $b
            $valid = $user->validate();
            $valid = $profile->validate() && $valid;

            if($valid)
            {
                if($user->save(false))
                {
                    $profile->user_id = $user->id;
                    $profile->save(false);
                    //save user tags
                    $userTag = new UserTags();
                    $userTag->saveTags($user->tagIds, $user->id);
                    $this->redirect(array('view', 'id' => $user->id));
                }
            }

        }

        $this->render('create', array(
            'model'=>$user,
            'profile'=>$profile,
        ));
	}

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Load model
     *
     * @param $id
     * @return array|mixed|null
     */
    public function loadModel($id)
    {
        $model = User::model()->with('profile','userTags')->findByPk($id);

        return $model;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /**@var $model User */
        $model=$this->loadModel($id);

        $model->tagIds = array_keys($model->getTagList());


        if(isset($_POST['User'], $_POST['Profile']))
        {
            $model->attributes = $_POST['User'];
            $model->profile->attributes = $_POST['Profile'];

            if ($model->save(false) && $model->profile->save(false))
            {
                if(!empty($_POST['User']['tagIds'])) {
                    $tagIds = $_POST['User']['tagIds'];

                    $diffTagId = array_diff($model->tagIds, $tagIds);
                    $newTagId = array_diff($tagIds, $model->tagIds);

                    foreach ($diffTagId as $tagId)
                    {
                        UserTags::model()->deleteAll('user_id = :userId AND tag_id = :tagId',
                            array(
                                ':userId' => $model->id,
                                ':tagId' =>  $tagId
                            ));
                    }

                    UserTags::model()->saveTags($newTagId, $model->id);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update',array(
            'model'=> $model,
            'profile'=>$model->profile,
        ));
    }

    /**
     * Delete user and respected details
     *
     * @param $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        //echo "<pre>"; print_r($model);exit;
        $model->profile->delete();

        if([] !== $model->userTags)
        {
            foreach($model->userTags as $userTag) {
                $userTag->delete();
            }
        }

        $model->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}