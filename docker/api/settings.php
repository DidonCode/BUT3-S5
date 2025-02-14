<?php

	/**
	* @class Settings
	*
	* @brief Renvoie les données des dernières musiques aimées par l'utilisateur
	*
	* @file settings.php
	*/
	class Settings {

		static $PER_PAGE = 10;
		static $AUTHORIZED_IMAGE_EXT = array("jpg", "png");
		static $AUTHORIZED_AUDIO_EXT = array("mp3");
		static $AUTHORIZED_VIDEO_EXT = array("mp4");
		static $MAX_UPLOAD_SIZE = 10485760; //10 MB
		static $SESSION_EXPIRE = 5;
		static $HOST_NAME = "http://localhost:8081";
		
	}