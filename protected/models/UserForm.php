<?php
/**
 * Created by PhpStorm.
 * User: tag-002
 * Date: 13/7/18
 * Time: 12:48 PM
 */
class UserForm extends CFormModel
{
    public $userId;
    public $username;
    public $password;
    public $profileId;
    public $firstName;
    public $lastName;
    public $city;
    public $email;
    public $tagIds;
    public $isNewRecord = true;
    public $userData;

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            array('username, password', 'length', 'max'=>128),
            array('username', 'unique', 'className'=> 'User', 'message'=>'User name already exists. Try new'),
            array('id, username, password', 'safe', 'on'=>'search'),
            array('firstName', 'required'),
            array('lastName', 'required'),
            array('firstName, lastName', 'length', 'max'=>30),
            array('city', 'length', 'max'=>10),
            array('email', 'length', 'max'=>50),
            array('email', 'email'),
            array('email', 'unique','className'=> 'Profile', 'message'=>'Email already exists. Try new'),
            array('firstName, lastName, city, email', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array();
    }

    /**
     * Save user , profile details
     *
     * @return bool
     */
    public function save()
    {
        // Save user details
        $user = empty(isset($this->userData)) ? new User : $this->userData;
        $user->id = $this->userId;
        $user->username = $this->username;
        $user->password = $this->password;
        $user->save(false);
        $this->userId = $user->id;

        // Save user profile details
        $profile = empty(isset($this->userData->profile)) ? new Profile : $this->userData->profile;
        // $profile->attributes = $this->attributes;
        $profile->user_id = $user->id;
        $profile->id = $this->profileId;
        $profile->first_name = $this->firstName;
        $profile->last_name = $this->lastName;
        $profile->city = $this->city;
        $profile->email = $this->email;

        $profile->save(false);

        $tagIdsToSave = $this->tagIds;
        // Save user tags
        if (!empty(isset($this->userData))) {
            // Save only those are new and remove other rest of
            $storedTagIds = array_keys($this->userData->getTagList());

            $diffTagId = array_diff($storedTagIds, $this->tagIds);
            $tagIdsToSave = array_diff($this->tagIds, $storedTagIds);

            foreach ($diffTagId as $tagId) {
                UserTags::model()->deleteAll('user_id = :userId AND tag_id = :tagId',
                    array(
                        ':userId' => $this->userId,
                        ':tagId' => $tagId
                    ));
            }
        }

        UserTags::model()->saveTags($tagIdsToSave, $user->id);

        return true;
    }

    /**
     * Set values og model for specified user
     */
    public function setValues($id)
    {
        try {
            /**@var User $model */
            $model = User::model()->with('profile', 'userTags')->findByPk($id);

            $this->userId = $model->id;
            $this->username = $model->username;
            $this->password = $model->password;
            $this->profileId = $model->profile->id;
            $this->firstName = $model->profile->first_name;
            $this->lastName = $model->profile->last_name;
            $this->city = $model->profile->city;
            $this->email = $model->profile->email;
            $this->tagIds = array_keys($model->getTagList());
            $this->isNewRecord = false;
            $this->userData = $model;

        }catch(Exception $e) {
            echo $e->getMessage(); exit;
        }
    }
}