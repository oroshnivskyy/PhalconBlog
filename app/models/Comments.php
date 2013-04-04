<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Numericality;

class Comments  extends \Phalcon\Mvc\Model {
    /**
     * @var integer
     *
     */
    public $id;

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
     * @var integer
     *
     */
    public $posts_id;
    /**
     * Initializer method for model.
     */
    public function initialize()
    {
        $this->belongsTo("users_id", "Users", "id");
        $this->belongsTo("posts_id", "Posts", "id");
    }
    function _preSave()
    {
        $this->created = (new DateTime())->format("Y-m-d H:i:s");
    }

    public function validation()
    {
        $this->validate(
            new PresenceOf(array(
                'field' => 'content',
                'message' => 'Please enter content'
            ))
        );
        $this->validate(
            new Numericality(array(
                'field' => 'posts_id',
                'message' => 'Post id must be numeric'
            ))
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
        return true;
    }
}
