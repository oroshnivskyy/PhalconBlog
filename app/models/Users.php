<?php

use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf;

class Users extends \Phalcon\Mvc\Model
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var string
     *
     */
    public $login;

    /**
     * @var string
     *
     */
    public $password;
    /**
     * @var string
     *
     */
    public $salt;


    /**
     * Initializer method for model.
     */
    public function initialize()
    {
        $this->hasMany("id", "Posts", "users_id");
    }

    public function changePassword()
    {
        $this->salt = substr(sha1(rand()), 0, 10);
        $this->password = sha1(sha1($this->password) . $this->salt);
    }

    public function checkPassword($password)
    {
        return $this->password === sha1(sha1($password) . $this->salt);
    }

    function _preSave()
    {
        $this->changePassword();
    }

    public function validation()
    {
        $this->validate(
            new UniquenessValidator(array(
                'field' => 'login',
                'message' => 'Sorry, The login was registered by another user'
            ))
        );
        $this->validate(
            new PresenceOf(array(
                'field' => 'password',
                'message' => 'Please enter password'
            ))
        );
        $this->validate(
            new PresenceOf(array(
                'field' => 'login',
                'message' => 'Please enter login'
            ))
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
        return true;
    }
}
