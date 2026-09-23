function validateLogin() 
{
    let user = document.getElementById("userId");
    let pass = document.getElementById("password");
    let valid = true;

    let userPattern = /^\d{2}DCE\d{3}$/;
    let passPattern = /^(?=.*[A-Za-z])(?=.*[0-9]).{6,}$/;

    if (user.value == "") 
    {
        user.classList.add("error");
        document.getElementById("userError").innerHTML = "Please Enter ID";
        valid = false;
    }
    else if (!userPattern.test(user.value)) 
    {
        user.classList.add("error");
        document.getElementById("userError").innerHTML =
            "Wrong Format. Enter like 25DCE001";
        valid = false;
    }

    if (pass.value == "") 
    {
        pass.classList.add("error");
        document.getElementById("passwordError").innerHTML =
            "Please Enter Password";
        valid = false;
    }
    else if (!passPattern.test(pass.value)) 
    {
        pass.classList.add("error");
        document.getElementById("passwordError").innerHTML =
            "Password must have 6 characters, a letter and a number";
        valid = false;
    }

    return valid;
}


function saveProfile() 
{
    let name = document.getElementById("profileName");
    let enrollment = document.getElementById("profileEnrollment");
    let email = document.getElementById("profileEmail");

    let valid = true;

    let namePattern = /^[A-Za-z ]{2,50}$/;
    let enrollmentPattern = /^\d{2}DCE\d{3}$/;
    let emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    if (name.value == "") 
    {
        name.classList.add("error");
        document.getElementById("nameError").innerHTML =
            "Name is empty";
        valid = false;
    }
    else if (!namePattern.test(name.value)) 
    {
        name.classList.add("error");
        document.getElementById("nameError").innerHTML =
            "Enter a valid name";
        valid = false;
    }

    if (enrollment.value == "") 
    {
        enrollment.classList.add("error");
        document.getElementById("enrollmentError").innerHTML =
            "Enrolment No is empty";
        valid = false;
    }
    else if (!enrollmentPattern.test(enrollment.value)) 
    {
        enrollment.classList.add("error");
        document.getElementById("enrollmentError").innerHTML =
            "Use format 25DCE001";
        valid = false;
    }

    if (email.value == "") 
    {
        email.classList.add("error");
        document.getElementById("emailError").innerHTML =
            "Email is empty";
        valid = false;
    }
    else if (!emailPattern.test(email.value)) 
    {
        email.classList.add("error");
        document.getElementById("emailError").innerHTML =
            "Enter a valid email";
        valid = false;
    }

    if (valid) 
    {
        alert("Profile saved successfully!");
    }

    return valid;
}