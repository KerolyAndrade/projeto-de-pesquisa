import './bootstrap.js';
import $ from 'jquery';
import 'jquery-ui/ui/widgets/autocomplete.js';

window.$ = $;

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
                $('#suggestions').html('<li>Carregando...</li>').show(); // Mostrar carregando
                $.ajax({
                    url: '/congregations/autocomplete',
                    dataType: 'json',
                    data: { query: request.term },
                    success: data => response(data),
                    error: () => {
                        console.error('Erro ao buscar sugestões de autocomplete.');
                        alert('Não foi possível buscar sugestões de autocomplete. Tente novamente mais tarde.');
                    }
                });
            }, 300),
            minLength: 2
        });
    };

    // Função para inicializar o cache de sugestões com expiração
    const initializeCache = () => {
        const cache = {};
        const cacheExpirationTime = 60000; // Cache expira após 1 minuto

        $('#nome_congregacao').on('input', debounce(function() {
            const query = $(this).val();
            if (cache[query] && (Date.now() - cache[query].timestamp < cacheExpirationTime)) {
                updateSuggestions(cache[query].data);  // Exibir sugestões cacheadas
            } else {
                $.ajax({
                    url: '/congregations/search-suggestions',
                    dataType: 'json',
                    data: { query },
                    success: data => {
                        const suggestions = data.map(item => `<li class="autocomplete-item">${item}</li>`).join('');
                        updateSuggestions(suggestions);
                        cache[query] = { data: suggestions, timestamp: Date.now() };
                    },
                    error: () => {
                        console.error('Erro ao buscar sugestões de pesquisa.');
                        alert('Não foi possível buscar sugestões de pesquisa. Tente novamente mais tarde.');
                        $('#suggestions').empty().hide();  // Limpar sugestões antigas
                    }
                });
            }
        }, 300));
    };

    // Função para atualizar a exibição das sugestões
    const updateSuggestions = (suggestions) => {
        $('#suggestions').html(suggestions).show();
    };

    // Função para alternar a exibição dos detalhes com acessibilidade e transições suaves
    const initializeDetailsToggle = () => {
        $('.congregation-card').on('click', '.details-toggle', function() {
            const details = $(this).closest('.congregation-card').find('.details');
            details.toggleClass('show');
            const isExpanded = details.hasClass('show');
            $(this).attr('aria-expanded', isExpanded);
            details.attr('aria-hidden', !isExpanded); // Melhorando acessibilidade

            // Usar transição suave
            details.stop(true, true).slideToggle();
        });
    };

    // Função para inicializar a validação do formulário
    const initializeFormValidation = () => {
        $('.search-form').validate({
            rules: {
                nome_congregacao: { minlength: 2 },
                ano_fundacao: { digits: true, min: 1000, max: new Date().getFullYear() }
            },
            messages: {
                nome_congregacao: { minlength: "O nome deve ter pelo menos 2 caracteres." },
                ano_fundacao: {
                    digits: "O ano deve ser um número válido.",
                    min: "O ano de fundação não pode ser anterior a 1000.",
                    max: "O ano de fundação não pode ser posterior ao ano atual."
                }
            },
            errorElement: 'div',
            errorPlacement: (error, element) => {
                error.addClass('invalid-feedback');
                error.appendTo(element.closest('.form-group'));
            },
            highlight: (element) => {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: (element) => {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
    };

    // Função para limpar o formulário e recarregar a página
    window.clearForm = () => {
        // Limpar todos os campos do formulário
        $('form')[0].reset();
        
        // Remover qualquer sugestão de autocomplete
        $('#suggestions').empty().hide();
        
        // Recarregar a página sem adicionar nova entrada no histórico
        window.location.replace(window.location.pathname);
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

