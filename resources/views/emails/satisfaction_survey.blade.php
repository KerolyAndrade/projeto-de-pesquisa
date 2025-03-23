<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Satisfação</title>
</head>
<body>
    <h2>Nova Pesquisa de Satisfação</h2>
    <p><strong>Instituição:</strong> {{ $survey->instituicao }}</p>
    <p><strong>Finalidade:</strong> {{ $survey->finalidade }}</p>
    <p><strong>Experiência:</strong> {{ $survey->experiencia }}</p>

    @if($survey->sugestoes)
        <p><strong>Sugestões:</strong> {{ $survey->sugestoes }}</p>
    @endif

    @if($survey->informacoes_congregacao)
        <p><strong>Informações sobre Congregação:</strong> {{ $survey->informacoes_congregacao }}</p>
    @endif

    @if($survey->anexo)
        <p><strong>Anexo:</strong> <a href="{{ $survey->anexo }}" target="_blank">Ver Anexo</a></p>
    @endif

    <p><strong>Consentimento:</strong> {{ $survey->consentimento ? 'Aceito' : 'Não Aceito' }}</p>
</body>
</html>
