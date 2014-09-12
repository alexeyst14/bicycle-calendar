<?php

/**
 * This is the model class for table "{{identity}}".
 *
 * The followings are the available columns in table '{{identity}}':
 * @property string $id
 * @property string $userid
 * @property string $identity
 * @property string $network
 * @property string $email
 * @property integer $state
 * @property string $fullname
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Identity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Identity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{identity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>10),
			array('identity, network, email, fullname', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userid, identity, network, email, state, fullname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userid' => 'Userid',
			'identity' => 'Identity',
			'network' => 'Network',
			'email' => 'Email',
			'state' => 'State',
			'fullname' => 'Fullname',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('identity',$this->identity,true);
		$criteria->compare('network',$this->network,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('fullname',$this->fullname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}