<?php

    require_once("../libs/stripe/init.php");
    
    require_once("../database/connect/database.php");

    include_once("../class/http.php");

    include_once("../settings.php");

    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");
	header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    \Stripe\Stripe::setApiKey(Settings::$STRIPE_SECRET);

    if(count(array_keys($_POST)) == 1 AND isset($_POST['priceId'])){

        try{
            if(empty($_POST['priceId'])) throw new Exception("Argument not valid", 400);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'line_items' => [[
                    'price' => $_POST['priceId'], // Utilise l'ID du plan Stripe
                    'quantity' => 1,
                ]],
                'success_url' => Settings::$STRIPE_SUCCESS,
                'cancel_url' => Settings::$STRIPRE_CANCEL,
            ]);  
            
            Http::sendResponse(201, $session->id);
        }catch(Exception $e){
            Http::sendError($e);
        }
    }