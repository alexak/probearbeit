<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */
declare(strict_types = 1);

require_once(__DIR__ . '/../Model/User.php');
require_once(__DIR__ . '/UserController.php');


class SessionController
{
    /**
     * @var User | null
     */
    private $user = null;

    /**
     * @var UserController
     */
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController();
        if (isset($_COOKIE['session'])) {
            $this->user = $this->getCurrentUserFromSession();
        }
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return isset($_COOKIE['session']);
    }


    /**
     *
     */
    public function renderForm() : void
    {
        echo file_get_contents(__DIR__ .'/../View/LoginForm.html');
    }

    /**
     * @param string $username
     * @param string $password
     * @return User|null
     *
     * function that checks username/password and logs user in if correct
     */
    public function logIn(string $username, string $password) : ?User
    {
        $this->user = $this->getUserByCredentials($username, $password);
        if($this->user) {
            setcookie('session', $username);  // in realworld a sessiontoken would be used here ...
        }

        return $this->user;
    }

    /**
     * @return User
     *
     * returns a User object associated from current session cookie.
     * in real live a token would be set in cookie and corresponding user would be fetched from database / oAuth ...
     */
    public function getCurrentUserFromSession() : User
    {
        return $_COOKIE['session'] === 'user1' ?  $this->userController->createDummyUser1() : $this->userController->createDummyUser2();
    }


    /**
     * @param string $username
     * @param string $password
     * @return User|null
     *
     * function that creates a new user object
     * in real live this would be done using oAuth, Database, active Directory, ..
     */
    public function getUserByCredentials(string $username, string $password) : ?User
    {
        $user = null;
        $userController = new Usercontroller();
        if (($username === 'user1') && $password === "pass1") {
            $user = $userController->createDummyUser1();
        }
        if (($username === 'user2') && $password === "pass2") {
            $user = $userController->createDummyUser2();
        }

        return $user;
    }


}