<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatisfactionSurvey;
use App\Mail\SatisfactionSurveyMail;
use Illuminate\Support\Facades\Mail;

class SatisfactionSurveyController extends Controller
{
    public function store(Request $request)
    {
        // Validar os dados
        $request->validate([
            'instituicao' => 'required|string|max:255',
            'finalidade' => 'required|string|max:255',
            'experiencia' => 'required|string',
            'consentimento' => 'required|accepted',
            'anexo' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        // Armazenar os dados no banco de dados
        $surveyData = $request->all();

        // Se um anexo foi enviado, salvá-lo
        if ($request->hasFile('anexo')) {
            // Salvar o arquivo e gerar o caminho público
            $filePath = $request->file('anexo')->store('attachments', 'public');
            $surveyData['anexo'] = asset('storage/' . $filePath);
        }

        try {
            // Salvar os dados no banco
            $survey = SatisfactionSurvey::create($surveyData);

            // Enviar o e-mail com os dados
            Mail::to('guilherme.arduini@ifsp.edu.br')->send(new SatisfactionSurveyMail($surveyData));

            // Retornar resposta com sucesso
            return back()->with('success', 'Sua resposta foi enviada com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro, retornar uma mensagem de erro
            return back()->with('error', 'Ocorreu um erro ao salvar os dados. Tente novamente.');
        }
    }

    // Método para exportar os dados
    public function export()
    {
        // Pegar todos os dados das pesquisas
        $surveys = SatisfactionSurvey::all();

        // Gerar um arquivo CSV
        $filename = "pesquisas_satisfacao_" . now()->format('Y_m_d_H_i_s') . ".csv";
        $handle = fopen('php://output', 'w');

        // Cabeçalho do CSV
        fputcsv($handle, ['Instituição', 'Finalidade', 'Experiência', 'Sugestões', 'Informações sobre Congregação', 'Anexo', 'Consentimento', 'Criado em']);

        // Adicionar os dados das pesquisas
        foreach ($surveys as $survey) {
            fputcsv($handle, [
                $survey->instituicao,
                $survey->finalidade,
                $survey->experiencia,
                $survey->sugestoes,
                $survey->informacoes_congregacao,
                $survey->anexo,
                $survey->consentimento ? 'Sim' : 'Não',
                $survey->created_at
            ]);
        }

        fclose($handle);

        // Definir cabeçalhos para download do arquivo
        return response()->stream(
            function () use ($handle) {
                fclose($handle);
            },
            200,
            [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
            ]
        );
    }
}
