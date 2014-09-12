<?php

class UloginWidget extends CWidget
{
    //параметры по-умолчанию
    private $params = array(
        'display'       =>  'small',
        'fields'        =>  'first_name,last_name,email',
        'providers'     =>  'vkontakte,facebook,google,twitter,openid,livejournal',
        'hidden'        =>  '', // 'livejournal,odnoklassniki,mailru,lastfm,linkedin,liveid,soundcloud,steam',
        'redirect'      =>  '',
        'logout_url'    =>  '/ulogin/logout'
    );

    public function run()
    {
        //подключаем JS скрипт
        Yii::app()->clientScript->registerScriptFile('http://ulogin.ru/js/ulogin.js', CClientScript::POS_HEAD);
        $this->render('uloginWidget', $this->params);
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}
