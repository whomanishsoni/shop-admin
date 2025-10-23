<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;

class SendEmailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $template;
    public $data;

    public function __construct(EmailTemplate $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function build()
    {
        $subject = $this->replaceVariables($this->template->subject);
        $body = $this->replaceVariables($this->template->body);

        return $this->subject($subject)
                    ->html($body);
    }

    private function replaceVariables($content)
    {
        foreach ($this->data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
}
