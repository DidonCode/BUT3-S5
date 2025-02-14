<?php

	/**
	* @class User
	*
	* @brief Gère les données d'un utilisateur
	*
	* @file user.php
	*/
	class User {

		private $id;
		private $email;
		private $pseudo;
		private $grade;
		private $image;
		private $banner;
		private $public;
		private $artist;

		function __construct($id, $email, $pseudo, $grade, $image, $banner, $public, $artist){
			$this->id = $id;
			$this->email = $email;
			$this->pseudo = $pseudo;
			$this->grade = $grade;
			$this->image = $image;
			$this->banner = $banner;
			$this->public = $public;
			$this->artist = $artist;
		}

		/**
		* @return int
		*
		* @brief Renvoie l'identifiant de l'utilisateur
		*/
		function getId(){
			return $this->id;
		}

		/**
		* @return string
		*
		* @brief Renvoie l'adresse mail de l'utilisateur
		*/
		function getEmail(){
			return $this->email;
		}

		/**
		* @return string
		*
		* @brief Renvoie le pseudo de l'utilisateur
		*/
		function getPseudo(){
			return $this->pseudo;
		}

		/**
		* @return int
		*
		* @brief Renvoie le grade de l'utilisateur
		*/
		function getGrade(){
			return $this->grade;
		}

		/**
		* @return string
		*
		* @brief Renvoie l'image de profil de l'utilisateur
		*/
		function getImage(){
			return $this->image;
		}

		/**
		* @return string
		*
		* @brief Renvoie la bannière de l'utilisateur
		*/
		function getBanner(){
			return $this->banner;
		}

		/**
		* @return int
		*
		* @brief Renvoie la visibilité de l'utilisateur
		*/
		function isPublic(){
			return $this->public;
		}

		/**
		* @return int
		*
		* @brief Renvoie le statut artiste de l'utilisateur
		*/
		function getArtist(){
			return $this->artist;
		}

		/**
		* @return array
		*
		* @brief Renvoie les données de l'utilisateur
		*/
		function toString(){
			return array(
				"id" => $this->id,
				"email" => $this->email,
				"pseudo" => $this->pseudo,
				"grade" => $this->grade,
				"image" => Settings::$HOST_NAME.$this->image,
				"banner" => Settings::$HOST_NAME.$this->banner,
				"public" => $this->public,
				"artist" => $this->artist
			);
		}

		/**
		* @param $user Données d'utilisateur
		* 
		* @return array
		*
		* @brief Renvoie les données filtrées de l'utilisateur
		*/
		static function toFilter($user){
			return array(
				"id" => $user['id'],
				"email" => $user['email'],
				"pseudo" => $user['pseudo'],
				"image" => Settings::$HOST_NAME.$user['image'],
				"banner" => Settings::$HOST_NAME.$user['banner'],
				"public" => $user['public']
			);
		}

		/**
		* @return array
		*
		* @brief Renvoie les données de l'utilisateur
		*/
		function toArray(){
			return array(
				$this->id,
				$this->email,
				$this->pseudo,
				$this->grade,
				$this->image,
				$this->banner,
				$this->public,
				$this->artist
			);
		}

		/**
		* @param $user Données d'utilisateur
		* 
		* @return User
		*
		* @brief Renvoie un nouvel utilisateur à partir des données
		*/
		static function toClass($user){
			return new User(
				$user['id'],
				$user['email'],
				$user['pseudo'],
				$user['grade'],
				$user['image'],
				$user['banner'],
				$user['public'],
				$user['artist']
			);
		}
	}