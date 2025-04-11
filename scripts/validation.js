
/* validation cote client pour les formulaire de sportify */

document.addEventListener('DOMContentLoaded', function() {
    
    //validation du formulaire de connexion 
    const loginForm = document.getElementById('loginForm');
    if(loginForm){
        loginForm.addEventListener('submit', function(event) {
            let isValid = true;
            const email = document.getElementById('loginEmail');
            const password = document.getElementById('loginPassword');

            //validation de l'email 
            if(!validateEmail(email.value)) {
                showError(email, 'Veuillez entrer une adresse email valide');
                isValid = false;
            } else {
                removeError(email);
            }


            //validation du mot de passe 
            if(password.value.trim() === ''){
                showError(password, 'Le mot de passe est requis');
                isValid = false;
            } else {
                removeError(password);
            }

            if(!isValid){
                event.preventDefault(); // Empêche l'envoi du formulaire si les validations échouent
            }
        });
    }

    //validation du formulaire d'inscription

    const registerForm = document.getElementById('registerForm');
    if(registerForm){
        registerForm.addEventListener('submit', function(event){
            let isValid = true;
            const name = document.getElementById('registerName');
            const email = document.getElementById('registerEmail');
            const password = document.getElementById('registerPassword');
            const confirmPassword = document.getElementById('registerConfirmPassword');

            //validation du nom
            if(name.value.trim() === ''){
                showError(name, 'Le nom est requis');
                isValid = false;
            } else {
                removeError(name);
            }

            //validation de l'email
            if(!validateEmail(email.value)){
                showError(email, 'Veuillez entrer une adresse email valide');
                isValid = false;
            } else {
                removeError(email);
            }

            //validation du mot de passe
            if(password.value.trim() === ''){
                showError(password, 'Le mot de passe est requis');
                isValid = false;
            } else if(password.value.length < 6) {
                showError(password, 'Le mot de passe doit contenir au moins 6 caractères');
                isValid = false;
            } else {
                removeError(password);
            }

            //validation de la confirmation du mot de passe
            if(confirmPassword.value !== password.value){
                showError(confirmPassword, 'Les mots de passe ne correspondent pas');
                isValid = false;
            } else {
                removeError(confirmPassword);
            }


            if(!isValid){
                event.preventDefault(); // Empêche l'envoi du formulaire si les validations échouent
            }

        });
    }

    
    // Validation du formulaire de devis
    const quoteForm = document.getElementById('quoteForm');
    if (quoteForm) {
        quoteForm.addEventListener('submit', function(event) {
            let isValid = true;
            const name = document.getElementById('quoteName');
            const email = document.getElementById('quoteEmail');
            const tel = document.getElementById('tel');
            
            // Validation du nom
            if (name.value.trim() === '') {
                showError(name, 'Le nom complet est requis');
                isValid = false;
            } else {
                removeError(name);
            }
            
            // Validation de l'email
            if (!validateEmail(email.value)) {
                showError(email, 'Veuillez entrer une adresse email valide');
                isValid = false;
            } else {
                removeError(email);
            }
            
            // Validation du téléphone
            if (tel.value.trim() === '') {
                showError(tel, 'Le numéro de téléphone est requis');
                isValid = false;
            } else {
                removeError(tel);
            }
            
            // Vérification des boutons radio pour le type de cours
            const typeCoursRadios = document.querySelectorAll('input[name="choice"]');
            let typeCoursSelected = false;
            typeCoursRadios.forEach(radio => {
                if (radio.checked) {
                    typeCoursSelected = true;
                }
            });
            
            if (!typeCoursSelected) {
                alert('Veuillez sélectionner un type de cours');
                isValid = false;
            }
            
            // Vérification des boutons radio pour le programme personnalisé
            const programRadios = document.querySelectorAll('input[name="program"]');
            let programSelected = false;
            programRadios.forEach(radio => {
                if (radio.checked) {
                    programSelected = true;
                }
            });
            
            if (!programSelected) {
                alert('Veuillez indiquer si vous souhaitez un programme personnalisé');
                isValid = false;
            }
            
            // Vérification des boutons radio pour le lieu
            const lieuRadios = document.querySelectorAll('input[name="lieu"]');
            let lieuSelected = false;
            lieuRadios.forEach(radio => {
                if (radio.checked) {
                    lieuSelected = true;
                }
            });
            
            if (!lieuSelected) {
                alert('Veuillez sélectionner un lieu d\'entraînement');
                isValid = false;
            }
            
            const details = document.getElementById('quoteDetails');
            
            // Validation des détails
            if (details.value.trim() === '') {
                showError(details, 'Veuillez préciser vos besoins et objectifs');
                isValid = false;
            } else {
                removeError(details);
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    
    // Validation du formulaire de contact
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            let isValid = true;
            const name = document.getElementById('contactName');
            const email = document.getElementById('contactEmail');
            const subject = document.getElementById('contactSubject');
            const message = document.getElementById('contactMessage');
            
            // Validation du nom
            if (name.value.trim() === '') {
                showError(name, 'Le nom complet est requis');
                isValid = false;
            } else {
                removeError(name);
            }
            
            // Validation de l'email
            if (!validateEmail(email.value)) {
                showError(email, 'Veuillez entrer une adresse email valide');
                isValid = false;
            } else {
                removeError(email);
            }
            
            // Validation du sujet
            if (subject.value.trim() === '') {
                showError(subject, 'Le sujet est requis');
                isValid = false;
            } else {
                removeError(subject);
            }
            
            // Validation du message
            if (message.value.trim() === '') {
                showError(message, 'Le message est requis');
                isValid = false;
            } else {
                removeError(message);
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    }


    //fonction utilitaires 
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }


    function showError(input, message) {
        const formControl = input.parentElement;
        const errorDiv = formControl.querySelector('.invalid-feedback') || document.createElement('div');

        if(!formControl.querySelector('.invalid-feedback')) {
            errorDiv.className = 'invalid-feedback';
            formControl.appendChild(errorDiv);
        }

        input.className = 'form-control is-invalid';
        errorDiv.innerText = message;
    }

    function removeError(input) {
        input.className = 'form-control';
        const formControl = input.parentElement;
        const errorDiv = formControl.querySelector('.invalid-feedback');
        if(errorDiv) {
            errorDiv.remove();
        }
    }


    //fonction pour l'exportation de la base de donnee 

    if (localStorage.getItem('estpremier') === null) {
        // Redirection vers export.php
        console.log("je suis le fichier export ");
        localStorage.setItem("estpremier","false");
        window.location.href = "../server/export.php";
    }
      


});







