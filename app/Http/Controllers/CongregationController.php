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
        $filters = $this->getFilters();
        $query = Congregation::query();

        $input = $request->only([
            'nome_principal', 'nomes_alternativos', 'siglas', 'familia_final',
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                $this->applyFilter($query, $field, $value);
            }
        }

        $congregations = $query->paginate(10);
        $congregations->appends($request->except('page'));

        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    // Método de aplicação de filtros
    protected function applyFilter($query, $field, $value)
    {
        if ($field == 'ano_fundacao_de') {
            $query->whereYear('data_fundacao', '>=', $value);
        } elseif ($field == 'ano_fundacao_ate') {
            $query->whereYear('data_fundacao', '<=', $value);
        } elseif (in_array($field, ['familia_final', 'pais_fundacao', 'chegada_brasil_estado']) && is_array($value)) {
            $query->whereIn($field, $value);
        } elseif ($field == 'genero') {
            $validGeneros = ['f', 'm'];
            if (in_array(strtolower($value), $validGeneros)) {
                $query->whereRaw('LOWER(genero) = ?', [strtolower($value)]);
            }
        } else {
            // Ajuste para suportar operadores de busca avançados
            $value = trim($value);
            if (preg_match('/"(.*?)"/', $value, $matches)) {
                $query->whereRaw('LOWER(' . $field . ') LIKE ?', ['%' . strtolower($matches[1]) . '%']);
            } elseif (strpos($value, '+') !== false) {
                $words = explode('+', $value);
                foreach ($words as $word) {
                    $query->whereRaw('LOWER(' . $field . ') LIKE ?', ['%' . strtolower(trim($word)) . '%']);
                }
            } elseif (strpos($value, '-') !== false) {
                $words = explode('-', $value);
                foreach ($words as $word) {
                    $query->whereRaw('LOWER(' . $field . ') NOT LIKE ?', ['%' . strtolower(trim($word)) . '%']);
                }
            } else {
                $query->whereRaw('LOWER(' . $field . ') LIKE ?', ['%' . strtolower($value) . '%']);
            }
        }
    }

    public function search(Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->index($request);
        }
        return redirect()->route('congregations.index');
    }

    public function submitFormulario(Request $request)
    {
        $request->validate([
            'instituicao' => 'required|string|max:255',
            'finalidade' => 'required|string|max:255',
            'experiencia' => 'required|string|max:500',
            'sugestoes' => 'nullable|string|max:500',
            'anexos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $anexosPaths = [];
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $anexo) {
                if ($anexo->isValid()) {
                    $anexosPaths[] = $anexo->store('uploads', 'public');
                }
            }
        }

        return redirect()->route('congregations.sobre')->with('success', 'Formulário enviado com sucesso!');
    }

    public function showMap()
    {
        $filters = $this->getFilters();
        return view('congregations.mapa', compact('filters'));
    }

    public function getCongregacoesPorPais($pais)
    {
        $congregacoesCount = Congregation::where('pais_fundacao', $pais)->count();
        return response()->json([
            'pais' => $pais,
            'congregacoes' => $congregacoesCount,
        ]);
    }

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

