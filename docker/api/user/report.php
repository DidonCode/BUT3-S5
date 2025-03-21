<?php 

require_once("../database/connect/database.php");

include_once("../class/http.php");

include_once("../class/sound.php");
include_once("../class/playlist.php");
include_once("../class/artist.php");

include_once("../database/user/account.php");
include_once("../database/user/report.php");

include_once("../database/artist.php");
include_once("../database/sound.php");
include_once("../database/playlist.php");

include_once("../settings.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if(count(array_keys($_POST)) == 3 AND isset($_POST['sound'], $_POST['reason'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['sound']) OR empty($_POST['reason']) OR 
		!filter_var($_POST['sound'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $sound = DatabaseSound::byId($_POST['sound']);

        if(!DatabaseUserReport::getReportSound($user, $sound)) {
            $report = DatabaseUserReport::addReportSound($user, $sound, $_POST['reason']);
            Http::sendResponse(201, $report);
            return;
        }
        
        Http::sendResponse(200, true);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}

if(count(array_keys($_POST)) == 3 AND isset($_POST['playlist'], $_POST['reason'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['playlist']) OR empty($_POST['reason']) OR 
		!filter_var($_POST['playlist'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $playlist = DatabasePlaylist::byId($_POST['playlist']);

        if(!DatabaseUserReport::getReportPlaylist($user, $playlist)) {
            $report = DatabaseUserReport::addReportPlaylist($user, $playlist, $_POST['reason']);
            Http::sendResponse(201, $report);
            return;
        }
        
        Http::sendResponse(200, true);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}

if(count(array_keys($_POST)) == 3 AND isset($_POST['artist'], $_POST['reason'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['artist']) OR empty($_POST['reason']) OR 
		!filter_var($_POST['artist'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $artist = DatabaseArtist::byId($_POST['artist']);

        if(!DatabaseUserReport::getReportArtist($user, $artist)) {
            $report = DatabaseUserReport::addReportArtist($user, $artist, $_POST['reason']);
            Http::sendResponse(201, $report);
            return;
        }
        
        Http::sendResponse(200, true);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}


if(count(array_keys($_POST)) == 2 AND isset($_POST['sound'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['sound']) OR 
		!filter_var($_POST['sound'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $sound = DatabaseSound::byId($_POST['sound']);

        $result = DatabaseUserReport::getReportSound($user, $sound);
        Http::sendResponse(200, $result);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}

if(count(array_keys($_POST)) == 2 AND isset($_POST['playlist'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['playlist']) OR 
		!filter_var($_POST['playlist'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $playlist = DatabasePlaylist::byId($_POST['playlist']);

        $result = DatabaseUserReport::getReportPlaylist($user, $playlist);
        Http::sendResponse(200, $result);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}

if(count(array_keys($_POST)) == 2 AND isset($_POST['artist'], $_POST['token'])){
	try{

        if(empty($_POST['token']) OR empty($_POST['artist']) OR 
		!filter_var($_POST['artist'], FILTER_VALIDATE_INT)) throw new Exception("Argument not valid", 400);

        $user = DatabaseUserAccount::get($_POST['token']);
        $artist = DatabaseArtist::byId($_POST['artist']);

        $result = DatabaseUserReport::getReportArtist($user, $artist);
        Http::sendResponse(200, $result);
    } catch(Exception $e){
        Http::sendError($e);
    }

    return;
}


Http::sendError(new Exception("Invalid request", 400));
