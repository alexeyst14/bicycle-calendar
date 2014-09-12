<?php

/**
 * This is the model class for table "{{mileage_daily}}".
 *
 * The followings are the available columns in table '{{mileage_daily}}':
 * @property string $userid
 * @property string $date
 * @property string $mileage
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class MileageDaily extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MileageDaily the static model class
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
		return '{{mileage_daily}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, date', 'required'),
			array('userid', 'length', 'max'=>10),
			array('mileage', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, date, mileage', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('mileage',$this->mileage,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Returns daily mileage for year
     * @param int $year
     * @return array
     */
    public function getMileageForYear($year = null)
    {
        $year = (int) is_null($year) ? date('Y') : $year;
        $user = Users::getCurrentUser();
        $ret = array();
        if (is_null($user)) {
            return $ret;
        }
        
        $from = "$year-01-01";
        $to = "$year-12-31";
        $id = $user->id;

        $dataReader = Yii::app()->db->createCommand("
            SELECT MONTH(`date`) AS month, DAY(`date`) AS day, mileage
            FROM {{mileage_daily}}
            WHERE userid = :userid
            AND date BETWEEN :from AND :to
        ")->bindParam(':userid', $id)
            ->bindParam(':from', $from)
            ->bindParam(':to', $to)
            ->query();
        
        foreach($dataReader as $row) {
            $ret[$row['month']][$row['day']] = round($row['mileage'], 1);
        }
        return $ret;
    }
    
    /**
     * 
     * @param array $data
     * @return boolean
     */
    public function saveDailyMileage(array $data)
    {
        $user = Users::getCurrentUser();
        $mileage = (double) $data['mileage'];
        if (is_null($user)) {
            return false;
        }
        preg_match('/^dist\[(\d+)\]\[(\d+)\]$/', $data['name'], $matches);
        $month = $matches[1];
        $day   = $matches[2];
        
        /*
         *  TODO fix saving zero mileage
         */
        
        $model = new MileageDaily();
        $model->userid = $user->id;
        $model->date = sprintf("%04d-%02d-%02d", date('Y'), $month, $day);
        $model->mileage = $mileage;
        return $model->save();
    }
}