//class SFG
class SFG extends EventTarget{


    SFGLink;

    //constructeur
    constructor(newSFGLink) {
        super();
        this.SFGLink = newSFGLink;
    }

    //fonction permettant d'installer SFG
    Install(gameId,password) {

        if (VerifFormulaireInstall()) {
            var datasJSON = {
                'action': "install",
                'gameId': gameId,
                'password': password
            };


            var dbParam = JSON.stringify(datasJSON);


            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //affichage du résultat dans la console
                    console.log(this.responseText);
                    location.reload();
                }
            
            console.log("SFG install");

            //ouverture du fichier XML
            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);
            //envoi de la requète
            xhttp.send();
        }
    }


    Reinstall(password) {

        if (VerifFormulaireReinstall()) {
            var datasJSON = {
                'action': "reinstall",
                'password': password
            };


            var dbParam = JSON.stringify(datasJSON);


            var xhttp = new XMLHttpRequest();


            xhttp.onreadystatechange = function () {
                //si la requête est prête
                if (this.readyState == 4 && this.status == 200) {

                    console.log(this.responseText);
                }
            };


            console.log("SFG reinstall");


            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);

            xhttp.send();
        }
    }


    AjouterInfo(ScoreOrComment, action, ParamUsername, ParamInfo) {

        if (VerifFormulaireAjout(ScoreOrComment)) {


            var datasJSON = {
                'action': action,
                'username': ParamUsername,
                'info': ParamInfo
            };

            var dbParam = JSON.stringify(datasJSON);


            var xhttp = new XMLHttpRequest();


            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    console.log(this.responseText);
                }
            };


            xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);

            xhttp.send();
        }
    }


    RecupererInfos(DivAffichage, action, selectedcol, infoType, ScoreOrComment) {


        var MainContent = DivAffichage;

        MainContent.innerHTML = "";


        var datasJSON = { 'action': action };

        var dbParam = JSON.stringify(datasJSON);


        var xhttp = new XMLHttpRequest();


        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                console.log(this.responseText);


                var json = JSON.parse(this.responseText);
                if (!json["success"]) {

                    var newError = document.createElement("span");

                    newError.setAttribute("class", "ErrorPrint");

                    newError.innerHTML = "erreur " + json["error"]["code"] + " " + json["error"]["message"];

                    MainContent.appendChild(newError);
                } else {

                    var newTable = document.createElement("table");

                    var newHeader = document.createElement("thead");

                    var newline = document.createElement("tr");

                    var newcol = document.createElement("th");

                    if (ScoreOrComment) {
                        newcol.setAttribute("colspan", "2");
                    } else {
                        newcol.setAttribute("colspan", "3");
                    }
e
                    newcol.innerHTML = json["data"]["gameId"];

                    newline.appendChild(newcol);

                    newHeader.appendChild(newline);

                    newTable.appendChild(newHeader);


                    var newTableBody = document.createElement("tbody");
e
                    newline = document.createElement("tr");

                    newcol = document.createElement("td");

                    newcol.innerHTML = "username";

                    newline.appendChild(newcol);

                    newcol = document.createElement("td");

                    newcol.innerHTML = selectedcol;

                    newline.appendChild(newcol);

                    if (!ScoreOrComment) {
                        newcol = document.createElement("td");

                        newcol.innerHTML = "date";

                        newline.appendChild(newcol);
                    }


                    newTableBody.appendChild(newline);


                    for (var i = 0; i < json["data"][selectedcol].length; i++) {

                        newline = document.createElement("tr");

                        newcol = document.createElement("td");

                        newcol.innerHTML = json["data"][selectedcol][i]["username"];

                        newline.appendChild(newcol);

                        newcol = document.createElement("td");

                        newcol.innerHTML = json["data"][selectedcol][i][infoType];

                        newline.appendChild(newcol);

                        if (!ScoreOrComment) {

                            newcol = document.createElement("td");

                            newcol.innerHTML = json["data"][selectedcol][i]["date"];

                            newline.appendChild(newcol);
                        }


                        newTableBody.appendChild(newline);
                    }

                    newTable.appendChild(newTableBody);

                    MainContent.appendChild(newTable);
                }
            }
        };

        xhttp.open("GET", "PHP/SFG.php?request=" + dbParam, true);

        xhttp.send();
    }
}