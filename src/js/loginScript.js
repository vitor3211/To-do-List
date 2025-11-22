const senha = document.getElementById("password");
const icone = document.getElementById("olho");
const btnEnviar = document.getElementById("");

icone.addEventListener("click", () => {
    if (senha.type === "password") {
        senha.type = "text";
        icone.classList.remove("fa-eye-slash");
        icone.classList.add("fa-eye");

    } else{
        senha.type = "password";
        icone.classList.remove("fa-eye");
        icone.classList.add("fa-eye-slash");
    }
})

