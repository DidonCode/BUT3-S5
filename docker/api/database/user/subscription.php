<?php

	/**
	* @class DatabaseUserSubscription
	*
	* @brief Gestion des abonnements de l'utilisateur dans la base de données
	*
	* @file subscription.php
	*/
    class DatabaseUserSubscription {

        /**
		* @param $user Information de l'utilisateur
		* @return \Stripe\Checkout\Session Session stripe pour l'achat
		*
		* @brief Crée une session d'achat stripe est stock l'id pour retouvé l'achat dans le webhook
		* @exception PDOException La requête échoue
		*/
        static function createSession($user, $priceId){
            global $pdoDatabase;

            try {
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'mode' => 'subscription',
                    'line_items' => [[
                        'price' => $priceId,
                        'quantity' => 1,
                    ]],
                    'success_url' => Settings::$STRIPE_SUCCESS,
                    'cancel_url' => Settings::$STRIPRE_CANCEL,
                    'metadata' => [
                        'priceId' => $priceId,
                    ]
                ]);  
                
                $request = $pdoDatabase->prepare("INSERT INTO subscription (user, session) VALUES (?, ?) ON DUPLICATE KEY UPDATE session = VALUES(session)");
                $request->execute(array($user['id'], $session->id));

                return $session;
            } catch(Exception $e){
				throw new Exception("Error to create stripe session".$e->getMessage(), 500);
			}
        }

        /**
		* @param $type Type de l'abonnement
        * @param $createdAt Date de création
        * @param $price Prix payé pour l'abonnement
        * @param $updateAt Date d'expiration ou renouvellement
        * @param $session Identifiant de la session d'achat strip
		* @return bool Confirme si l'exécution a réussi
		*
		* @brief Mise a jour les informations de l'abonnement aprés le payment de l'utilisateur
		* @exception PDOException La requête échoue
		*/
        static function create($type, $createdAt, $price, $updateAt, $session){
            global $pdoDatabase;

            try{
                $request = $pdoDatabase->prepare("UPDATE subscription SET type = ?, created_at = ?, price = ?, update_at = ? WHERE session = ?");
                $request->execute(array($type, $createdAt, $price, $updateAt, $session));

                return true;
            } catch(PDOException $e){
                throw new Exception("Error to create subscription for session: ".$session.". ".$e->getMessage(), 500);
            }
        }

        /**
		* @param $user Information de l'utilisateur
		* @return array Une classe subscription sous la forme d'un tableau associatif
		*
		* @brief Renvoie l'abonnement en cours ou expiré de l'utilisateur
		* @exception PDOException La requête échoue
		*/
        static function get($user){
            global $pdoDatabase;

            try{
                $request = $pdoDatabase->prepare("SELECT * FROM subscription WHERE user = ?");
                $request->execute(array($user['id']));
                $subscriptionData = $request->fetchAll();

                if(count($subscriptionData) >= 1) {
                    $subscription = Subscription::toClass($subscriptionData[0]);

                    if(!$subscription->isExpired()) return $subscription->toString();
                }

                return null;
            } catch(PDOException $e){
                throw new Exception("Error to get subscription for user: ".$user['id'].". ".$e->getMessage(), 500);
            }
        } 

    }