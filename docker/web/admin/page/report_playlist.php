<?php
require_once("../php/database.php");
require_once("../php/setting.php");

$request_report_playlist_table = $pdoDatabase->prepare('SELECT * FROM report_playlist');
$request_report_playlist_table->execute();
$reportplaylistData = $request_report_playlist_table->fetchAll();

?>


<h1 class="titre_admin">Signalement Playlist</h1>

<div class="report-menu">
    <a href="/web/admin/report_sound" class="report-menu-text">Musique</a>
    <a href="/web/admin/report_playlist" class="report-menu-active">Playlist</a>
    <a href="/web/admin/report_artist" class="report-menu-text">Artiste</a>
</div>

<div class="search-container">
    <input type="text" id="recherche_playlist" class="search-box" onkeyup="filtre('recherche_playlist', 'table_playlist', [0, 1, 2, 3])" placeholder="Rechercher par ID, utilisateur, playlist ou raison...">
</div>

<div class="table-container">
    <table class="table contrast-text mt-3 admin_tab" id="table_playlist">
		<caption> </caption>
        <thead class="admin_head">
            <tr>
                <th class="contrast-text" scope="col">ID</th>
                <th class="contrast-text" scope="col">Utilisateur</th>
                <th class="contrast-text" scope="col">Playlist</th>
                <th class="contrast-text" scope="col">Raison</th>
				<th class="contrast-text" scope="col">Signalement</th>
                <th class="contrast-text" scope="col">Playlist</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportplaylistData as $report){

            $request_user_pseudo = $pdoDatabase->prepare('SELECT pseudo FROM user WHERE id = ?');
            $request_user_pseudo->execute([$report['user']]);
            $pseudo_user = $request_user_pseudo->fetch(PDO::FETCH_ASSOC);

            $pseudo_verif = isset($pseudo_user['pseudo']) ? htmlspecialchars($pseudo_user['pseudo']) : 'Inconnu';

			$request_playlist = $pdoDatabase->prepare('SELECT title FROM playlist WHERE id = ?');
            $request_playlist->execute([$report['playlist']]);
            $playlist = $request_playlist->fetch(PDO::FETCH_ASSOC);

            $playlist_verif = isset($playlist['title']) ? htmlspecialchars($playlist['title']) : 'Inconnu';

            ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['id']); ?></td>
					<td class="contrast-text">
                        <a href="utilisateur" class="contrast-text">
                            <?php echo $pseudo_verif; ?>
                        </a>
                    </td>
					<td class="contrast-text">
                        <a href="playlist" class="contrast-text">
                            <?php echo $playlist_verif; ?>
                        </a>
                    </td>
                    <td style="white-space: normal; word-break: break-word;"><?php echo htmlspecialchars($report['reason']); ?></td>
					<td>
                        <form method="POST" action="php/delete.php">
                            <input type="hidden" name="delete_report_playlist" value="<?php echo $report['id']; ?>">
                            <button type="submit" class="btn btn-danger">Annuler</button>
                        </form>
                    </td>
					<td>
                        <form method="POST" action="php/delete.php">
                            <input type="hidden" name="delete_playlist" value="<?php echo htmlspecialchars($report['playlist']); ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
			<?php
				}
            ?>
        </tbody>
    </table>
</div>