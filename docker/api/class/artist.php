<?php

	/**
	* @class Artist
	*
	* @brief Gère les données d'un artist
    *
	* @file artist.php
	*/
    class Artist{

        private $id;
        private $pseudo;
        private $image;
        private $banner;
        private $public;

        public function __construct($id, $pseudo, $image, $banner, $public){
            $this->id = $id;
            $this->pseudo = $pseudo;
            $this->image = $image;
            $this->banner = $banner;
            $this->public = $public;
        }

        /**
		* @return int
		*
		* @brief Renvoie l'identifiant de l'artiste
		*/
        public function getId(){
            return $this->id;
        }

        /**
		* @return string
		*
		* @brief Renvoie le pseudo de l'artiste
		*/
        public function getPseudo(){
            return $this->pseudo;
        }

        /**
		* @return string
		*
		* @brief Renvoie l'image de l'artiste
		*/
        public function getImage(){
            return $this->image;
        }

        /**
		* @return string
		*
		* @brief Renvoie la bannière de l'artiste
		*/
        public function getBanner(){
            return $this->banner;
        }

        /**
		* @return int
		*
		* @brief Renvoie la visibilité de l'artiste
		*/
        public function isPublic(){
            return $this->public;
        }

        /**
		* @return array
		*
		* @brief Renvoie les données de l'artiste
		*/
		public function toString(){
			return array(
				"id" => $this->id,
				"pseudo" => $this->pseudo,
				"image" => str_starts_with($this->image, "/storage") ? Settings::$STORAGE_HOST_NAME.$this->image : $this->image,
                "banner" => str_starts_with($this->banner, "/storage") ? Settings::$STORAGE_HOST_NAME.$this->banner : $this->banner,
                "public" => $this->public
			);
		}

        /**
		* @return array
		*
		* @brief Renvoie les données de l'artiste
		*/
        public function toArray(){
            return array(
                $this->id,
                $this->pseudo,
                $this->image,
                $this->banner,
                $this->public
            );
        }

        /**
		* @param $artist Données d'un artiste
		* 
		* @return Artist
		*
		* @brief Renvoie un nouvel artiste à partir des données
		*/
        public static function toClass($artist){
            return new Artist(
                $artist['id'],
                $artist['pseudo'],
                $artist['image'],
                $artist['banner'],
                $artist['public']
            );
        }
    }