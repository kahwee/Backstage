<?php

/**
 * This is the model base class for the table "user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "user" available as properties of the model,
 * followed by relations of table "user" available as properties of the model.
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $pwd
 * @property integer $user_status_id
 * @property integer $user_group_id
 * @property string $create_time
 * @property string $create_by
 * @property string $update_time
 * @property string $update_by
 *
 * @property Article[] $articles
 * @property Article[] $articles1
 * @property User $createBy
 * @property User[] $users
 * @property User $updateBy
 * @property User[] $users1
 */
abstract class BaseUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User|Users', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('create_time, create_by', 'required'),
			array('user_status_id, user_group_id', 'numerical', 'integerOnly'=>true),
			array('name, email, pwd', 'length', 'max'=>255),
			array('create_by, update_by', 'length', 'max'=>11),
			array('update_time', 'safe'),
			array('name, email, pwd, user_status_id, user_group_id, update_time, update_by', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, email, pwd, user_status_id, user_group_id, create_time, create_by, update_time, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'articles' => array(self::HAS_MANY, 'Article', 'create_by'),
			'articles1' => array(self::HAS_MANY, 'Article', 'update_by'),
			'createBy' => array(self::BELONGS_TO, 'User', 'create_by'),
			'users' => array(self::HAS_MANY, 'User', 'create_by'),
			'updateBy' => array(self::BELONGS_TO, 'User', 'update_by'),
			'users1' => array(self::HAS_MANY, 'User', 'update_by'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'email' => Yii::t('app', 'Email'),
			'pwd' => Yii::t('app', 'Pwd'),
			'user_status_id' => Yii::t('app', 'User Status'),
			'user_group_id' => Yii::t('app', 'User Group'),
			'create_time' => Yii::t('app', 'Create Time'),
			'create_by' => null,
			'update_time' => Yii::t('app', 'Update Time'),
			'update_by' => null,
			'articles' => null,
			'articles1' => null,
			'createBy' => null,
			'users' => null,
			'updateBy' => null,
			'users1' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('pwd', $this->pwd, true);
		$criteria->compare('user_status_id', $this->user_status_id);
		$criteria->compare('user_group_id', $this->user_group_id);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('create_by', $this->create_by);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('update_by', $this->update_by);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}