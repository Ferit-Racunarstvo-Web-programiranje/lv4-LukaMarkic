
function checkFormInputs() {
    let inputFilled = 0;
    let nameInput = document.getElementById("first-name-input");
    let lastNameInput = document.getElementById("last-name-input");
    let homeAddressInput = document.getElementById("home-address");
    let emailAddressInput = document.getElementById("email-address");
   
    let inputsObjects = [
        {
            input: nameInput.value,
            action: () => (nameInput.style.borderColor = "red"),
        },
        {
            input: lastNameInput.value,
            action: () => (lastNameInput.style.borderColor = "red"),
        },
        {
            input: homeAddressInput.value,
            action: () =>
            (document.getElementById("home-address").style.borderColor =
                "red"),
        },
        {
            input: emailAddressInput.value,
            action: () => {
                emailAddressInput.style.borderColor = "red";
            }
        }
    ];

    inputsObjects.forEach((element) => {
        if (element.input === null || element.input === "" || element.input === " ") {
            element.action();
        } else {
            inputFilled++;
        }
    });

    //If all inputs are filled countinue with checkup
    if (inputFilled === inputsObjects.length) {
        //Press post button and begin with checkup
        let postButton = document.getElementById("click-post");
        postButton.click();
    }
}

function SetInputBorderColor(obj) {
    if (obj.val !== "" || obj.val !== " ") {
        obj.style.borderColor = "lightgrey";
    }
}