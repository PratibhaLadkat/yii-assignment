<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class User extends CActiveRecord
{
   // private $idCache;
    /**
     * Profile model
     * @var
     */
    public $profileData;

    public $tagIds;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>128),
            array('username', 'unique', 'message'=>'User name already exists. Try new'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('username, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below..
		return array(
            'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
            'userTags'=>array(self::HAS_MANY, 'UserTags', 'user_id', 'with' => 'tags')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select = 't.*, profile.*';
        //$criteria->with = array( 'profile','userTags','userTags.tags');

        $criteria->join = 'Inner Join profile "profile" ON "profile".user_id = t.id Left Join tbl_user_tags "userTags" On "userTags".user_id = t.id';
        $criteria->together = true;
		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
        $this->profileData = $profile = new Profile();
        if ( isset($_GET['Profile']))
        {
            $profile->attributes = $_GET['Profile'];
            $criteria->compare('profile.first_name', $profile->first_name, true);
            $criteria->compare('profile.last_name', $profile->last_name, true);
            $criteria->compare('profile.city', $profile->city, true);
            $criteria->compare('profile.email', $profile->email, true);
        }

        if (!empty($_GET['User']['tagIds']))
        {
            $criteria->compare('"userTags"."tag_id"', $_GET['User']['tagIds']);
        }
        $criteria->order = 't.id';
        $criteria->group = 't.id, "profile"."id", "userTags"."user_id"';//, "tags"."id"';
//print_r($criteria);exit;
        return new CActiveDataProvider($this, array(
		    'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>3,
            ),
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Save user data
     *
     * @param bool $runValidation
     * @param null $attributes
     * @return mixed
     */
	public function save($runValidation=true,$attributes=null)
    {
        $this->password = md5($this->password);
        if ($this->getIsNewRecord())
        {
            $this->created_at = date('Y-m-d H:i:s');
        } else
        {
            $this->modified_at = date('Y-m-d H:i:s');
        }

        return parent::save($runValidation=true,$attributes=null);
    }

    /**
     * @return array
     */
    public function getTagList()
    {
        $result =[];

        $userTags = UserTags::model()->with('tags')->findAll('user_id = :userId', [':userId' => $this->id]);

        foreach ($userTags as $userTag)
        {
            $result[$userTag->tags->id] = $userTag->tags->name;
        }

        return $result;
    }

    /**
     * Get tags from data provided
     * @param $data
     * @return array
     */
    public function getTags()
    {
        return implode(',', $this->getTagList());
    }
}
