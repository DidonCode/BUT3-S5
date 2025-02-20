<?php

    /**
	* @class Subscription
	*
	* @brief Gère les données d'un abonnement
	*
	* @file subscription.php
	*/
    class Subscription {

		private $user;
		private $type;
		private $createdAt;
		private $price;
		private $updateAt;
		private $session;

		function __construct($user, $type, $createdAt, $price, $updateAt, $session){
			$this->user = $user;
            $this->type = $type;
			$this->createdAt = new DateTime($createdAt);
			$this->price = $price;
			$this->updateAt = new DateTime($updateAt);
			$this->session = $session;
		}

        function isExpired(){
            $expired = date_diff($this->createdAt, $this->updateAt);
            return !intval($expired->format('%R%a')) >= 0;
        }

		/**
		* @return int
		*
		* @brief Renvoie l'identifiant de l'utilisateur
		*/
		function getUser(){
			return $this->user;
		}

		/**
		* @return string
		*
		* @brief Renvoie le type
		*/
		function getType(){
			return $this->type;
		}

		/**
		* @return DateTime
		*
		* @brief Renvoie la date de création
		*/
		function getCreatedAt(){
			return $this->createdAt;
		}

		/**
		* @return int
		*
		* @brief Renvoie le prix d'achat
		*/
		function getPrice(){
			return $this->price;
		}

		/**
		* @return DateTime
		*
		* @brief Renvoie la date de renouvellement
		*/
		function getUpdateAt(){
			return $this->updateAt;
		}

		/**
		* @return string
		*
		* @brief Renvoie l'identifiant de la session d'achat
		*/
		function getSession(){
			return $this->session;
		}

		/**
		* @return array
		*
		* @brief Renvoie les données de l'abonnement
		*/
		function toString(){
			return array(
				"user" => $this->user,
				"type" => $this->type,
				"createdAt" => $this->createdAt,
				"price" => $this->price,
				"updateAt" => $this->updateAt,
				"session" => $this->session
			);
		}
		
		/**
		* @return array
		*
		* @brief Renvoie les données de l'abonnement
		*/
		function toArray(){
			return array(
				$this->user,
				$this->type,
				$this->createdAt,
				$this->price,
				$this->updateAt,
				$this->session
			);
		}

		/**
		* @param $subscription Données d'un abonnement
		* 
		* @return Subscription
		*
		* @brief Renvoie une nouveau abonnement à partir des données
		*/
        static function toClass($subscription){
            return new Subscription(
                $subscription['user'],
                $subscription['type'],
                $subscription['created_at'],
                $subscription['price'],
                $subscription['update_at'],
                $subscription['session']
            );
        }
	}