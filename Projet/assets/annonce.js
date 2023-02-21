/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/annonce.css';

// start the Stimulus application
//import './bootstrap';
console.log("test");
runDate();
minuteurminuit();


function runDate() //Permet d'afficher la date
{
    var afficherdate;
    var timeValue;
    var today   = new Date();
    var day   = today.getDate();
    var month = today.getMonth();
    var year = today.getFullYear();


    timeValue = ((day < 10) ? "0" : "") + day;
    timeValue += ((month+1 < 10) ? "/0" : "/") + (month+1) + "/" + year;
    document.getElementById("dateheur").text = timeValue;
}

function minuteurminuit(){
    const timer = document.getElementById("timer");

    setInterval(function() {
        const now = new Date();
        const midnight = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0);
        const difference = midnight - now;
        const hours = Math.floor(difference / 1000 / 60 / 60);
        const minutes = Math.floor(difference / 1000 / 60) % 60;
        const seconds = Math.floor(difference / 1000) % 60;

        timer.innerHTML = `${hours} heures ${minutes} minutes et ${seconds} secondes restantes avant les nouvelles offres.`;
    }, 1000);
}


