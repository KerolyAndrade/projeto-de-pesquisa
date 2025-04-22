@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="row justify-content-center m-0">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Equipe responsável</h2>
                    </div>
                    <div class="card-body">
                        <!-- Tabela com informações da equipe -->
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Lattes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Agueda Bernardete Bittencourt (coord.)</td>
                                    <td><a href="mailto:agueda.bittencourt@gmail.com">agueda.bittencourt@gmail.com</a></td>
                                    <td><a href="http://lattes.cnpq.br/0060199832265588" target="_blank">Apresentação</a></td>
                                </tr>
                                <tr>
                                    <td>Paula Leonardi</td>
                                    <td><a href="mailto:leonardi.paula@gmail.com">leonardi.paula@gmail.com</a></td>
                                    <td><a href="http://lattes.cnpq.br/6930629041565848" target="_blank">Apresentação</a></td>
                                </tr>
                                <tr>
                                    <td>Guilherme Ramalho Arduini</td>
                                    <td><a href="guilherme.arduini@ifsp.edu.br">guilherme.arduini@ifsp.edu.br</a></td>
                                    <td><a href="http://lattes.cnpq.br/4213387772904874" target="_blank">Apresentação</a></td>
                                </tr>
                                <tr>
                                    <td>Vinicius Parolin Wohnrath</td>
                                    <td><a href="mailto:vinicius.wohnrath@gmail.com">vinicius.wohnrath@gmail.com</a></td>
                                    <td><a href="http://lattes.cnpq.br/1701305518221688" target="_blank">Apresentação</a></td>
                                </tr>
                                <tr>
                                    <td>Marcos Yakuwa Mekaru</td>
                                    <td><a href="mailto:marcosmekaru@gmail.com">marcosmekaru@gmail.com</a></td>
                                    <td><a href="http://lattes.cnpq.br/8097381387820446" target="_blank">Apresentação</a></td>
                                </tr>
                            </tbody>
                        </table>

                        <br>

                        <p><strong>Bolsistas:</strong> Bruno Alves Pereira, Marcos dos Santos, Daniel Catarino Biscalchin, Keroly Andrade</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
