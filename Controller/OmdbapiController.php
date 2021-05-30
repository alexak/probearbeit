<?php
/**
 * @copyright 2021
 * @license   All rights reserved
 */
declare(strict_types = 1);

require_once(__DIR__ . '/../Model/Film.php');

define('OMDBAPIURL','http://www.omdbapi.com/');
define('APIKEY','93287703');
define('DATABASEID','tt1285016');

//http://www.omdbapi.com/?t=batman&apikey=93287703&i=tt1285016

class OmdbapiController
{
    /**
     * @param string $value
     * @return Film|null
     *
     * searches omdbapi database and returns corresponding film object if found
     */
    public function search(string $value) : ?Film
    {
        $value = trim($value);
        $getparam = [
            'apikey'   => APIKEY
        ];

        if (is_numeric($value) && strlen($value) == 4) {
            $getparam['y'] = $value;
            $getparam['i'] = DATABASEID;
        } else {
            $getparam['t'] = $value;
        }

        $params = http_build_query($getparam);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, OMDBAPIURL . "?" .$params); //using the setopt function to send request to the url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //response returned but stored not displayed in browser
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        $result = curl_exec($ch); //executing request
        $err = curl_error($ch);
        curl_close ($ch);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $responseValues = json_decode($result);
        if (isset($responseValues->Error)) {
            //@todo: error handeling
            return null;
        } else {
            return $this->stdClassToFilmObject($responseValues);
        }
    }


    /**
     * @param $values
     * @return Film
     *
     * translates the json
     */
    private function stdClassToFilmObject($values) : Film
    {
        $film = new Film();
        $title = ($values->Title !== 'N/A') ?  $values->Title : '';
        $film->setTitle($title);
        $film->setYear((int)$values->Year);
        $poster = ($values->Poster !== 'N/A') ?  $values->Poster : '';
        $film->setPoster($poster);

        return $film;
    }
}