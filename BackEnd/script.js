//Função para receber informações do formulário de cadastro de funcionário
function getData() {
    var formData = {};
    var inputsAndSelectsAndTextarea = document.querySelectorAll('input, select, textarea');

    inputsAndSelectsAndTextarea.forEach(function (element) {
        formData[element.name] = element.value;
    });

    return formData;
}
//Função para validar campos do formulário
function validateForm() {
    var formData = getData();
    //Expressão regular para validar nome
    var cadastroError = document.getElementById("cadastroError");
    if (formData.nome.trim() === "" || formData.sobrenome.trim() === "") {
        cadastroError.innerHTML = "Nome - Campo obrigatório";
        return false;
    } else {
        cadastroError.innerHTML = "";
        //Expressão regular para validar cpf
        if (formData.cpf.length < 14) {
            cadastroError.innerHTML = "CPF inválido";
            return false;
        } else {
            cadastroError.innerHTML = "";
            // Expressão regular para validar e-mail
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(formData.email)) {
                cadastroError.innerHTML = "Digite um e-mail válido.";
                return false;
            } else {
                cadastroError.innerHTML = "";
                //Expressão regular para validar endereço
                if (formData.logradouro.trim() === "" || formData.numero.trim() === "" || formData.bairro.trim() === "") {
                    cadastroError.innerHTML = "É necessário o endereço para finalizar o cadastro";
                    return false;
                } else {
                    cadastroError.innerHTML = "";
                    //Expressão regular para validar número
                    if (formData.telefone.length < 15) {
                        cadastroError.innerHTML = "Número de telefone inválido";
                        return false;
                    } else {
                        cadastroError.innerHTML = "";
                        //Expressão regular para validar departamento
                        if (formData.departamento == "" || formData.departamento == null) {
                            cadastroError.innerHTML = "É necessário um departamento finalizar o cadastro!";
                            return false;
                        } else {
                            cadastroError.innerHTML = "";
                            //Expressão regular para validar senha
                            if (formData.senha.length < 8 || !/[!@#$%^&*(),.?":{}|<>]/.test(formData.senha)) {
                                cadastroError.innerHTML = "A senha deve conter pelo menos 8 caracteres e incluir caracteres especiais.";
                                return false;
                            } else {
                                cadastroError.innerHTML = "";
                                if (formData.senha != formData.confirmaSenha) {
                                    cadastroError.innerHTML = "As senhas não correspondem";
                                    return false;
                                } else {
                                    cadastroError.innerHTML = "";
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function validateFormProduct() {
    var formData = getData();
    var cadastroProdError = document.getElementById("cadastroProdError");
    if (formData.nomeProd.trim() === "") {
        cadastroProdError.innerHTML = "Campo Título do Produto - Obrigatório";
        return false;
    } else {
        cadastroProdError.innerHTML = "";
        if (formData.descProd.trim() === "") {
            cadastroProdError.innerHTML = "Campo Descrição do Produto - Obrigatório";
            return false;
        } else {
            cadastroProdError.innerHTML = "";
            if (formData.imgProd.length == 0) {
                cadastroProdError.innerHTML = "Campo Imagem do Produto - Obrigatório!";
                return false;
            } else {
                cadastroProdError.innerHTML = "";
                var fileName = formData.imgProd.files[0].name;
                var fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension == '.jpg') {
                    cadastroProdError.innerHTML = "Campo Imagem do Produto - Arquivo Inválido!";
                    return false;
                } else {
                    cadastroProdError.innerHTML = "";
                    if (formData.valorProd.trim() == "") {
                        cadastroProdError.innerHTML = "Campo Valor do Produto - Obrigatório!";
                        return false;
                    } else {
                        cadastroProdError.innerHTML = "";
                        if (formData.categoria.trim() == "") {
                            cadastroProdError.innerHTML = "Campo Categoria do Produto - Obrigatório!";
                            return false;
                        } else {
                            cadastroProdError.innerHTML = "";
                            return true;
                        }
                    }
                }
            }
        }
    }
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

function maskPhone() {
    document.getElementById('telefone').addEventListener('input', function (event) {
        let inputValue = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        let formattedValue = '';

        if (inputValue.length > 2) {
            formattedValue += `(${inputValue.substring(0, 2)})`;

            if (inputValue.length > 6) {
                formattedValue += ` ${inputValue.substring(2, 7)}`;

                if (inputValue.length > 10) {
                    formattedValue += `-${inputValue.substring(7, 11)}`;
                } else {
                    formattedValue += `-${inputValue.substring(7)}`;
                }
            } else {
                formattedValue += ` ${inputValue.substring(2)}`;
            }
        } else {
            formattedValue = inputValue;
        }

        event.target.value = formattedValue;
    });
}



//Animação de desaparecer menssagem na tela
async function deleteMsg(_timer, _idObject) {
    //await new Promise(r => setTimeout(r, 5000));
    //Pegar objeto por id
    obj = document.getElementById(_idObject);
    if (obj == null)
        //Se for null; O PHP já manda o objeto inteiro.
        obj = _idObject;
    //Aguarda o tempo determinado
    await new Promise(r => setTimeout(r, _timer));
    //Chama a animação de desaparecer
    obj.classList.toggle("msgHide");
    //Aguarda o tempo de 1s da animação CSS para remover o elemento do HTML
    await new Promise(r => setTimeout(r, 1000));
    obj.remove();
}