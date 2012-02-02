<?php

/**
 * This is the model base class for the table "user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "user" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $pwd
 * @property integer $user_status_id
 * @property integer $user_group_id
 * @property string $create_at
 * @property string $create_by
 * @property string $update_at
 * @property string $update_by
 *
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
			array('create_at, create_by', 'required'),
			array('user_status_id, user_group_id', 'numerical', 'integerOnly'=>true),
			array('name, email, pwd', 'length', 'max'=>255),
			array('create_by, update_by', 'length', 'max'=>11),
			array('update_at', 'safe'),
			array('name, email, pwd, user_status_id, user_group_id, update_at, update_by', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, email, pwd, user_status_id, user_group_id, create_at, create_by, update_at, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
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
			'create_at' => Yii::t('app', 'Create At'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_at' => Yii::t('app', 'Update At'),
			'update_by' => Yii::t('app', 'Update By'),
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
		$criteria->compare('create_at', $this->create_at, true);
		$criteria->compare('create_by', $this->create_by, true);
		$criteria->compare('update_at', $this->update_at, true);
		$criteria->compare('update_by', $this->update_by, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}