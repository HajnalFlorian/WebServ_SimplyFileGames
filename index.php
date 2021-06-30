<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>Accueil</title>
    <link rel="stylesheet" href="CSS/Style.css" />
    <script type="text/javascript" src="./JS/VerificationFormulaire.js" charset="utf-8"></script>
    <script type="text/javascript" src="./JS/SFG_client.js" charset="utf-8"></script>
</head>

<body>
	
	<nav id="Nav">
        <h1>Acceuil :</h1>
        <a href="index.php" class="navLink">acceuil</a>
    </nav>

	<?php

		include "PHP/PrintPages.php";
		if(!file_exists("./data/config.json")){
			PrintInstallPage();
		}
		else if(isset($_GET["page"])){
			
			switch($_GET["page"]){
				case "Highscores":
					PrintHighscoresPage();
					break;
				case "Comments":
					PrintCommentsPage();
					break;
				case "Reset":
					PrintResetPage();
					break;
				default:
					PrintHomePage();
					break;
			}
		}
		else{

			PrintHomePage();
		}
	?>
    
    <script>


		mySFG = new SFG("PHP/SFG.php");


		function InstallSFG(){
			mySFG.Install(document.getElementById("gameId").value,document.getElementById("password").value);
		}

        function ReinstallSFG(){
			mySFG.Reinstall(document.getElementById("password").value);
        }

        function AjouterUneInfo(ScoreOrComment,action,idParamUsername,idParamInfo){
			mySFG.AjouterInfo(ScoreOrComment,action,document.getElementById(idParamUsername).value,document.getElementById(idParamInfo).value);
        }

		function RecupererInfo(idDivAffichage,action,selectedcol,infoType,ScoreOrComment){
			mySFG.RecupererInfos(document.getElementById(idDivAffichage),action,selectedcol,infoType,ScoreOrComment);
        }
    </script>
	
</body>

</html>