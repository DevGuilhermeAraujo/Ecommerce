function AbrirModal(fundo, modal, idFunc) {
    fundo.style.display = "flex";
    modal.style.display = "flex";

    document.getElementById("idFuncionario").value = idFunc;
}
function FecharModal(fundo, modal) {
    fundo.style.display = "none";
    modal.style.display = "none";
}
function Trocar(fechar, abrir) {
    fechar.style.display = "none";
    abrir.style.display = "flex";
}