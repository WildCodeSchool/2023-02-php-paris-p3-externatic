
import './styles/app.scss';

import './bootstrap';

require('bootstrap');


let expandedPromo = false;

function showCheckboxesPromo() {
    let checkboxesPromo = document.getElementById("checkboxesPromo");
    if (!expandedPromo) {
        checkboxesPromo.style.display = "block";
        expandedPromo = true;
    } else {
        checkboxesPromo.style.display = "none";
        expandedPromo = false;
    }
}
