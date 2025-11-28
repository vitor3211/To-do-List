const senha = document.getElementById("password");
const icone = document.getElementById("olho");
const senha_confirmada = document.getElementById("password_confirm");

icone.addEventListener("click", () => {
    if (senha.type === "password") {
        senha.type = "text";
        senha_confirmada.type = "text";
        icone.classList.remove("fa-eye-slash");
        icone.classList.add("fa-eye");

    } else{
        senha.type = "password";
        senha_confirmada.type = "password";
        icone.classList.remove("fa-eye");
        icone.classList.add("fa-eye-slash");
    }
})