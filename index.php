<?php
/**
 * This is a basic router .. in reallife router would be handeled by framework using <url>/<controller>/<method> structure
 */
declare(strict_types = 1);

require_once(__DIR__ . '/Controller/ApplicationController.php');


$applicationController = new ApplicationController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login' : $applicationController->checkLoginAndRedirect($_GET['username'], $_GET['password']); break;
        case 'search' : $applicationController->addFilmToConnectedUser($_GET['value']);
    }
}
else {
    $applicationController->run();
}