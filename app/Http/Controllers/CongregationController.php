<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;
use Illuminate\Support\Facades\Cache;

class CongregationController extends Controller
{
    // Método para obter os filtros de pesquisa e cacheá-los
    protected function getFilters()
    {
        return Cache::remember('congregation_filters', 60, function () {
            return [
                'familias' => Congregation::distinct()->pluck('familia_final')->sort(),
                'paises_fundacao' => Congregation::distinct()->pluck('pais_fundacao')->sort(),
                'estados_presente' => Congregation::distinct()->pluck('chegada_brasil_estado')->sort()
            ];
        });
    }

    // Método de exibição das congregações com filtros aplicados
    public function index(Request $request)
    {
        // Obtemos os filtros
        $filters = $this->getFilters();  // Obtemos os filtros disponíveis para seleção
        $query = Congregation::query();  // Iniciamos a consulta

        // Pegamos todos os filtros da requisição (usando 'only' para garantir que só os filtros sejam coletados)
        $input = $request->only([
            'nome_principal', 'nomes_alternativos', 'siglas', 'familia_final',
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        // Aplica os filtros um a um na consulta, se existirem
        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                $this->applyFilter($query, $field, $value);
            }
        }

        // Paginação de resultados
        $congregations = $query->paginate(10);

        // Garantir que os filtros permanecem na URL ao navegar pelas páginas
        $congregations->appends($request->except('page')); // Mantém os filtros na URL, exceto o parâmetro 'page'

        // Retorna a view com os dados e filtros
        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    // Método de aplicação de filtros
    protected function applyFilter($query, $field, $value)
    {
        // Para ano de fundação
        if ($field == 'ano_fundacao_de') {
            $query->whereYear('data_fundacao', '>=', $value);
        } elseif ($field == 'ano_fundacao_ate') {
            $query->whereYear('data_fundacao', '<=', $value);
        }

        // Para filtros de seleção múltipla (familia_final, pais_fundacao, chegada_brasil_estado)
        elseif (in_array($field, ['familia_final', 'pais_fundacao', 'chegada_brasil_estado']) && is_array($value)) {
            $query->whereIn($field, $value);
        }

        // Para filtro de gênero
        elseif ($field == 'genero') {
            $validGeneros = ['f', 'm']; // 'f' para feminino, 'm' para masculino
            if (in_array(strtolower($value), $validGeneros)) {
                $query->whereRaw('LOWER(genero) = ?', [strtolower($value)]);
            }
        }

        // Para outros campos, utilizando LIKE
        else {
            $query->whereRaw('LOWER(' . $field . ') LIKE ?', [strtolower('%' . trim($value) . '%')]);
        }
    }

    // Método de busca (por POST)
    public function search(Request $request)
    {
        // Se for uma requisição POST, chamamos o método index
        if ($request->isMethod('post')) {
            return $this->index($request);
        }

        // Se for GET, retorna a view inicial
        return redirect()->route('congregations.index');
    }

    // Método de processamento do formulário (incluindo anexos)
    public function submitFormulario(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'instituicao' => 'required|string|max:255',
            'finalidade' => 'required|string|max:255',
            'experiencia' => 'required|string|max:500',
            'sugestoes' => 'nullable|string|max:500',
            'anexos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // Validação para múltiplos arquivos
        ]);

        // Lidar com os anexos
        $anexosPaths = [];
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $anexo) {
                if ($anexo->isValid()) {
                    $anexosPaths[] = $anexo->store('uploads', 'public'); // Armazenar cada arquivo
                }
            }
        }

        // Aqui você pode processar os dados do formulário, salvar no banco, etc.

        // Retornar com sucesso
        return redirect()->route('congregations.sobre')->with('success', 'Formulário enviado com sucesso!');
    }
    public function showMap()
    {
        // Obter os filtros utilizando o método que utiliza cache
        $filters = $this->getFilters();
    
        // Retornar a view e passar os filtros para ela
        return view('congregations.mapa', compact('filters'));
    }
    public function getCongregacoesPorPais($pais)
{
    // Contar o número de congregações no país fornecido
    $congregacoesCount = Congregation::where('pais_fundacao', $pais)->count();

    // Retornar os dados em formato JSON
    return response()->json([
        'pais' => $pais,
        'congregacoes' => $congregacoesCount,
    ]);
}


    // Métodos adicionais para outras páginas
    public function sobre()
    {
        return view('congregations.sobre');
    }

    public function equipe()
    {
        return view('congregations.equipe');
    }

    public function mapa()
    {
        return view('congregations.mapa');
    }
    
    public function apresentacao()
    {
        return view('congregations.apresentacao');
    }
}
