document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();

    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var repeatPassword = document.getElementById('repeat-password').value;

    if (password !== repeatPassword) {
        alert("Passwords don't match");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", 'form.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = () => {
        if (xhr.status !== 200) {
            alert(xhr.response)
            return;
        }
        document.write(xhr.response);
    };

    xhr.onerror = () => {
        console.log("Error during execution of request");
    };

    xhr.send(new URLSearchParams({
        name: name,
        surname: surname,
        email: email,
        password: password,
        repeatPassword: repeatPassword
    }).toString());
});