<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */

require_once(__DIR__ . '/../Model/User.php');
require_once(__DIR__ . '/../Model/Film.php');
require_once(__DIR__ . '/FilmController.php');


class UserController {

    public function getFilmsForUser(User $user): array
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABSE);
        $username = $user->getUsername();
        $sql = "SELECT title, year, poster FROM films JOIN user_films ON films.id = user_films.film_id WHERE user_films.username = '$username';";
        $result = $mysqli->query($sql);
        $films = [];
        while($row = $result->fetch_assoc()) {
            $film = new Film();
            $film->setTitle($row['title']);
            $film->setYear($row['year']);
            $film->setPoster($row['poster']);
            $films[] = $film;
        }
        $result->close();
        $mysqli->close();
        return $films;
    }

    /**
     * @param User $user
     * @param Film $film
     * @return bool
     *
     * adds a film to user if this one is not already present and saves in database
     */
    public function addNewFilmToUser(User $user, Film $film): bool
    {
        if (!$this->userHasFilmByTitleYear($user, $film)) {
            $film = $this->saveFilm($film);
            $this->linkFilmToUser($user, $film);

            return true;
        }
        return false;
    }

    protected function userHasFilmByTitleYear(User $user, Film $film): bool
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABSE);
        $title = $mysqli->real_escape_string($film->getTitle());
        $year = $film->getYear();
        $username = $user->getUsername();
        $sql = "SELECT user_films.id FROM user_films JOIN films ON user_films.film_id = films.id WHERE films.title='$title' AND films.year=$year AND user_films.username = '$username';";
        $result = $mysqli->query($sql);
        $resultNumRows = $result->num_rows;
        $result->close();
        $mysqli->close();

        return !(($resultNumRows === 0));
    }

    /**
     * @param Film $film
     * @return Film
     *
     * creates a new film entry if the film does not exists otherwise update current film object
     */
    protected function saveFilm(Film $film): Film
    {
        $filmController = new FilmController();
        return $filmController->insertFilmIfNotExists($film);
    }

    protected function linkFilmToUser(User $user, Film $film): void
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABSE);
        $statement = $mysqli->prepare( 'INSERT INTO user_films (username, film_id) VALUES (?, ?)');
        $statement->bind_param('si', $username, $filmId);
        $username = $mysqli->real_escape_string($user->getUsername());
        $filmId = $film->getId();
        $statement->execute();
        $statement->close();
        $mysqli->close();
    }

    // --- dummy tests --

    /**
     * @return User
     * creates a dummy user for testing purposes
     */
    public function createDummyUser1(): User
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('user1');
        $user->setFirstname('Marie');
        $user->setName('Curie');
        $user->setFilms($this->getFilmsForUser($user));

        return $user;
    }

    /**
     * @return User
     * creates a dummy user for testing purposes
     */
    public function createDummyUser2(): User
    {
        $user = new User();
        $user->setId(2);
        $user->setUsername('user2');
        $user->setFirstname('Niels');
        $user->setName('Bohr');
        $user->setFilms($this->getFilmsForUser($user));

        return $user;
    }
}