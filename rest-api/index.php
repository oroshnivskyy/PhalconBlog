<?php
$config = include(__DIR__ . "/../app/config/config.php");
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        'controllers',
        '../app/models'
    )
)->register();

$app = new \Phalcon\Mvc\Micro();

$di = new \Phalcon\DI\FactoryDefault();
/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set(
    'db',
    function () use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    }
);
/**
 * Start the session the first time some component request the session service
 */
$di->set(
    'session',
    function () {
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    }
);
$app->setDI($di);

//Retrieves all comments from post
$app->get(
    '/api/comments/{post_id:[0-9]+}',
    function ($post_id) use ($app) {
        if ($app->request->isAjax()) {
            $comments = Comments::find(array("posts_id='{$post_id}'"))->toArray();
            $response = [
                'status' => 'OK',
                'comments' => array_map(
                    function ($c) {
                        return $c['content'];
                    },
                    $comments
                )
            ];
            echo json_encode($response);
        }
    }
);

/**
 * Adds new comment
 */
$app->post(
    '/api/comments',
    function () use ($app) {
        if ($app->request->isAjax()) {
            $comment_array = json_decode($app->request->getRawBody());
            $comment = new Comments();
            $comment->users_id = $app->session->get('auth')['id'];
            $comment->content = $app->request->getPost("content", "striptags");
            $comment->posts_id = $app->request->getPost("posts_id", "striptags");

            if (!$comment->validation() || !$comment->save()) {
                foreach ($comment->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }
                $response = array('status' => 'ERROR', 'messages' => $errors);
            } else {
                $response = array('status' => 'OK');
            }
            echo json_encode($response);
        }
    }
);

//Deletes comment based on primary key
$app->delete(
    '/api/comment{comment_id:[0-9]+}',
    function () {

    }
);

try {
    $app->handle();
} catch (PDOException $e) {
    echo json_encode(array('status' => 'ERROR'));
}
catch (Exception $e) {
    echo json_encode(array('status' => 'ERROR'));
}