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
        $userForm->setValues($id);

        if(isset($_POST['UserForm']))
        {
            $userForm->attributes = $_POST['UserForm'];
            $userForm->tagIds = !empty($_POST['UserForm']['tagIds']) ? $_POST['UserForm']['tagIds'] : [];
            $userForm->save();
            $this->redirect(array('index'));
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
}