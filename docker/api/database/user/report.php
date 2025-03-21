<?php

class DatabaseUserReport {

    public static function addReportSound($user, $sound, $reason) {
        global $pdoDatabase;

        try {
            $request = $pdoDatabase->prepare("INSERT INTO report_sound (user, sound, reason) VALUES (?, ?, ?)");
            $request->execute(array($user['id'], $sound['id'], $reason));
			
			return true;
        } catch (PDOException $e) {
            throw new Exception("Error to add report for sound : " .$sound."." . $e->getMessage(), 400);
        }
    }

	public static function getReportSound($user, $sound){
		global $pdoDatabase;
		
		try {

			$request = $pdoDatabase->prepare("SELECT COUNT(id) FROM report_sound WHERE user = ? AND sound = ?");
			$request->execute(array($user['id'], $sound['id']));
			$alreadyReport = $request->fetchAll();

			return $alreadyReport[0][0] > 0;
		} catch (PDOException $e) {
            throw new Exception("Error to machin report for sound : " .$sound."." . $e->getMessage(), 400);
        }
	}

    public static function addReportPlaylist($user, $playlist, $reason) {
        global $pdoDatabase;

        try {
            $request = $pdoDatabase->prepare("INSERT INTO report_playlist (user, playlist, reason) VALUES (?, ?, ?)");
            $request->execute([$user['id'], $playlist['id'], $reason]);
			
			return true;
        } catch (PDOException $e) {
            throw new Exception("Error to add report for playlist : " .$playlist."." . $e->getMessage(), 400);
        }
    }

	public static function getReportPlaylist($user, $playlist){
		global $pdoDatabase;

		try {

			$request = $pdoDatabase->prepare("SELECT COUNT(id) FROM report_playlist WHERE user = ? AND playlist = ?");
			$request->execute(array($user['id'], $playlist['id']));
			$alreadyReport = $request->fetchAll();

			return $alreadyReport[0][0] > 0;
		} catch (PDOException $e) {
            throw new Exception("Error to machin report for sound : " .$sound."." . $e->getMessage(), 400);
        }
	}

    public static function addReportArtist($user, $artist, $reason) {
        global $pdoDatabase;

        try {
            $request = $pdoDatabase->prepare("INSERT INTO report_artist (user, artist, reason) VALUES (?, ?, ?)");
            $request->execute([$user['id'], $artist['id'], $reason]);
			
			return true;
        } catch (PDOException $e) {
            throw new Exception("Error to add report for artist : " .$artist."." . $e->getMessage(), 400);
        }
    }

	public static function getReportArtist($user, $artist){
		global $pdoDatabase;

		try {

			$request = $pdoDatabase->prepare("SELECT COUNT(id) FROM report_artist WHERE user = ? AND artist = ?");
			$request->execute(array($user['id'], $artist['id']));
			$alreadyReport = $request->fetchAll();

			return $alreadyReport[0][0] > 0;
		} catch (PDOException $e) {
            throw new Exception("Error to machin report for sound : " .$sound."." . $e->getMessage(), 400);
        }
	}
}
