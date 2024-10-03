$(document).ready(() => {
    // Função debounce para otimizar as chamadas
    const debounce = (func, delay) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    // Função para inicializar o autocomplete
    const initializeAutocomplete = () => {
        $('#nome_congregacao').autocomplete({
            source: debounce((request, response) => {
                $.ajax({
                    url: '/congregations/autocomplete',
                    dataType: 'json',
                    data: { query: request.term },
                    success: data => response(data),
                    error: () => console.error('Erro ao buscar sugestões de autocomplete.') // Adicione tratamento de erro
                });
            }, 300),
            minLength: 2
        });
    };

    // Função para inicializar o cache de sugestões
    const initializeCache = () => {
        const cache = {};

        $('#nome_congregacao').on('input', debounce(function() {
            const query = $(this).val();
            if (cache[query]) {
                $('#suggestions').html(cache[query]).show();
            } else {
                $.ajax({
                    url: '/congregations/search-suggestions',
                    dataType: 'json',
                    data: { query },
                    success: data => {
                        const suggestions = data.map(item => `<li>${item}</li>`).join('');
                        $('#suggestions').html(suggestions).show();
                        cache[query] = suggestions;
                    },
                    error: () => console.error('Erro ao buscar sugestões de pesquisa.') // Adicione tratamento de erro
                });
            }
        }, 300));
    };

    // Função para alternar a exibição dos detalhes
    const initializeDetailsToggle = () => {
        $('.congregation-card').on('click', '.details-toggle', function() {
            $(this).closest('.congregation-card').find('.details').toggleClass('show');
        });
    };

    // Função para inicializar a validação do formulário
    const initializeFormValidation = () => {
        $('.search-form').validate({
            rules: {
                nome_congregacao: { minlength: 2 },
                ano_fundacao: { digits: true, min: 1900, max: new Date().getFullYear() }
            },
            messages: {
                nome_congregacao: { minlength: "O nome deve ter pelo menos 2 caracteres." },
                ano_fundacao: { digits: "O ano deve ser um número válido." }
            },
            errorElement: 'div',
            errorPlacement: (error, element) => error.appendTo(element.closest('.form-group'))
        });
    };

    // Inicialização de todos os componentes
    const initializeComponents = () => {
        initializeAutocomplete();
        initializeCache();
        initializeDetailsToggle();
        initializeFormValidation();
    };

    initializeComponents();
});
