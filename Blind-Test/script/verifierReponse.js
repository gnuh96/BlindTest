//Recupere le cookie demander
function getCookie(sName) {
    let oRegex = new RegExp("(?:; )?" + sName + "=([^;]*);?");

    if (oRegex.test(document.cookie)) {
        return decodeURIComponent(RegExp["$1"]);
    } else {
        return null;
    }
}

//Envoie un cookie avec une valeur
function setCookie(sName, sValue) {
    let today = new Date(), expires = new Date();
    expires.setTime(today.getTime() + (365*24*60*60*1000));
    document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}

let reponseTotale = false;
let reponseAuteur = false;
let reponseTitre = false;

//Verifie la reponse
function check(){
    let tab = getSongs()[getCookie("idSong")].toLowerCase().split("-");
    let reponse = document.getElementById("reponse").value.toLowerCase();

    let author = tab[0].trim();
    let title = tab[1].trim();

    let s = parseInt(getCookie("score"));
    let form = document.getElementById('formSub');
    let danger = $(".alert-danger");
    let success = $(".alert-success");

    let successText = success[0].children[0];

    if(reponse.includes(author) && reponse.includes(title) && !reponseTotale){
        if(reponseTitre || reponseAuteur){
            s += 2;
        }else if(reponseAuteur && reponseTitre) {
            //On ne fait rien
        }else {
            s += 3;
        }

        setCookie("score",s.toString());

        let strong = document.createElement("Strong");
        strong.appendChild(document.createTextNode("Bonne réponse !"));
        success[0].children[0].remove();
        success[0].append(strong);

        success.slideDown('fast');
        setTimeout(function(){
            success.slideUp('fast');
            reponseTotale = true;
            form.submit();
        }, 2000);
    }else if(reponse.includes(author) || reponse.includes(title)){
        //Si la réponse est l'auteur
        if(reponse.includes(author) && !reponseAuteur){
            reponseAuteur = true;
            s += 1;
            setCookie("score",s.toString());

            if(!reponseTitre){
                let addText = "Mais tu peux mieux faire !";
                successText.append(addText);
                success.slideDown('fast');
                setTimeout(function(){
                    success.slideUp('fast');
                }, 2000);
            }else{
                let strong = document.createElement("Strong");
                strong.appendChild(document.createTextNode("Bonne réponse !"));
                success[0].children[0].remove();
                console.log(success[0].children[0]);
                success[0].append(strong);

                success.slideDown('fast');
                setTimeout(function () {
                    success.slideUp('fast');
                    form.submit();
                }, 2000);
            }
        }

        //Si la réponse est le titre
        if(reponse.includes(title) && !reponseTitre){
            reponseTitre = true;
            s += 1;
            setCookie("score",s.toString());

            if(!reponseAuteur){
                let addText = "Mais tu peux mieux faire !";
                successText.append(addText);
                success.slideDown('fast');
                setTimeout(function(){
                    success.slideUp('fast');
                }, 2000);
            }else{
                let strong = document.createElement("Strong");
                strong.appendChild(document.createTextNode("Bonne réponse !"));
                success[0].children[0].remove();
                console.log(success[0].children[0]);
                success[0].append(strong);

                success.slideDown('fast');
                setTimeout(function () {
                    success.slideUp('fast');
                    form.submit();
                }, 2000);
            }
        }

    }else{
        danger.slideDown('fast');
        setTimeout(function(){
            danger.slideUp('fast');
        }, 2000);
    }
}

