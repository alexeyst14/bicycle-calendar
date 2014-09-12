<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id
 * @property string $primaryemail
 * @property string $password
 * @property string $nickname
 * @property string $fullname
 * @property string $regdate
 * @property string $lastlogin
 *
 * The followings are the available model relations:
 * @property Identity[] $identities
 * @property MileageDaily[] $mileageDailies
 * @property MileageMonthly[] $mileageMonthlies
 */
class Users extends CActiveRecord
{
    public $repeatpassword;
    public $verifyCode;
    public $passwordNoCrypt;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('primaryemail, fullname', 'required'),
            array('password, repeatpassword', 'required', 'on' => 'register'),
            array('primaryemail', 'email'),
            array('primaryemail', 'unique', 'message' => 'Такой имейл уже зарегистрирован', 
                'attributeName' => 'primaryemail'), 
            
            array('password, repeatpassword', 'length', 'min'=>6, 'max'=>40),
            array('repeatpassword', 'compare', 'compareAttribute'=>'password'),
            
            array('primaryemail, fullname', 'length', 'max' => 255),
            array('nickname', 'length', 'max' => 100),
            array('regdate, lastlogin', 'safe'),

			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on' => 'register'),
            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, primaryemail, nickname, fullname, regdate, lastlogin', 'safe', 'on' => 'search'),
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
            'identities' => array(self::HAS_MANY, 'Identity', 'userid'),
            'mileageDailies' => array(self::HAS_MANY, 'MileageDaily', 'userid'),
            'mileageMonthlies' => array(self::HAS_MANY, 'MileageMonthly', 'userid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'primaryemail' => 'Email',
            'password' => 'Пароль',
            'repeatpassword' => 'Пароль еще раз',
            'nickname' => 'Ник',
            'fullname' => 'Полное имя',
            'regdate' => 'Дата регистрации',
            'lastlogin' => 'Дата последнего входа',
            'verifyCode'=>'Проверочный код',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('primaryemail', $this->primaryemail, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('fullname', $this->fullname, true);
        $criteria->compare('regdate', $this->regdate, true);
        $criteria->compare('lastlogin', $this->lastlogin, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->regdate = $this->lastlogin = date('Y-m-d H:i:s');
            if (empty($this->password)) {
                $this->password = self::generatePassword();
            }
        }
        if (!empty($this->password)) {
            $this->passwordNoCrypt = $this->password;
            $this->password = md5($this->password);
        }
        return parent::beforeSave();
    }
    
    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $this->sendEmailSuccess();
        }
        parent::afterSave();
    }

    /**
     * Return current user
     * @return Users
     */
    public static function getCurrentUser()
    {
        return Yii::app()->getUser()->getModel();
    }
    
    /**
     * Password validation
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return md5($password) === $this->password;
    }
    
    /**
     * Send email about success registration
     */
    public function sendEmailSuccess()
    {
        $mailer = new YiiMailer('registerSuccess');
        $mailer->AddAddress($this->primaryemail, $this->fullname);
        $mailer->From = Yii::app()->params['adminEmail'];
        $mail->Subject = Yii::app()->name . ' - Успешная регистрация!';
        $mailer->setData(array(
            'email' => $this->primaryemail,
            'password' => $this->passwordNoCrypt,
        ));
        $mailer->render();
        return $mailer->Send();
    }
    
    /**
     * Genarate password
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 8)
    {
        $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
        shuffle($chars);
        return implode(array_slice($chars, 0, $length));
    }
 
}
