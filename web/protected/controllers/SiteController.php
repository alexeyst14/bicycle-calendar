<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $mileage = Yii::app()->user->isGuest ? array() : MileageDaily::model()->getMileageForYear();
        Yii::app()->clientScript->registerScript('mileageData', "
            var CONST = {
                'mileageData' : " . CJavaScript::jsonEncode($mileage) . "
            };
        ", CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl() . '/css/calendar.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl() . '/js/calendar.js');
		$this->render('index', array(
            'year' => date('Y'),
        ));
	}
    
    public function actionSaveMileage()
    {
        MileageDaily::model()->saveDailyMileage($_POST);
        echo CJavaScript::jsonEncode(array(
            'result' => 'ok',
        ));
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Благодарим Вас за обращение к нам. Мы ответим вам как можно скорее.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
    
	/**
	 * Displays the contact page
	 */
	public function actionRegister()
	{
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->getBaseUrl(true));
        }
        
        $model=new Users;
        $model->scenario = 'register';
        $this->performAjaxValidation($model);

        if(isset($_POST['Users'])) {
            $model->attributes=$_POST['Users'];
            $password = $model->password;
            if($model->save()) {
                $login = new LoginForm;
                $login->email = $model->primaryemail;
                $login->password = $password;
                $login->login();
                $this->redirect(Yii::app()->getBaseUrl(true));
            }
        }

        $this->render('register',array(
            'model'=>$model,
        ));
    }    

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
        $this->performAjaxValidation($model);

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
    
    public function actionProfile()
    {
        $model = Users::getCurrentUser();
        if(isset($_POST['Users'])) {
            if (empty($_POST['Users']['password'])) {
                unset($_POST['Users']['password']);
                unset($_POST['Users']['repeatpassword']);
                unset($model->password);
            }
            $model->attributes = $_POST['Users'];
            if($model->save()) {
                Yii::app()->user->setFlash('saved', 'Профиль сохранен');
            }
        }

        $model->password = '';
        $model->repeatpassword = '';
        $this->render('profile',array(
            'model'=>$model,
        ));
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    
    protected function performAjaxValidation($model)
    {
        if(Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }     
}