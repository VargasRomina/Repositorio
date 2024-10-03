document.getElementById("showRegister").addEventListener("click", function() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerBox").style.display = "block";
});

document.getElementById("showLogin").addEventListener("click", function() {
    document.getElementById("registerBox").style.display = "none";
    document.getElementById("loginForm").style.display = "block";
});

document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("regUsername").value;
    const password = document.getElementById("regPassword").value;

    console.log("Registrado:", username, password);
    alert("Cuenta creada exitosamente!");
    document.getElementById("registerBox").style.display = "none";
    document.getElementById("loginForm").style.display = "block";
});

document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    console.log("Iniciar sesión:", username, password);
    alert("Inicio de sesión exitoso!");
});
