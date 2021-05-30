<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */
declare(strict_types = 1);

require_once(__DIR__ . '/../Model/User.php');
require_once(__DIR__ . '/../Model/Film.php');
require_once(__DIR__ . '/SessionController.php');
require_once(__DIR__ . '/OmdbapiController.php');

class FilmPageController
{
    /**
     * @var SessionController
     */
    private $sessionController;


    public function __construct(SessionController $sessionController = null)
    {
        $this->sessionController = $sessionController;
    }

    /**
     * renders the film list page
     */
    public function renderFilmPage(): void
    {
        $content = file_get_contents(__DIR__ .'/../View/FilmPage.html');
        $renderedFilmCards = '';
        $user = $this->sessionController->getCurrentUserFromSession();
        if($user) {
            foreach($user->getFilms() as $film) {
                $renderedFilmCards .= $this->renderFilmCard($film);
            }
        }
        $content = str_replace('{{FILMCARDS}}', $renderedFilmCards, $content);
        echo $content;
    }

    /**
     * @param string $searchTerm
     */
    public function addFilmToConnectedUser(string $searchTerm): void
    {
        $film = $this->searchFilm($searchTerm);
        if ($film) {
            if ($this->addFilmToUser($film)) {
                echo $this->renderFilmCard($film);
            }
        }
    }

    /**
     * @param string $searchTerm
     * @return Film
     *
     * function that fetches a film from public omdbapi database
     */
    private function searchFilm(string $searchTerm): Film
    {
        $omdbapiController = new OmdbapiController();
        return  $omdbapiController->search($searchTerm);
    }

    /**
     * @param Film $film
     * @return string
     *
     * fetches a template for the filmdetail and replaces the film attributes within the template
     */
    protected function renderFilmCard(Film $film): string
    {
        $poster = ($film->getPoster() !== '') ? $film->getPoster() : '';                                                 //@todo: alternative image if empty
        $content = file_get_contents(__DIR__ .'/../View/FilmCard.html');

        return str_replace(['{{POSTER}}', '{{TITLE}}', '{{YEAR}}'], [$poster, $film->getTitle(), $film->getYear()], $content);
    }

    /**
     * @param Film $film
     */
    protected function addFilmToUser(Film $film): void {
        $user = $this->sessionController->getCurrentUserFromSession();
        $returnValue = false;
        if ($user) {
            $userController = new UserController();
            $returnValue = $userController->addNewFilmToUser($user, $film);
        }
        if ($returnValue === true) {
            echo $this->renderFilmCard($film);
        }
    }
}