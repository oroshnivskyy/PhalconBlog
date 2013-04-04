<?php

use Phalcon\Tag as Tag;

class SessionController extends ControllerBase
{

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            Tag::setDefault('login', 'admin');
            Tag::setDefault('password', 'admin');
        }
    }

    public function registerAction()
    {
        $request = $this->request;
        if ($request->isPost()) {

            $login = $request->getPost('login', 'alphanum');
            $password = $request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

            if ($password != $repeatPassword) {
                $this->flash->error('Passwords are diferent');
                return false;
            }

            $user = new Users();
            $user->login = $login;
            $user->password = $password;
            if (!$user->validation() || !$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
                Tag::setDefault('login', '');
                Tag::setDefault('password', '');
                $this->response->redirect("posts/index");
            }
        }
    }

    /**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            array(
                'id' => $user->id,
                'login' => $user->login
            )
        );
    }

    /**
     * This actions receive the input from the login form
     *
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
            $login = $this->request->getPost('login', 'alphanum');

            $password = $this->request->getPost('password');

            $user = Users::findFirst("login='$login'");
            if ($user != false && $user->checkPassword($password)) {
                $this->_registerSession($user);
                $this->flash->success('Welcome ' . $user->login);
                return $this->forward('index/index');
            }

            $this->flash->error('Wrong email/password');
        }

        return $this->forward('session/index');
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        return $this->forward('index/index');
    }
}
