$(function () {
    window.visualViewport.onresize = onWindowResize;

    let svgRetour = $('svg.svg-inline--fa.fa-angle-right.fa-w-8')[0];
    $(svgRetour).click(retourClick);
})
function onWindowResize() {
    displayNav();
    header();
    displayDivAuthentification();
    displayJeuxRecommende();
}
function displayNav() {
    let nav = $('nav')[0];
    let divBurger = $('#menu_burger')[0];
    // console.log('viewport width', window.visualViewport.width);
    if (window.visualViewport.width >= 950) {
        nav.style.display = 'flex';
    } else {
        if (window.visualViewport.width < 950 && window.getComputedStyle(divBurger.firstChild).color == 'rgb(255, 255, 255)') {
            // console.log('svgBurger', divBurger);

            nav.style.display = 'none';
        }
    }
}
function header() {
    let divSvgRecherche = $('div#svg_recherche')[0];
    let divSearch = $('#div_recherche')[0];
    let divHeaderContainer = $('#div_header_container')[0];
    let divTitre = $('#div_titre')[0];
    let svgRetour = $('svg.svg-inline--fa.fa-angle-right.fa-w-8')[0];
    if (divSvgRecherche.style.display == 'block') {
        if (window.visualViewport.width >= 630) {
            divSvgRecherche.style.display = 'none';
            divSearch.style.display = 'flex';
            divHeaderContainer.style.width = '60%';
            divHeaderContainer.style.justifyContent = 'space-between';
            divTitre.style.width = '30%';
            divSearch.style.width = '60%';
        }
    } else {
        if (svgRetour.style.display == 'block') {
            if (window.visualViewport.width >= 630) {
                svgRetour.style.display = 'none';
                divTitre.style.display = 'flex';
            } else {
                if (window.visualViewport.width < 450) {

                    divHeaderContainer.style.width = '80%';
                    divSearch.style.width = '80%';
                }
            }
        } else {
            if (window.visualViewport.width < 630) {
                divHeaderContainer.style.width = '0%';
                divTitre.style.width = '100%';
                divSearch.style.display = 'none';
                divSvgRecherche.style.display = 'block';
            }




        }
    }
    if (window.visualViewport.width >= 950) {
        divHeaderContainer.style.width = '50%';
        divTitre.style.width = '50%';
    }

}
function retourClick() {
    let divSearch = $('#div_recherche')[0];
    let divTitre = $('#div_titre')[0];
    let divHeaderContainer = $('#div_header_container')[0];
    let svgRetour = $('svg.svg-inline--fa.fa-angle-right.fa-w-8')[0];
    let divSvgRecherche = $('div#svg_recherche')[0];

    divSvgRecherche.style.display = 'block';
    svgRetour.style.display = 'none';
    divHeaderContainer.style.width = '0%';
    divTitre.style.display = 'flex';
    divTitre.style.width = '100%'
    divSearch.style.display = 'none';

}
function displayDivAuthentification() {
    let divAuthentification = $('#div_authentification')[0];
    if (window.visualViewport.width > 635) {
        divAuthentification.style.display = 'flex';
    } else {
        divAuthentification.style.display = 'none';
    }
}

function displayJeuxRecommende() {
    if ($('#list_jeux_recommende')[0]) {
        let jeuxRecommende = $('#list_jeux_recommende')[0];
        let button = $('#display_jeux_recommende')[0];
        let jeux = $('#jeux_avis')[0];
        if (window.visualViewport.width > 1200) {
            jeuxRecommende.style.display = 'flex';
            jeuxRecommende.style.flexDirection = 'column';
            jeux.style.display = 'flex';
            button.style.display = 'none';
            button.innerHTML = 'Jeux recommandés';
        } else {
            if(button.innerHTML != 'Masquer les jeux recommandés'){
                jeuxRecommende.style.display = 'none';
                button.style.display = 'flex';
            }
            
        }
    }

}