<?php

namespace App\Mail;

use App\Models\SatisfactionSurvey;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SatisfactionSurveyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;

    public function __construct(SatisfactionSurvey $survey)
    {
        $this->survey = $survey;
    }

    public function build()
    {
        return $this->subject('Nova Pesquisa de Satisfação')
                    ->view('emails.satisfaction_survey') // Criar a view do e-mail
                    ->with(['survey' => $this->survey]);
    }
}
