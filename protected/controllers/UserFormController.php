<?php
/**
 * Created by PhpStorm.
 * User: tag-002
 * Date: 13/7/18
 * Time: 1:00 PM
 */
class UserFormController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * List user details
     */
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
     *  Create user
     */
    public function actionCreate()
    {
        $userForm = new UserForm();
        $userForm->setScenario('insert');

        if(isset($_POST['UserForm']))
        {
            $userForm->attributes=$_POST['UserForm'];
            $userForm->tagIds = !empty($_POST['UserForm']['tagIds']) ? $_POST['UserForm']['tagIds'] : [];

            // validate user input and redirect to the previous page if valid
            if($userForm->validate()) {

                $userForm->save();

                $this->redirect(array('view', 'id' => $userForm->userId));
            }
        }

        $this->render('create',array('model'=>$userForm));
    }

    /**
     * Update user details
     *
     * @param int $id
     */
    public function actionUpdate($id)
    {
        $userForm = new UserForm();
        $userForm->setScenario('update');
        $userForm->setValues($id);

        if(isset($_POST['UserForm']))
        {
            $userForm->attributes = $_POST['UserForm'];
            $userForm->tagIds = !empty($_POST['UserForm']['tagIds']) ? $_POST['UserForm']['tagIds'] : [];
            if ($userForm->validate()) {
                $userForm->save();
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('update',array(
            'model'=> $userForm
        ));
    }

    /**
     * Manage user details
     */
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
     * Delete user and respected details
     *
     * @param $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
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
}