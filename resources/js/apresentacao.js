document.addEventListener('DOMContentLoaded', function () {
    // Cache busting: Desabilitar cache para garantir que a página sempre seja recarregada
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function (registrations) {
            registrations.forEach(function (registration) {
                registration.unregister();
            });
        });
    }

    // Selecionando os botões e o formulário
    const limparButton = document.querySelector('button[type="reset"]');
    const enviarButton = document.querySelector('button[type="submit"]');
    const formulario = document.querySelector('form');

    // Habilitar/desabilitar botão de enviar baseado em validação do formulário
    const inputs = formulario.querySelectorAll('input, select, textarea');
    
    // Função para validar se o formulário está completo
    function verificarFormulario() {
        let isValid = true;
        inputs.forEach(input => {
            if (input.required && input.value.trim() === '') {
                isValid = false;
            }
        });
        enviarButton.disabled = !isValid;
    }

    // Evento de input para verificar se o formulário está completo
    inputs.forEach(input => {
        input.addEventListener('input', verificarFormulario);
    });

    // Função para limpar os campos do formulário
    limparButton.addEventListener('click', function () {
        formulario.reset();
        enviarButton.disabled = true; // Desabilitar o botão de enviar após limpar
    });

    // Confirmar o envio do formulário
    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio normal

        const confirmacao = confirm("Tem certeza que deseja enviar o formulário?");
        if (confirmacao) {
            // Caso o usuário confirme, o formulário é enviado
            formulario.submit(); // Submeter o formulário normalmente
        }
    });

    // Iniciar com o botão de enviar desabilitado
    enviarButton.disabled = true;

    // Verificar o estado do formulário no carregamento inicial
    verificarFormulario();
});
