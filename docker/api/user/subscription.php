<?php

    require_once("../libs/stripe/init.php");
    
    require_once("../database/connect/database.php");

    include_once("../class/subscription.php");

    include_once("../class/http.php");

    include_once("../database/user/subscription.php");
    include_once("../database/user/account.php");

    include_once("../settings.php");

    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");
	header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    \Stripe\Stripe::setApiKey(Settings::$STRIPE_SECRET);

    $subscriptions = array(
        "price_1Qt7KWPfaun29rdGUCACU0xz" => "premium",
        "price" => "basic"
    );

    if(count(array_keys($_POST)) == 1){
        $payload = @file_get_contents('php://input');
    }

    if(count(array_keys($_POST)) == 2 AND isset($_POST['priceId'], $_POST['token'])){

        try{
            if(empty($_POST['priceId']) || empty($_POST['token'])) throw new Exception("Argument not valid", 400);

            $user = DatabaseUserAccount::get($_POST['token']);

			if(!isset($user)) throw new Exception("Invalid token", 403);
            
            if(!$subscriptions[$_POST['priceId']]) throw new Exception("Product not valid", 400);

            if(!DatabaseUserSubscription::get($user)) throw new Exception("You have already subscription", 200);

            $session = DatabaseUserSubscription::createSession($user, $_POST['priceId']);

            Http::sendResponse(201, $session->id);
        }catch(Exception $e){
            Http::sendError($e);
        }

        return;
    }
    if(count(array_keys($_POST)) == 1 AND isset($_POST['token'])){

        try{
            if(empty($_POST['token'])) throw new Exception("Argument not valid", 400);

            $user = DatabaseUserAccount::get($_POST['token']);

			if(!isset($user)) throw new Exception("Invalid token", 403);
            
            $subscription = DatabaseUserSubscription::get($user);

            Http::sendResponse(200, $subscription);
        }catch(Exception $e){
            Http::sendError($e);
        }

        return;
    }

    if(isset($payload)){
        try{
            $event = json_decode($payload, true);

            if(!$event) return;

            $eventType = $event['type'];
            $eventData = $event['data']['object'];

            switch ($eventType) {
                case 'checkout.session.completed':
                    $createdDate = new DateTime();
                    $createdDate->setTimestamp($eventData['created']);

                    $updatedData = new DateTime();
                    $updatedData->setTimestamp($eventData['created']);
                    $updatedData->modify("+1 month");

                    DatabaseUserSubscription::create(
                        $subscriptions[$eventData['metadata']['priceId']],
                        $createdDate->format('Y-m-d'), 
                        $eventData['amount_total'] / 100, 
                        $updatedData->format('Y-m-d'), 
                        $eventData['id']
                    );

                    break;
            }
        }catch(Exception $e){
            Http::sendError($e);
        }

        return;
    }

    Http::sendError(new Exception("Invalid request", 400));