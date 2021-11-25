function getAllCheckboxChecked(){
    let res = [];
    let checkboxes = document.querySelectorAll('input[type=checkbox]');
    for(let i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked){
            res.push(checkboxes[i].id);
        }
    }
    return res;
}

function setCookie(sName, sValue) {
    let today = new Date(), expires = new Date();
    expires.setTime(today.getTime() + (365*24*60*60*1000));
    document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}

window.addEventListener("load", () => {
    let p = document.querySelectorAll('input[type=checkbox]');
    for(let i = 0; i < p.length; i++){
        p[i].addEventListener("click", (event) => {
            let text = document.querySelector('#T' +(event.target.valueOf().name).replace(/\s/g, ''));
            if(text.style.display === "none"){
                text.style.display = "block";
            }else if(text.style.display === "block"){
                text.style.display = "none"
            }
        });
    }

    if (navigator.cookieEnabled) {
        // Cookies acceptés
    } else {
        alert("Activez vos cookies !");
    }

    let buttonLancer = document.querySelector("#jouer");
    buttonLancer.addEventListener("click", () => {
        setCookie("choix", getAllCheckboxChecked());
    });
});

