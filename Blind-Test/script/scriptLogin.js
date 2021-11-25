window.addEventListener("load", () =>{
    let button = $("#btnInscription");
    let form = $("#formRegister");
    let password = $(".form-control");
    let alert = $("#alertInsc");
    let alertDanger = $("#alertInscDanger");

    button.click(function(){
        if(($.trim(password[1].value)).length === 0){
            alertDanger.slideDown('fast');
            setTimeout(function () {
                alertDanger.slideUp('fast');
            }, 5000);
        }else{
            alert.slideDown('fast');
            setTimeout(function () {
                alert.slideUp('fast');
                form.submit();
            }, 5000);
        }
    });
});