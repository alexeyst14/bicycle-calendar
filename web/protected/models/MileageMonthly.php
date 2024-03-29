<?php

/**
 * This is the model class for table "{{mileage_monthly}}".
 *
 * The followings are the available columns in table '{{mileage_monthly}}':
 * @property string $userid
 * @property integer $month
 * @property string $mileage
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class MileageMonthly extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MileageMonthly the static model class
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
		return '{{mileage_monthly}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, month', 'required'),
			array('month', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>10),
			array('mileage', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, month, mileage', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'month' => 'Month',
			'mileage' => 'Mileage',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('month',$this->month);
		$criteria->compare('mileage',$this->mileage,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}