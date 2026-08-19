function validateForm()
{
    var text = document.getElementById("textBox").value;
    var area = document.getElementById("textArea").value;

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    var male = document.getElementById("male").checked;
    var female = document.getElementById("female").checked;

    var reading = document.getElementById("reading").checked;
    var gaming = document.getElementById("gaming").checked;
    var drawing = document.getElementById("drawing").checked;
    var sports = document.getElementById("sports").checked;


    if (text == "")
    {
        document.getElementById("textBox").style.border = "1px solid red";
        alert("Please fill the text box");
        return false;
    }
    else
    {
        document.getElementById("textBox").style.border = "1px solid black";
    }


    if (area == "")
    {
        document.getElementById("textArea").style.border = "1px solid red";
        alert("Please fill the text area");
        return false;
    }
    else
    {
        document.getElementById("textArea").style.border = "1px solid black";
    }


    if (name == "")
    {
        document.getElementById("name").style.border = "1px solid red";
        alert("Please enter your name");
        return false;
    }
    else
    {
        document.getElementById("name").style.border = "1px solid black";
    }


    if (email == "")
    {
        document.getElementById("email").style.border = "1px solid red";
        alert("Please enter your email");
        return false;
    }
    else
    {
        document.getElementById("email").style.border = "1px solid black";
    }


    if (password == "")
    {
        document.getElementById("password").style.border = "1px solid red";
        alert("Please enter your password");
        return false;
    }
    else
    {
        document.getElementById("password").style.border = "1px solid black";
    }


    if (!male && !female)
    {
        alert("Please select your gender");
        return false;
    }


    if (!reading && !gaming && !drawing && !sports)
    {
        alert("Please select at least one hobby");
        return false;
    }


    alert("Form submitted successfully!");
    return false;
}