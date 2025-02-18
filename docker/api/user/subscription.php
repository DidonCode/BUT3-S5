<?php

    require_once("../libs/stripe/init.php");
    
    require_once("../database/connect/database.php");

    include_once("../class/http.php");

    include_once("../database/user/account.php");

    include_once("../settings.php");

    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");
	header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    \Stripe\Stripe::setApiKey(Settings::$STRIPE_SECRET);

    $payload = @file_get_contents('php://input');

    if(count(array_keys($_POST)) == 2 AND isset($_POST['priceId'], $_POST['token'])){

        try{
            if(empty($_POST['priceId']) || empty($_POST['token'])) throw new Exception("Argument not valid", 400);

            $user = DatabaseUserAccount::get($_POST['token']);

			if(!isset($user)) throw new Exception("Invalid token", 403);

            $request = $pdoDatabase->prepare("SELECT created_at, update_at FROM subscription WHERE user = ?");
            $request->execute(array($user['id']));
            $subscription = $request->fetchAll();

            if(count($subscription) == 1) {
                $createdAt = new DateTime($subscription[0]['created_at']);
                $updatedAt = new DateTime($subscription[0]['update_at']);

                $expired = date_diff($createdAt, $updatedAt);

                if(intval($expired->format('%R%a')) >= 0){
                    Http::sendResponse(200, "You are already subscribed");
                    return;
                }
            }

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'line_items' => [[
                    'price' => $_POST['priceId'],
                    'quantity' => 1,
                ]],
                'success_url' => Settings::$STRIPE_SUCCESS,
                'cancel_url' => Settings::$STRIPRE_CANCEL,
            ]);  
            
            $request = $pdoDatabase->prepare("INSERT INTO subscription (user, session) VALUES (?, ?) ON DUPLICATE KEY UPDATE session = VALUES(session)");
            $request->execute(array($user['id'], $session->id));

            Http::sendResponse(201, $session->id);
            
            return;
        }catch(Exception $e){
            throw new Exception("Error to create strip session ".$e->getMessage(), 400);
        }
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

                    $request = $pdoDatabase->prepare("UPDATE subscription SET created_at = ?, price = ?, update_at = ? WHERE session = ?");
                    $request->execute(array($createdDate->format('Y-m-d'), $eventData['amount_total'] / 100, $updatedData->format('Y-m-d'), $eventData['id']));

                    break;
            }

            return;
        }catch(Exception $e){
            throw new Exception("Error to get stripe payload ".$e->getMessage(), 400);
        }
    }