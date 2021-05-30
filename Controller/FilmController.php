<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */
declare(strict_types = 1);

require_once(__DIR__ . '/../Model/Film.php');


class FilmController
{
    public function getFilmIdByTitleYear(Film $film): ?Film
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABSE);
        $title = $mysqli->real_escape_string($film->getTitle());
        $year = $film->getYear();
        $sql = "SELECT id FROM films WHERE title='$title' AND year=$year ;";
        $result = $mysqli->query($sql);
        $results = $result->fetch_row();
        $result->close();
        $mysqli->close();

        if (!$results) {
            return null;
        }

        $film->setId((int)$results[0]);

        return $film;
    }


    public function insertFilm(Film $film): Film
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABSE);
        $statement = $mysqli->prepare( "INSERT INTO films (title, year, poster) VALUES (?, ?, ?)");
        $statement->bind_param('sis', $title, $year, $poster);
        $title = $film->getTitle();
        $year = $film->getYear();
        $poster = $film->getPoster();
        $statement->execute();

        $film->setId($statement->insert_id);

        $statement->close();
        $mysqli->close();

        return $film;
    }

    /**
     * @param $film
     * @return int
     *
     * adds a new film in table. If the film already exists the film object will be completed
     */
    public function insertFilmIfNotExists(Film $film): Film
    {
        $dbFilm = $this->getFilmIdByTitleYear($film);
        if (!$dbFilm) {
            $dbFilm = $this->insertFilm($film);
        }

        return $dbFilm;
    }

    public function delete($film): void
    {
        //@todo: add mysql insert here
    }
}