<?php

class WebUser extends CWebUser 
{
    private $_model = null;
 
    public function getRole() {
        if($user = $this->getModel()){
            return $user->role;
        }
    }
 
    public function getModel() {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = Users::model()->findByPk($this->getId());
        }
        return $this->_model;
    }
}