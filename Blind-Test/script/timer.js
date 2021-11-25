function startTimer(duration, display) {
    let timer = duration, seconds;
    setInterval(function () {
        seconds = parseInt(timer % 60, 10);
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = seconds;

        if (--timer < 0) {
            timer = 0;
            sound.pause();
            document.getElementById("reponse").disabled = true;
            document.getElementById("valider").disabled = true;
            document.getElementById('formSub').submit();
        }

    }, 1000);
}