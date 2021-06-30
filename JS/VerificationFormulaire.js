function VerifFormulaireAjout(ScoreOrComment) {

    var FromValide = true;
    var username = "";

    var ErreurUsername = "";

    if (ScoreOrComment) {
        var Chiffres = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '+'];

        var score = document.getElementById("score").value;
        username = document.getElementById("usernameScore").value;
        
        ErreurUsername = document.getElementById("errorUsernameScore");
        var ErreurScore = document.getElementById("errorScore");

        ErreurUsername.innerHTML = "";
        ErreurScore.innerHTML = "";

        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        if (score == "") {
            ErreurScore.innerHTML = "Veuillez entrer un score";
            FromValide = false;
        } else {
            for (var i = 0; i < score.length; i++) {
                if (Chiffres.indexOf(score[0]) == -1) {
                    ErreurScore.innerHTML = "Un score n'est composé que de chiffres";
                    FromValide = false;
                    return FromValide;
                }
            }
            if (score < 0) {
                ErreurScore.innerHTML = "Un score n'est pas négatif";
                FromValide = false;
            }
        }
    } 
    else {
        var comment = document.getElementById("comment").value;
        username = document.getElementById("usernameComment").value;

        ErreurUsername = document.getElementById("errorUsernameComment");
        var ErreurComment = document.getElementById("errorComment");

        ErreurUsername.innerHTML = "";
        ErreurComment.innerHTML = "";

        if (username == "") {
            ErreurUsername.innerHTML = "Veuillez entrer un nom d'utilisateur";
            FromValide = false;
        }

        if (comment == "") {
            ErreurComment.innerHTML = "Veuillez entrer un commentaire";
            FromValide = false;
        }
    }

    return FromValide;
}

function VerifFormulaireInstall() {

    var FromValide = true;

    var gameId = document.getElementById("gameId").value;
    var password = document.getElementById("password").value;


    var ErreurGameId = document.getElementById("errorGameId");
    var ErreurPassword = document.getElementById("errorPassword");

    ErreurGameId.innerHTML = "";
    ErreurPassword.innerHTML = "";

    if (gameId == "") {
        ErreurGameId.innerHTML = "Veuillez entrer un nom de jeu";
        FromValide = false;
    }

    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    return FromValide;
}

function VerifFormulaireReinstall() {

    var FromValide = true;

    var password = document.getElementById("password").value;;

    var ErreurPassword = document.getElementById("errorPassword");

    ErreurPassword.innerHTML = "";


    if (password == "") {
        ErreurPassword.innerHTML = "Veuillez entrer un mot de passe";
        FromValide = false;
    }

    return FromValide;
}