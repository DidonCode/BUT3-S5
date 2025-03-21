<?php
require_once("../php/database.php");
require_once("../php/setting.php");

$request_report_sound_table = $pdoDatabase->prepare('SELECT * FROM report_sound');
$request_report_sound_table->execute();
$reportsoundData = $request_report_sound_table->fetchAll();

?>


<h1 class="titre_admin">Signalement Musique</h1>

<div class="report-menu">
    <a href="/web/admin/report_sound" class="report-menu-active">Musique</a>
    <a href="/web/admin/report_playlist" class="report-menu-text">Playlist</a>
    <a href="/web/admin/report_artist" class="report-menu-text">Artiste</a>
</div>

<div class="search-container">
    <input type="text" id="recherche_sound" class="search-box" onkeyup="filtre('recherche_sound', 'table_sound', [0, 1, 2, 3])" placeholder="Rechercher par ID, utilisateur, musique ou raison...">
</div>

<div class="table-container">
    <table class="table contrast-text mt-3 admin_tab" id="table_sound">
        <caption> </caption>
        <thead class="admin_head">
            <tr>
                <th class="contrast-text" scope="col">ID</th>
                <th class="contrast-text" scope="col">Utilisateur</th>
                <th class="contrast-text" scope="col">Musique</th>
                <th class="contrast-text" scope="col">Raison</th>
                <th class="contrast-text" scope="col">Signalement</th>
                <th class="contrast-text" scope="col">Musique</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportsoundData as $report){

            $request_user_pseudo = $pdoDatabase->prepare('SELECT pseudo FROM user WHERE id = ?');
            $request_user_pseudo->execute([$report['user']]);
            $pseudo_user = $request_user_pseudo->fetch(PDO::FETCH_ASSOC);

            $pseudo_verif = isset($pseudo_user['pseudo']) ? htmlspecialchars($pseudo_user['pseudo']) : 'Inconnu';

            $request_musique = $pdoDatabase->prepare('SELECT title FROM sound WHERE id = ?');
            $request_musique->execute([$report['sound']]);
            $musique = $request_musique->fetch(PDO::FETCH_ASSOC);

            $musique_verif = isset($musique['title']) ? htmlspecialchars($musique['title']) : 'Inconnu';

            ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['id']); ?></td>
					<td class="contrast-text">
                        <a href="utilisateur" class="contrast-text">
                            <?php echo $pseudo_verif; ?>
                        </a>
                    </td>
					<td class="contrast-text">
                        <a href="titre" class="contrast-text">
                            <?php echo $musique_verif; ?>
                        </a>
                    </td>
                    <td style="white-space: normal; word-break: break-word;"><?php echo htmlspecialchars($report['reason']); ?></td>
                    <td>
                        <form method="POST" action="php/delete.php">
                            <input type="hidden" name="delete_report_sound" value="<?php echo $report['id']; ?>">
                            <button type="submit" class="btn btn-danger">Annuler</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="php/delete.php">
                            <input type="hidden" name="delete_sound" value="<?php echo $report['sound']; ?>">
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