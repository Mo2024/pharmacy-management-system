var username = document.getElementById("username");

username.addEventListener('input', function () {
    var username = document.getElementById("username").value;
    var usernameTakenAlert = document.getElementById("usernameTakenAlert");

    var ajax = new XMLHttpRequest();
    ajax.open("POST", "http://localhost/ITCS333-Project/controllers/ajax/checkUsernameEmail.inc.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            var response = JSON.parse(ajax.responseText);
            if (response.isRegistered) {
                usernameTakenAlert.style.display = "block";
            } else {
                usernameTakenAlert.style.display = "none";
            }
        }
    };
    ajax.send("username=" + encodeURIComponent(username));
});


var email = document.getElementById("email");

email.addEventListener('input', function () {
    var email = document.getElementById("email").value;
    var emailTakenAlert = document.getElementById("emailTakenAlert");

    var ajax = new XMLHttpRequest();
    ajax.open("POST", "http://localhost/ITCS333-Project/controllers/ajax/checkUsernameEmail.inc.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            var response = JSON.parse(ajax.responseText);
            if (response.isRegistered) {
                emailTakenAlert.style.display = "block";
            } else {
                emailTakenAlert.style.display = "none";
            }
        }
    };
    ajax.send("email=" + encodeURIComponent(email));
});



function validateInputs() {
    let notificationPartial = document.getElementById("notificationPartial")
    if (notificationPartial) {
        notificationPartial.style.display = "none";
    }
    const emailInput = document.getElementById('email');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const password2Input = document.getElementById('password2');
    const fullnameInput = document.getElementById('fullname');
    const submitButton = document.getElementById('signupButton');

    const isEmailValid = emailRegex.test(emailInput.value);
    const isUsernameValid = usernameRegex.test(usernameInput.value);
    const isPasswordValid = passwordRegex.test(passwordInput.value);
    const isPassword2Valid = passwordRegex.test(password2Input.value);
    const isFullnameValid = fullnameRegex.test(fullnameInput.value);

    let notificationDisplay = document.getElementById("notificationId")
    let message = document.getElementById("messageId")

    if (!isEmailValid) {
        notificationDisplay.style.display = "block"
        message.innerHTML = "Please make sure that the entered email is valid"
    } else if (!isUsernameValid) {
        notificationDisplay.style.display = "block"
        message.innerHTML = "Please make sure that Username is 4 to 20 characters long, only contains alphabet letters and 0 to 9 numerics"
    } else if (!isPasswordValid) {
        notificationDisplay.style.display = "block"
        message.innerHTML = "Please make sure that the entered password has one special character, one small letter, one capital letter and at least 8 characters long"
    } else if (!isPassword2Valid) {
        notificationDisplay.style.display = "block"
        message.innerHTML = "Please make sure that the entered password has one special character, one small letter, one capital letter and at least 8 characters long"
    } else if (!isFullnameValid) {
        notificationDisplay.style.display = "block"
        message.innerHTML = "Please make sure that the entered full name is entered properly"
    } else {
        submitButton.type = "submit";
        submitButton.click();

    }
}

