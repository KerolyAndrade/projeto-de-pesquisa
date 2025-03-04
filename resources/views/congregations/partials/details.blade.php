<div class="section mb-4">
    <h3 class="section-title mb-3">Dados Gerais</h3>
    <p><strong>Nomes Alternativos:</strong> {{ $congregation->nomes_alternativos ?? 'Não Informado' }}</p>
    <p><strong>Família Final:</strong> {{ $congregation->familia_final ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Fundação -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Fundação</h3>
    <p><strong>Ano de Fundação:</strong> {{ \Carbon\Carbon::parse($congregation->data_fundacao)->year ?? 'Não Informado' }}</p>
    <p><strong>País de Fundação:</strong> {{ $congregation->pais_fundacao ?? 'Não Informado' }}</p>
    <p><strong>Cidade de Fundação:</strong> {{ $congregation->cidade_fundacao ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Chegada ao Brasil -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Chegada ao Brasil</h3>
    <p><strong>Estado:</strong> {{ $congregation->chegada_brasil_estado ?? 'Não Informado' }}</p>
    <p><strong>Município:</strong> {{ $congregation->chegada_brasil_municipio ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Membros -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Membros</h3>
    <p><strong>Membros no Brasil:</strong> {{ $congregation->membros_brasil ?? 'Não Informado' }}</p>
    <p><strong>Irmandade:</strong> {{ $congregation->irmaos ?? 'Não Informado' }}</p>
    <p><strong>Postulantes:</strong> {{ $congregation->postulantes ?? 'Não Informado' }}</p>
    <p><strong>Noviços:</strong> {{ $congregation->novicos ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Carisma -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Carisma</h3>
    <p>{{ $congregation->carisma ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Motivos da Vinda -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Motivos da Vinda</h3>
    <p>{{ $congregation->motivos_vinda ?? 'Não Informado' }}</p>
</div>

<!-- Seção de Referências -->
<div class="section mb-4">
    <h3 class="section-title mb-3">Referências</h3>
    @if($congregation->sources->isNotEmpty())
        @foreach($congregation->sources as $index => $source)
            <p>[{{ $index + 1 }}] <a href="{{ $source->url }}" target="_blank">{{ $source->url }}</a></p>
        @endforeach
    @else
        <p>Não Informado</p>
    @endif
</div>
