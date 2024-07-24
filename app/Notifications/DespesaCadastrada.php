<?php

namespace App\Notifications;

use App\Models\Despesa;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DespesaCadastrada extends Notification
{
    use Queueable;

    private $despesa;

    public function __construct(Despesa $despesa)
    {
        $this->despesa = $despesa;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Despesa cadastrada')
            ->greeting('Olá!')
            ->line('Uma nova despesa foi cadastrada com os seguintes detalhes:')
            ->line('Descrição: ' . $this->despesa->descricao)
            ->line('Data: ' . Carbon::parse($this->despesa->data)->format('d/m/Y'))
            ->line('Valor: R$ ' . number_format($this->despesa->valor, 2, ',', '.'))
            ->salutation('Atenciosamente, ' . config('app.name'));
    }
}
