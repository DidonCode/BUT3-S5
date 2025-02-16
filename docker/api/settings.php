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
		static $STORAGE_HOST_NAME = "http://localhost:8081";

		static $AUTHORIZED_IMAGE_EXT = array("jpg", "png");
		static $AUTHORIZED_AUDIO_EXT = array("mp3");
		static $AUTHORIZED_VIDEO_EXT = array("mp4");
		static $MAX_UPLOAD_SIZE = 10485760; //10 MB

		static $SESSION_EXPIRE = 5;

		static $STRIPE_SECRET = "sk_test_51Qrwg3Pfaun29rdGXHdIxIQAkp83EvJkx4FRk8nM712omkqWjCtRswf82W76K62Etuj3jnvObrM4JXHNGPo1ER1300W3rxLKzI";
		static $STRIPE_SUCCESS = "http://localhost:8080/web/account";
		static $STRIPRE_CANCEL = "http://localhost:8080/web/subscription";
	}