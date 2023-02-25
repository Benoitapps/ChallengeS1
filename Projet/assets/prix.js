
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/payment.css';

// start the Stimulus application
//import './bootstrap';
console.log("testpay");





function recup() {

    let prixbase = document.getElementById("prix");
    let prixseul = prixbase.innerHTML;
    console.log(prixseul);

    let nbplace = document.getElementById("place_nb");
    let resinput = nbplace.value;
    console.log(resinput);

    let resultat = prixseul*resinput;
    console.log("res "+resultat)

    const res = document.getElementById("res");
    res.innerHTML = resultat+"€";

}
setInterval(recup,1000)






