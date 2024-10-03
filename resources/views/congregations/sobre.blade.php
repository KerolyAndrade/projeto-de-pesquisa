@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Congregações Católicas, Educação e Estado Nacional</h1>
    
    <section>
        <p>Os dados aqui oferecidos aos pesquisadores e interessados no tema em estudo são produto do Projeto Temático: Congregações Católicas, Educação e Estado Nacional, desenvolvido no período de 2012/2017, coordenado pela professora Agueda Bernardete Bittencourt, apoiado pela Fapesp.</p>
    </section>

    <section>
        <h2>Sobre o Projeto</h2>
        <p>Este projeto tratou da emigração de congregações religiosas para o Brasil, desde o final do século XIX até meados do século XX. Examinou alianças, disputas e acordos que oportunizaram o deslocamento dessas congregações europeias, suas relações com o projeto da Igreja Católica para o Brasil, com o processo de romanização da própria Igreja e com os projetos políticos das próprias congregações em fase de internacionalização.</p>
        <p>Analisou os efeitos da chegada de congregações religiosas no País, no momento de construção do Sistema Nacional de Educação, de lutas pela laicização do Estado e da sociedade e de configuração das cidades modernas. Tem seu foco central na educação, entendida como processo de socialização de recém-chegados – crianças e estrangeiros. Educação que se estende para além da escolarização, e é marcada pela vida urbana, pela estética da cidade, pelos objetos da cultura – edifícios, livros, estruturas empresariais, artes - e pelas linguagens.</p>
        <p>A Igreja Católica, e as congregações religiosas em particular, estabeleceram marcas profundas no processo de educação, urbanização e modernização brasileira iniciado com a República, anônimos, pela cidade que já incorporou igrejas e colégios à estética urbana.</p>
    </section>

    <section>
        <h2>Outros Resultados do Projeto</h2>
        <p>Outros resultados do Projeto podem ser encontrado especialmente nos seguintes dossiês:</p>
        <ul>
            <li>Dossiê “Catolicismo e Formação Cultural”, Pró-Posições (UNICAMP. Impresso), 0103-7307, v.25, n 72.</li>
            <li>Dossiê Políticas Católicas: educação, arte e religião. Revista Brasileira de História da Educação, Campinas-SP, v. 15, n. 2 (38), maio/agosto 2015. <a href="https://www.rbhe.sbhe.org.br">Link</a>.</li>
            <li>Dossiê Empreendimentos sociais, elite eclesiástica e congregações religiosas no Brasil República: A arte de “formar bons cidadãos e bons cristãos”. Revista Pro-Posições (UNICAMP. Impresso), 0103-7307, v. 28, n 3, set/dez 2017.</li>
        </ul>
    </section>

    <section>
        <h2>Sobre o Banco de Dados</h2>
        <h3>Imigração e Catolicismo</h3>
        <p>O banco de dados sobre as congregações atualmente conta com 590 congregações, a maioria das quais ainda exerce atividades no Brasil. Destas congregações, 485 são femininas e 104 masculinas. Do total de congregações, 91 foram fundadas no Brasil, e o restante em 38 países estrangeiros diferentes.</p>
        <p>Das congregações cujos países de fundação puderam ser discernidos, há oito que possuem mais de dez congregações no país, compondo 87% do total: Itália, Brasil, França, Espanha, Alemanha, Bélgica, Holanda, e EUA.</p>
        <p>Quanto a sua atuação no Brasil, no campo de informações quantitativas há informações sobre as datas de chegada no país, local inicial de instalação, o número e graduação dos fundadores, o número de casas e membros atualmente presentes no Brasil e em que estados estão. Quando possível, há informações sobre casas do país que foram fechadas.</p>
        <p>Paralelas a estas, há informações sobre o número de casas e membros no mundo, e os países nos quais a congregação atua.</p>
    </section>

    <section>
        <h3>Sobre as fontes</h3>
        <p>Inicialmente, o banco de dados foi alimentado com informações obtidas das próprias congregações por meio de formulários que foram enviados a elas. No entanto, em muitos casos, foi decidida a busca de informações via internet, nos sites das próprias congregações ou sobre elas.</p>
        <p>Foi dada precedência às informações de fontes cuja origem são as próprias congregações, ou relacionadas à Santa Sé e seu aparato administrativo (dioceses, arquidioceses), mas em muitos casos, as informações desejadas foram encontradas somente em sites de autoria de terceiros.</p>
    </section>

    <section>
        <h3>Sobre a listagem de congregações</h3>
        <p>A listagem básica de congregações que foi consultada para a realização do banco foi o Anuário Católico 2015, apesar de haver algumas congregações que constam no banco que estão no banco de dados.</p>
        <p>O AC2015 foi utilizado também como fonte de padronização dos nomes das congregações, para facilitar a verificação dos dados na fonte, caso seja necessário.</p>
    </section>

    <section>
        <h3>Sobre as informações</h3>
        <p>Como notado no tópico sobre as fontes, nem sempre foi possível encontrar fontes das próprias congregações para o preenchimento, portanto, sempre que possível nos campos quantitativos (datas, dados numéricos em geral) foi dada a preferência para uma ou outra fonte, em geral o AC 2015.</p>
        <p>Nos casos de conflito de dados, tentou-se adicionar notas explicativas que esclareçam os problemas.</p>
    </section>

    <section>
        <h3>Abreviações, siglas, notações</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Sigla</th>
                    <th>Significado</th>
                    <th>Sigla</th>
                    <th>Significado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>AC</td>
                    <td>"Anuário Católico", em geral seguido do ano de publicação</td>
                    <td>AC</td>
                    <td>"Aprovação das Constituições"</td>
                </tr>
                <tr>
                    <td>N/A</td>
                    <td>"Não se aplica"</td>
                    <td>DL</td>
                    <td>"Decretum Laudis", "Decreto de Louvor"</td>
                </tr>
                <tr>
                    <td>N/E</td>
                    <td>"Não encontrado"</td>
                    <td>DE</td>
                    <td>Direito Eparquial</td>
                </tr>
                <tr>
                    <td>N/I</td>
                    <td>"Não Informado", no caso de congregações com formulários preenchidos</td>
                    <td>VA</td>
                    <td>Vida Ativa</td>
                </tr>
                <tr>
                    <td>[F]</td>
                    <td>"Formulário", indica que a informação vem dos formulários devolvidos pelas congregações</td>
                    <td>VC</td>
                    <td>Vida Contemplativa</td>
                </tr>
                <tr>
                    <td>[?]</td>
                    <td>Indica que a informação tem fonte desconhecida/incerta</td>
                    <td>VM</td>
                    <td>Vida Mista</td>
                </tr>
                <tr>
                    <td>DD</td>
                    <td>Direito Diocesano</td>
                    <td>CLE</td>
                    <td>Vida Clerical</td>
                </tr>
                <tr>
                    <td>DP</td>
                    <td>Direito Pontifício</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h3>Sobre a tradução de informações</h3>
        <p>Para a maioria das línguas das quais informações foram traduzidas, não foi necessária a utilização de meios de tradução mecânica (Google Translate). Estas línguas incluem o inglês, francês, alemão, e espanhol.</p>
        <p>Para algumas, foi necessária alguma utilização de tradução mecânica - italiano e holandês/flamengo. Para um último grupo, não foi possível obter informações senão por meio da tradução por meios mecânicos: ucraniano, polonês, húngaro, árabe, japonês.</p>
        <p>Em todos os casos onde a tradução mecânica foi utilizada, o resultado foi revisado, e preferiu-se traduzir primeiro para o inglês, e então para o português.</p>
    </section>

    <section>
        <h3><a href="URL_DO_BANCO_DE_DADOS">Clique aqui para acessar o banco de dados das congregações religiosas.</a></h3>
    </section>
</div>
@endsection
