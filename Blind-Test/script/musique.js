//Recupere les musiques
let musiques = getSongs();
//Prend la musique actuel
let musique = musiques[getCookie("idSong")];
//Joue la musique
let sound = new Howl({
    src: ['../../Musiques/' +musique +'.mp3'],
    volume: 0.7,
    autoplay : true,
    preload: true
});


//Renvoie le cookie
function getCookie(sName) {
    let oRegex = new RegExp("(?:; )?" + sName + "=([^;]*);?");

    if (oRegex.test(document.cookie)) {
        return decodeURIComponent(RegExp["$1"]);
    } else {
        return null;
    }
}

//Remplace les caracteres
function replaceCharacters(tab){
    let res = [];
    for(let i=0; i < tab.length; i++){
        res[i] = tab[i].split('+').join(' ');
    }

    return res;
}
//Renvoi un tableau contenant les musiques
function getSongs(){
    let songsTab = getCookie("tabSongs").split("','");
    return replaceCharacters(songsTab)
}

window.onload = function () {
    let timer = 29, display = document.querySelector('#time');
    startTimer(timer, display);

    sound.seek(60);
    let son = sound.play();
    sound.fade(0,2,2000,son);

    document.getElementById("valider").addEventListener("click",check);
};

document.onkeypress = function (e){
    if (e.which === 13 || e.keyCode === 13) {
        e.preventDefault();
        check();
    }
};

