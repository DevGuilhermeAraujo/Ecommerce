//Função para receber informações do formulário de cadastro de funcionário
function getData() {
    var formData = {};
    var inputs = document.querySelectorAll('input');

    inputs.forEach(function (input) {
        formData[input.name] = input.value;
    });

    return formData;
}
//Função para validar campos do formulário
function validateForm() {
    var formData = getData();
    //Expressão regular para validar nome

    var nomeError = document.getElementById("nomeError");
    var nomelsValid = true;
    if (formData.nome.trim() === '' || formData.sobrenome.trim() === '') {
        nomeError.innerHTML = "Nome - Campo obrigatório";
        nomelsValid = false;
    } else {
        nomeError.innerHTML = "";
    }
    //Expressão regular para validar cpf
    var cpfError = document.getElementById("cpfError");
    var cpflsValid = true;
    if (formData.cpf.length < 14) {
        cpfError.innerHTML = "CPF inválido";
        cpflsValid = false;
    } else {
        cpfError.innerHTML = "";
    }
    // Expressão regular para validar e-mail
    var emailError = document.getElementById("emailError");
    var emailIsValid = true;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(formData.email)) {
        emailError.innerHTML = "Digite um e-mail válido.";
        emailIsValid = false;
    } else {
        emailError.innerHTML = "";
    }
    //Expressão regular para validar senha
    var passwordError = document.getElementById("passwordError");
    var passwordIsValid = true;
    if (formData.senha.length < 8 || !/[!@#$%^&*(),.?":{}|<>]/.test(formData.senha)) {
        passwordError.innerHTML = "A senha deve conter pelo menos 8 caracteres e incluir caracteres especiais.";
        passwordIsValid = false;
    } else {
        passwordError.innerHTML = "";
    }
    //Expressão regular para validar data
    var dataError = document.getElementById("dtError");
    var datalsValid = true;
    if (formData.dtNasc.trim() === '') {
        dataError.innerHTML = "Data de Nascimento - Campo obrigatório";
        datalsValid = false;
    } else {
        dataError.innerHTML = "";
    }

    // Retorna true se ambos email e senha forem válidos, caso contrário, retorna false
    return emailIsValid && passwordIsValid && nomelsValid && cpflsValid && datalsValid;
}

// Máscara para CPF (formato: XXX.XXX.XXX-XX)
function maskCPF() {
    document.getElementById('cpf').addEventListener('input', function (e) {
        var target = e.target;
        var input = target.value.replace(/\D/g, '');
        var length = input.length;

        if (length > 11) {
            target.value = input.slice(0, 11);
            return;
        }

        if (length >= 4 && length <= 6) {
            target.value = input.slice(0, 3) + '.' + input.slice(3);
        } else if (length >= 7 && length <= 9) {
            target.value = input.slice(0, 3) + '.' + input.slice(3, 6) + '.' + input.slice(6);
        } else if (length >= 10) {
            target.value = input.slice(0, 3) + '.' + input.slice(3, 6) + '.' + input.slice(6, 9) + '-' + input.slice(9);
        }
    });
}