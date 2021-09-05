$(() => {

    inputUsername = $('#id_username')[0];
    inputPassword = $('#id_password')[0];
    inputPasswordConfirm = $('#id_confirmer_password')[0];
    inputEmail = $('#id_email')[0];
    button = $('button')[0];
    console.log('username', inputUsername);
    console.log('password', inputPassword);
    console.log('passwordConfirme', inputPasswordConfirm);
    console.log('button', button);

    $(button).click((event) => {
        // event.preventDefault();
       error = verifForm();
       if(error){
        event.preventDefault();
       }
    });
});

function verifForm() {
    let username = inputUsername.value;
    let password = inputPassword.value;
    let passwordConfirme = inputPasswordConfirm.value;
    let email = inputEmail.value;
    let error = false;

    // passwordRegCaractere = new RegExp(/[A-Z0-9a-z]{8,} /);
    passwordRegMaj = new RegExp(/[A-Z]+/);
    passwordRegChiffre = new RegExp(/[0-9]+/);
    emailReg = new RegExp(/^.+[@][a-z]+[.][a-z]+$/);

    pErrorUsernameVide = $('#error_username_vide')[0];
    pErrorUsernameExist = $('#error_username_exist')[0];
    pErrorPasswordVide = $('#error_password_vide')[0];
    pErrorPasswordInsuffisant = $('#error_password_insuffisant')[0];
    pErrorPasswordConfirm = $('#error_champs_different_password')[0];
    pErrorEmailVide = $('#error_email_vide')[0];
    pErrorEmail = $('#error_email')[0];

    $.get('http://localhost:8001/GetUser.php?username=' + username).done((data) => {
        let userDb = data;
        // console.log('userDb', userDb);
        if (userDb.username) {
            // console.log('username exist', username);
            pErrorUsernameVide.style.display = 'none';
            pErrorUsernameExist.style.display = 'block';
            error = true;
        }
        else {
            if (username.length > 0) {
                // console.log('username ok', username);
                pErrorUsernameExist.style.display = 'none';
                pErrorUsernameVide.style.display = 'none';
            }
        }
    }).fail(() => {
        if (username.length == 0) {
            console.log('username vide', username);
            pErrorUsernameExist.style.display = 'none';
            pErrorUsernameVide.style.display = 'block';
            error = true;
        }
    });
    console.log('password', password);
    if (password.length == 0) {
        console.log('password vide', password);
        pErrorPasswordVide.style.display = 'block';
        pErrorPasswordInsuffisant.style.display = 'none';
        error = true;
    } else {
        if (password.length > 0) {
            console.log('password remplis', password);
            console.log('chiffre password', passwordRegChiffre.test(password));
            console.log('maj password', passwordRegMaj.test(password));
            pErrorPasswordVide.style.display = 'none';
            if (password.length >= 8 && passwordRegChiffre.test(password) && passwordRegMaj.test(password)) {
                pErrorPasswordInsuffisant.style.display = 'none';

            } else {
                pErrorPasswordInsuffisant.style.display = 'block';
                error = true;
            }
        }

    }
    if(passwordConfirme != password){
        pErrorPasswordConfirm.style.display = 'block';
        error = true;
    }else{
        pErrorPasswordConfirm.style.display = 'none';
    }
    console.log('email', email);
    if(email.length == 0){
        console.log('email length', email.length);
        pErrorEmailVide.style.display = 'block';
        pErrorEmail.style.display = 'none';
        error = true;
    }else{
        if (emailReg.test(email)) {
            pErrorEmail.style.display = 'none';
            pErrorEmailVide.style.display = 'none';
        }else{
            pErrorEmailVide.style.display = 'none';
            pErrorEmail.style.display = 'block';
            error = true;
        }
    }
     return error;

}

