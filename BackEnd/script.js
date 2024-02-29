function getData(formId) {
    var formData = new FormData();
    var form = document.getElementById(formId);
    formData.append('formName', formId);
    var inputsAndSelectsAndTextarea = form.querySelectorAll('input, select, textarea')
    inputsAndSelectsAndTextarea.forEach(function (element) {
        if (element.id && element.type !== 'submit') {
            if (element.type === 'file') {
                formData.append(element.id, element.files[0]);
            } else if (element.type === 'checkbox') {
                formData.append('novidade', document.getElementById('novidade').checked ? '1' : '0');
            } else {
                formData.append(element.id, element.value);
            }
        }

    });

    return formData;
}

function submitForm(formId) {

    var formData = getData(formId);
    console.log(Object.fromEntries(formData));
    console.log(formData.get('formName'));
    if (formData.get('formName') == 'productForm' || formData.get('formName') == 'productFormFunc') {
        if (!validateFormProduct(formData)) {
            return false;
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../BackEnd/cadastros/processCadastroProd.php", true);
            //xhr.setRequestHeader("Content-Type", "multipart/form-data");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        //Processo concluído com sucesso
                        document.getElementById("resultMessage").innerHTML = xhr.responseText;
                    } else {
                        // Erro durante o processamento
                        document.getElementById("resultMessage").innerHTML = "Erro durante o processamento.";
                    }
                }
            }
        }
    } else if (formData.get('formName') == 'formCadFunc') {
        if (!validateFormFunc(formData)) {
            return false;
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../BackEnd/cadastros/processCadastroFunc.php", true);
            //xhr.setRequestHeader("Content-Type", "multipart/form-data");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        //Processo concluído com sucesso
                        document.getElementById("cadastroError").innerHTML = xhr.responseText;
                    } else {
                        // Erro durante o processamento
                        document.getElementById("cadastroError").innerHTML = "Erro durante o processamento.";
                    }
                }
            };
        }
    }
     // Envie os dados do formulário
    xhr.send(formData);
    return true;
}

//Função para validar campos do formulário- de cadastro do funcionário
function validateFormFunc(formData) {
    //Expressão regular para validar nome
    var cadastroError = document.getElementById("cadastroError");
    cadastroError.innerHTML = "";

    if (formData.get('nome').trim() == "" || formData.get('sobrenome').trim() == "") {
        cadastroError.innerHTML = "Nome - Campo obrigatório";
        return false;
    }
    if (formData.get('cpf').length < 14) {
        cadastroError.innerHTML = "CPF inválido";
        return false;
    }
    // Expressão regular para validar e-mail
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(formData.get('email'))) {
        cadastroError.innerHTML = "Digite um e-mail válido.";
        return false;
    }
    //Expressão regular para validar endereço
    if (formData.get('logradouro').trim() == "" || formData.get('numero').trim() == "" || formData.get('bairro').trim() == "") {
        cadastroError.innerHTML = "É necessário o endereço para finalizar o cadastro";
        return false;
    }
    //Expressão regular para validar número
    if (formData.get('telefone').length < 15) {
        cadastroError.innerHTML = "Número de telefone inválido";
        return false;
    }
    //Expressão regular para validar departamento
    if (formData.get('departamento') == "" || formData.get('departamento') == null) {
        cadastroError.innerHTML = "É necessário um departamento finalizar o cadastro!";
        return false;
    }
    //Expressão regular para validar senha
    if (formData.get('senha').length < 8 || !/[!@#$%^&*(),.?":{}|<>]/.test(formData.get('senha'))) {
        cadastroError.innerHTML = "A senha deve conter pelo menos 8 caracteres e incluir caracteres especiais.";
        return false;
    }
    if (formData.get('senha') != formData.get('confirmaSenha')) {
        cadastroError.innerHTML = "As senhas não correspondem";
        return false;
    }
    return true;
}

//Função para validar campos do formulário- de cadastro de produtos
function validateFormProduct(formData) {
    var resultMessage = document.getElementById("resultMessage");
    resultMessage.innerHTML = "";

    if (formData.get('nomeProd').trim() == "") {
        resultMessage.innerHTML = "Campo Título do Produto - Obrigatório";
        return false;
    }

    if (formData.get('descProd').trim() == "") {
        resultMessage.innerHTML = "Campo Descrição do Produto - Obrigatório";
        return false;
    }

    if (!formData.get('imgProd')) {
        resultMessage.innerHTML = "Campo Imagem do Produto - Obrigatório!";
        return false;
    }

    var fileInput = document.getElementById('imgProd');
    var fileName = fileInput.files.length > 0 ? fileInput.files[0].name : null;
    var fileExtension = fileName ? fileName.split('.').pop().toLowerCase() : null;

    if (fileExtension != 'jpg' && fileExtension != 'png') {
        resultMessage.innerHTML = "Campo Imagem do Produto - Arquivo Inválido!";
        return false;
    }

    if (formData.get('valorProd') == "") {
        resultMessage.innerHTML = "Campo Valor do Produto - Obrigatório!";
        return false;
    }

    if (formData.get('categoria') == "") {
        resultMessage.innerHTML = "Campo Categoria do Produto - Obrigatório!";
        return false;
    }
    return true;
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

// document.getElementById('filtroProdutos').addEventListener('submit', function (e) {
//     e.preventDefault(); // Evita o envio padrão do formulário
//     searchProducts();
// });

function getProductSuggestions() {
    var input = document.getElementById('searchInput').value;

    if (input.trim() !== '') {
        // Crie um objeto XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configure a requisição
        xhr.open('GET', '../BackEnd/search.php?query=' + encodeURIComponent(input), true);

        // Defina a função de callback para lidar com a resposta
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Atualize a área de sugestões com a resposta do servidor
                document.getElementById('suggestions').innerHTML = xhr.responseText;
            }
        };

        // Envie a requisição
        xhr.send();
    } else {
        // Limpe as sugestões se o campo de pesquisa estiver vazio
        document.getElementById('suggestions').innerHTML = '';
    }
}
