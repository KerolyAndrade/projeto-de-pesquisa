<!DOCTYPE html>
<html>
<head>
    <title>Pesquisa de Satisfação</title>
</head>
<body>
    <h2>Nova Pesquisa de Satisfação</h2>

    <p><strong>Instituição:</strong> {{ $surveyData['instituicao'] }}</p>
    <p><strong>Finalidade da Visita:</strong> {{ $surveyData['finalidade'] }}</p>
    <p><strong>Experiência:</strong> {{ $surveyData['experiencia'] }}</p>
    <p><strong>Sugestões:</strong> {{ $surveyData['sugestoes'] }}</p>
    <p><strong>Informações sobre Congregação:</strong> {{ $surveyData['informacoes_congregacao'] }}</p>
    <p><strong>Consentimento:</strong> {{ $surveyData['consentimento'] ? 'Sim' : 'Não' }}</p>

    @if($surveyData['anexo'])
        <p><strong>Anexo:</strong> <a href="{{ $surveyData['anexo'] }}" target="_blank">Clique aqui para ver o anexo</a></p>
    @endif
</body>
</html>
