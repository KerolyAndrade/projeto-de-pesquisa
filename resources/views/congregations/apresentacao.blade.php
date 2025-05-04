@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Cartão de fundo -->
            <div class="card bg-light shadow-sm p-4">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="card shadow">
                            <div class="card-header text-center">
                                <h2>Pesquisa de Satisfação</h2>
                            </div>
                            <div class="card-body">
                                <p>
                                    Olá, obrigado por visitar nosso site!<br>
                                    Nós, da equipe responsável pela geração e administração do banco de dados, gostaríamos de conhecer você melhor para continuar aprimorando nossos serviços.
                                    Sua opinião é muito importante para nós!
                                    Por favor, dedique alguns minutos para responder as perguntas abaixo. Suas respostas nos ajudarão a entender melhor sua visita e como podemos melhorar:
                                </p>
                                <br>

                                <form method="POST" action="{{ route('formulario.submit') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="instituicao">De onde você é? (Instituição, região ou país)</label>
                                        <input type="text" class="form-control" id="instituicao" name="instituicao" placeholder="Ex: Universidade XYZ, São Paulo, Brasil" required>
                                        @error('instituicao')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="finalidade">Qual é a finalidade da sua visita?</label>
                                        <select class="form-control" id="finalidade" name="finalidade" required>
                                            <option value="" disabled selected>Selecione uma opção</option>
                                            <option value="trabalho_academico">Trabalho Acadêmico</option>
                                            <option value="outro">Outro</option>
                                        </select>
                                        @error('finalidade')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="experiencia">Como foi sua experiência no uso da nossa página?</label>
                                        <textarea class="form-control" id="experiencia" name="experiencia" rows="3" placeholder="Compartilhe sua experiência" required></textarea>
                                        @error('experiencia')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="sugestoes">Gostaria de sugerir alguma modificação ou acrescentar algo aos dados presentes?</label>
                                        <textarea class="form-control" id="sugestoes" name="sugestoes" rows="3" placeholder="Se tiver sugestões, nos avise"></textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="informacoes_congregacao">Se você tem mais informações sobre alguma congregação ou experiência específica, por favor, compartilhe conosco:</label>
                                        <textarea class="form-control" id="informacoes_congregacao" name="informacoes_congregacao" rows="3" placeholder="Compartilhe experiências ou informações adicionais"></textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="anexo">Anexar um arquivo (opcional)</label>
                                        <input type="file" class="form-control" id="anexo" name="anexo">
                                        @error('anexo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="consentimento" name="consentimento" required>
                                        <label class="form-check-label" for="consentimento">
                                            Eu concordo com a coleta e uso das informações fornecidas de acordo com nossa
                                            <a href="{{ route('termos') }}" target="_blank">política de privacidade</a>.
                                        </label>
                                        @error('consentimento')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <br>

                                    <!-- Botões alinhados -->
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary">Limpar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>

                                </form>
                            </div> <!-- card-body -->
                        </div> <!-- card -->
                    </div>
                </div>
            </div> <!-- fundo -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/apresentacao.js') }}"></script>
@endsection
