<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacultyEvaluationResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluationClass;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($evaluationClass, $filePath)
    {
        $this->evaluationClass = $evaluationClass;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Evaluation Complete')
        ->view('mail.faculty_evaluation_result')
        ->attach(public_path().'/'.$this->filePath);
    }
}
