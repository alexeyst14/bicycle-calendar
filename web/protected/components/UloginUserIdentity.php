<?php

class UloginUserIdentity implements IUserIdentity
{

    private $id;
    private $name;
    private $isAuthenticated = false;
    private $states = array();

    public function __construct()
    {
    }

    public function authenticate($uloginModel = null)
    {
        $user = Users::model()->find(array(
            'condition' => 'primaryemail = :email',
            'params'    => array(':email' => $uloginModel->email),
        ));
        
        $criteria = new CDbCriteria;
        $criteria->condition = 'identity=:identity AND network=:network';
        $criteria->params = array(
            ':identity' => $uloginModel->identity,
            ':network'  => $uloginModel->network,
        );
        $identify = Identity::model()->find($criteria);

        if (is_null($identify)) {
            if (is_null($user)) {
                $user = new Users;
                $user->primaryemail = $uloginModel->email;
                $user->fullname = $uloginModel->fullname;
                $user->save();
            }
            $identify = new Identity();
            $identify->userid   = $user->id;
            $identify->identity = $uloginModel->identity;
            $identify->network  = $uloginModel->network;
            $identify->email    = $uloginModel->email;
            $identify->fullname = $uloginModel->fullname;
            $identify->save();
        }
        
        $user->lastlogin = date('Y-m-d H:i:s');
        $user->saveAttributes(array('lastlogin'));
            
        $this->id   = $user->id;
        $this->name = $user->fullname;
        $this->isAuthenticated = true;
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPersistentStates()
    {
        return $this->states;
    }
}