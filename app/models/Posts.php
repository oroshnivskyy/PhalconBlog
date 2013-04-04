<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;

class Posts extends \Phalcon\Mvc\Model
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
    public $title;

    /**
     * @var string
     *
     */
    public $slug;

    /**
     * @var string
     *
     */
    public $content;

    /**
     * @var string
     *
     */
    public $created;

    /**
     * @var integer
     *
     */
    public $users_id;



    /**
     * Initializer method for model.
     */
    public function initialize()
    {
        $this->belongsTo("users_id", "Users", "id");
        $this->hasMany("id", "Comments", "posts_id");
    }

    function _preSave()
    {
        $this->created = (new DateTime())->format("Y-m-d H:i:s");
    }

    public function validation()
    {

        $this->validate(
            new PresenceOf(array(
                'field' => 'title',
                'message' => 'Please enter title'
            ))
        );
        $this->validate(
            new PresenceOf(array(
                'field' => 'slug',
                'message' => 'Please enter slug'
            ))
        );
        $this->validate(
            new PresenceOf(array(
                'field' => 'content',
                'message' => 'Please enter content'
            ))
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
        return true;
    }

}
