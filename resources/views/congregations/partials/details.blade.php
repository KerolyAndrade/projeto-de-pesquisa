<!-- Seção de Dados Gerais -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Dados Gerais</h3>
    <p><strong>Nomes Alternativos:</strong> <span class="text-muted">{{ $congregation->nomes_alternativos ?? 'Não Informado' }}</span></p>
    <p><strong>Família Final:</strong> <span class="text-muted">{{ $congregation->familia_final ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Fundação -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Fundação</h3>
    <p><strong>Ano de Fundação:</strong> <span class="text-muted">{{ \Carbon\Carbon::parse($congregation->data_fundacao)->year ?? 'Não Informado' }}</span></p>
    <p><strong>País de Fundação:</strong> <span class="text-muted">{{ $congregation->pais_fundacao ?? 'Não Informado' }}</span></p>
    <p><strong>Cidade de Fundação:</strong> <span class="text-muted">{{ $congregation->cidade_fundacao ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Chegada ao Brasil -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Chegada ao Brasil</h3>
    <p><strong>Estado:</strong> <span class="text-muted">{{ $congregation->chegada_brasil_estado ?? 'Não Informado' }}</span></p>
    <p><strong>Município:</strong> <span class="text-muted">{{ $congregation->chegada_brasil_municipio ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Membros -->
<div class="section mb-5">
    <h3class="section-title" style="margin-bottom: 4px;">Membros</h3>
    <p><strong>Membros no Brasil:</strong> <span class="text-muted">{{ $congregation->membros_brasil ?? 'Não Informado' }}</span></p>
    <p><strong>Irmandade:</strong> <span class="text-muted">{{ $congregation->irmaos ?? 'Não Informado' }}</span></p>
    <p><strong>Postulantes:</strong> <span class="text-muted">{{ $congregation->postulantes ?? 'Não Informado' }}</span></p>
    <p><strong>Noviços:</strong> <span class="text-muted">{{ $congregation->novicos ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Carisma -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Carisma</h3>
    <p><span class="text-muted">{{ $congregation->carisma ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Motivos da Vinda -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Motivos da Vinda</h3>
    <p><span class="text-muted">{{ $congregation->motivos_vinda ?? 'Não Informado' }}</span></p>
</div>
<br>

<!-- Seção de Referências -->
<div class="section mb-5">
    <h3 class="section-title" style="margin-bottom: 4px;">Referências</h3>
    @if($congregation->sources->isNotEmpty())
        @foreach($congregation->sources as $index => $source)
            <p>[{{ $index + 1 }}] <a href="{{ $source->url }}" target="_blank" class="text-primary">{{ $source->url }}</a></p>
        @endforeach
    @else
        <p><span class="text-muted">Não Informado</span></p>
    @endif
</div>

