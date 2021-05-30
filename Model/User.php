<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */

require_once(__DIR__ . '/Film.php');

class User
{
    private $id;
    private $firstname;
    private $name;
    private $username;
    private $password;
    private $films;

    public function __construct()
    {
        $this->films = array();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return Film[]
     */
    public function getFilms(): array
    {
        return $this->films;
    }

    /**
     * @param array $films
     */
    public function setFilms(array $films): void
    {
        $this->films = $films;
    }

    public function addFilm(Film $film): void
    {
        $this->films[] = $film;
    }

//    /**
//     * @param string $title
//     * @return bool
//     *
//     * checks, if film is already in list or not
//     */
//    public function hasFilmByTitleYear(string $title, int $year): bool
//    {
//        foreach ($this->getFilms() as $film) {
//            if (($film->getTitle() === $title) && ($film->getYear() === $year)){
//                return true;
//            }
//        }
//
//        return false;
//    }
}