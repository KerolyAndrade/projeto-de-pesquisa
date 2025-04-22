<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congregation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CongregationController extends Controller
{
    protected function getFilters()
    {
        return Cache::remember('congregation_filters', 60, function () {
            return [
                'familias' => Congregation::distinct()
                    ->pluck('familia_final')
                    ->filter()
                    ->sort(),

                'paises_fundacao' => Congregation::distinct()
                    ->pluck('pais_fundacao')
                    ->filter()
                    ->map(function ($item) {
                        return trim($item) === 'italia' ? 'Itália' : $item;
                    })
                    ->unique()
                    ->sort(),

                'estados_presente' => Congregation::distinct()
                    ->pluck('chegada_brasil_estado')
                    ->flatMap(function ($value) {
                        return collect(explode(',', str_replace('.', '', strtoupper($value))));
                    })
                    ->map('trim')
                    ->filter(function ($value) {
                        return $value !== 'RIO DE JANEIRO';
                    })
                    ->unique()
                    ->sort()
            ];
        });
    }

    public function index(Request $request)
    {
        $filters = $this->getFilters();
        $query = Congregation::query();

        $input = $request->only([
            'nome_principal', 'nomes_alternativos', 'siglas', 'familia_final',
            'pais_fundacao', 'chegada_brasil_estado', 'ano_fundacao_de', 'ano_fundacao_ate', 'genero'
        ]);

        $input = array_filter($input, function ($value) {
            return !empty($value);
        });

        foreach ($input as $field => $value) {
            if ($request->filled($field)) {
                $this->applyFilter($query, $field, $value);
            }
        }

        $congregations = $query->paginate(10);
        $congregations->appends($request->except('page'));

        foreach ($congregations as $congregation) {
            if ($congregation->familia_final) {
                $congregation->familia_final = $this->formatFamiliaFinal($congregation->familia_final);
            }
        }

        return view('congregations.index', [
            'congregations' => $congregations,
            'filters' => $filters
        ]);
    }

    protected function applyFilter($query, $field, $value)
    {
        if ($field == 'ano_fundacao_de') {
            $query->whereYear('data_fundacao', '>=', $value);
        } elseif ($field == 'ano_fundacao_ate') {
            $query->whereYear('data_fundacao', '<=', $value);
        } elseif ($field == 'chegada_brasil_estado') {
            $estados = is_array($value) ? $value : explode(',', $value);
            $query->where(function ($q) use ($estados) {
                foreach ($estados as $estado) {
                    $q->orWhere('chegada_brasil_estado', 'like', "%$estado%");
                }
            });
        } elseif ($field == 'pais_fundacao') {
            $query->whereIn('pais_fundacao', (array) $value);
        } elseif ($field == 'familia_final') {
            $query->whereIn('familia_final', (array) $value);
        } elseif ($field == 'genero') {
            $validGeneros = ['f', 'm'];
            if (in_array(strtolower($value), $validGeneros)) {
                $query->whereRaw('LOWER(genero) = ?', [strtolower($value)]);
            }
        } else {
            $query->where(function ($q) use ($field, $value) {
                $q->whereRaw('LOWER(' . $field . ') LIKE ?', ['%' . strtolower($value) . '%']);
            });
        }
    }

    public static function formatFamiliaFinal($familia)
    {
        if (preg_match('/^N\/[A-Za-z]+$/', strtoupper($familia))) {
            return strtoupper($familia);
        }
        return ucfirst(strtolower($familia));
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

    public function sobre() { return view('congregations.sobre'); }
    public function equipe() { return view('congregations.equipe'); }
    public function mapa() { return view('congregations.mapa'); }
    public function apresentacao() { return view('congregations.apresentacao'); }
}
