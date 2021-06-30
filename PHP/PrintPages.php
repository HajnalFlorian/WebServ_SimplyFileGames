<?php

	function PrintInstallPage(){

		echo '<h1>Simply File Games</h1>';

		echo '<fieldset id="Install">';

		echo '<legend id="instalLegend">
				Installation
			</legend>';

		echo '<form class="MainFormulaire">';

		echo' <label id="labelGameId" for="gameId">Nom de votre jeu :</label>
				<span id="errorGameId"></span>
				<input type="text" id="gameId" placeholder="nom de votre jeu" />';

		echo '<label for="password">Mot de passe :</label>
				<span id="errorPassword"></span>
				<input type="password" id="password"/>';

		echo'<input type="button" id="InstallButton" value="Install" onclick=\'InstallSFG()\'/>';
		echo'</form>';

		echo'</fieldset>';
	}

	function PrintHomePage(){
		echo '<h1>Simply File Games</h1>';

		echo '<h2>Bienvenue</h2>';

		echo '<section>';

		echo '<article>';

		echo '<p>Voici des ressources de Simply File Games :</p>';

		echo '<ul>';

		echo '<li><a href = "?page=Highscores">Highscores</a></li>';
		echo '<li><a href = "?page=Comments">Commentaires</a></li>';
		echo '<li><a href = "?page=Reset">Réinstallation</a></li>';

		echo '</ul>';

		echo '</article>';

		echo '</section>';
	}

	function PrintHighscoresPage(){

		echo '<h1>Simply File Games</h1>';

		echo'<fieldset id="AjoutUnScore">';

		echo'<legend>
				Gestion de highscores
			</legend>';

		echo'<form class="MainFormulaire">';

		echo'<label for="usernameScore">Username :</label>
			 <span id="errorUsernameScore"></span>
			 <input type="text" id="usernameScore" placeholder="username" />';

		echo'<label for="score">Score :</label>
			 <span id="errorScore"></span>
			 <input type="number" id="score" placeholder="00" />';

		echo'<input type="button" id="AjoutButtonScore" value="Ajouter" onclick=\'AjouterUneInfo(true,"set_highscore","usernameScore","score")\'/>';

		echo'<input type="button" id="RecupButtonScore" value="Recuperer" onclick=\'RecupererInfo("AffichageDuFichierJSONScore","get_highscores","scores","score",true)\'/>';

		echo'</form>';

		echo'</fieldset>';

		echo'<div id="AffichageDuFichierJSONScore">
    
			 </div>';
	}


	function PrintCommentsPage(){

		echo '<h1>Simply File Games</h1>';

		echo'<fieldset id="AjoutUnCommentaire">';

		echo'<legend>
				Gestion de commentaires
			 </legend>';

		echo'<form class="MainFormulaire">';

		echo'<label for="usernameComment">Username :</label>
			 <span id="errorUsernameComment"></span>
			 <input type="text" id="usernameComment" placeholder="username" />';

		echo'<label for="comment">Commentaire :</label>
			 <span id="errorComment"></span>
			 <textarea id="comment" rows="5" cols="35" placeholder="votre commentaire"></textarea>';

		echo'<input type="button" id="AjoutButtonComment" value="Ajouter" onclick=\'AjouterUneInfo(false,"set_comment","usernameComment","comment")\'/>';

		echo'<input type="button" id="RecupButtonComment" value="Recuperer" onclick=\'RecupererInfo("AffichageDuFichierJSONComment","get_comments","comments","comment",false)\'/>';

		echo'</form>';

		echo'</fieldset>';

		echo'<div id="AffichageDuFichierJSONComment">
    
			 </div>';
	}


	function PrintResetPage(){


		echo '<h1>Simply File Games</h1>';


		echo'<fieldset id="Install">';


		echo'<legend id="instalLegend">
			 Réinstallation
			 </legend>';


		echo'<form class="MainFormulaire">';


		echo'<label id="labelGameId" for="gameId">Nom de votre jeu : </label>';

		if(file_exists('./data/config.json')){

			$file_content_json = file_get_contents('./data/config.json');

			$file_content_array = json_decode($file_content_json,true);

			echo $file_content_array['gameId'];
		}else{
			echo "Pas de jeu répertorié.";
		}
		echo'<br/>';

		echo'<label for="password">Mot de passe :</label>
			 <span id="errorPassword"></span>
			 <input type="password" id="password"/>';


		echo '<input type="button" id="InstallButton" value="Install" onclick=\'ReinstallSFG()\'/>';
		

		echo'</form>';


		echo'</fieldset>';
	}
?>