$(document).ready(() => {
    // Função para alterar a URL com os parâmetros de filtro quando a paginação é clicada
    const handlePaginationClick = (event) => {
        event.preventDefault(); // Impede o comportamento padrão do clique

        const link = $(this); // O link clicado
        const url = link.attr('href'); // A URL do link
        const page = new URL(url).searchParams.get('page'); // Obtém o número da página

        // Atualizar a URL com os filtros atuais e o número da página
        const filters = window.location.search; // Captura os filtros da URL atual
        const newUrl = `${window.location.pathname}${filters}&page=${page}`;

        // Carregar a nova URL via AJAX ou recarregar a página com os filtros e página
        window.history.pushState({}, '', newUrl); // Atualiza a URL sem recarregar a página
        loadPage(newUrl); // Carrega os dados da nova página com filtros
    };

    // Função para carregar a nova página
    const loadPage = (url) => {
        $.ajax({
            url: url,
            success: (data) => {
                // Substituir o conteúdo da página com os novos resultados
                $('#congregations-list').html($(data).find('#congregations-list').html());
                $('#pagination-links').html($(data).find('#pagination-links').html());
            },
            error: () => {
                alert('Erro ao carregar os dados. Tente novamente.');
            }
        });
    };

    // Adiciona o ouvinte de evento para os links de paginação
    $(document).on('click', '.pagination a', handlePaginationClick);

    // Função de debounce para otimizar chamadas de pesquisa
    const debounce = (func, delay) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), delay);
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
            if (query.length < 2) {
                $('#suggestions').hide().empty();
                return;
            }

            // Verifica se a sugestão está no cache e se não expirou
            if (cache[query] && (Date.now() - cache[query].timestamp < cacheExpirationTime)) {
                updateSuggestions(cache[query].data);  // Exibe sugestões cacheadas
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
                        $('#suggestions').empty().hide();  // Limpa sugestões em caso de erro
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
            const isExpanded = details.toggleClass('show').hasClass('show');
            $(this).attr('aria-expanded', isExpanded);
            details.attr('aria-hidden', !isExpanded); // Melhorando acessibilidade

            // Usar transição suave
            details.stop(true, true).slideToggle(300); // Desacelera o slideToggle para 300ms
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
                    max: `O ano de fundação não pode ser posterior ao ano atual (${new Date().getFullYear()}).`
                }
            },
            errorElement: 'div',
            errorPlacement: (error, element) => {
                error.addClass('invalid-feedback');
                error.insertAfter(element);  // Coloca o erro diretamente após o campo
            },
            highlight: (element) => {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: (element) => {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
    };

    window.clearForm = () => {
        // Limpar todos os campos do formulário
        $('form')[0].reset();
    
        // Limpar sugestões de autocomplete
        $('#suggestions').empty().hide();
    
        // Recarregar a página
        window.location.href = window.routeIndex;
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
