<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */
declare(strict_types = 1);

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'alex1234';
const DB_DATABSE = 'intellishop-probeaufgabe';

require_once(__DIR__ . '/SessionController.php');
require_once(__DIR__ . '/FilmPageController.php');

/*
 *  class that does the main logic of the application
 */
class ApplicationController
{
    /**
     * @var SessionController
     */
    private $sessionController;

    /**
     * @var FilmPageController
     */
    private $filmPageController;


    public function __construct()
    {
        $this->sessionController = new SessionController();
        $this->filmPageController = new FilmPageController($this->sessionController);
    }

    /* creates a new application */
    public function run(): void
    {
        if (!$this->sessionController->isActive()) {
            $this->sessionController->renderForm();
        } else {
            $this->filmPageController->renderFilmPage();
        }
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     *
     * checks if the login is correct. If correct, it renders the main screen. If not, it reshows login screen
     */
    public function checkLoginAndRedirect(string $username, string $password) : void
    {
        $this->sessionController->logIn($username, $password);
        $this->run();
    }

    /**
     * @param string $searchTerm
     * @return string
     *
     * searches for film and adds it to the current user
     */
    public function addFilmToConnectedUser(string $searchTerm): void {
        $this->filmPageController->addFilmToConnectedUser($searchTerm);
    }
}