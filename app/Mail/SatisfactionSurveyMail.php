<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SatisfactionSurveyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surveyData;

    // Recebe os dados da pesquisa
    public function __construct($surveyData)
    {
        $this->surveyData = $surveyData;
    }

    // Define o conteúdo do e-mail
    public function build()
    {
        return $this->subject('Nova Pesquisa de Satisfação Enviada')
                    ->view('emails.satisfaction_survey')
                    ->with([
                        'surveyData' => $this->surveyData,
                    ]);
    }
}

