<?php

namespace Feature;

use App\Models\Despesa;
use App\Models\User;
use App\Notifications\DespesaCadastrada;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DespesaCadastradaTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_is_sent()
    {
        Notification::fake();

        $despesa = Despesa::factory()->create();
        $notifiable = User::factory()->create();
        $notifiable->notify(new DespesaCadastrada($despesa));

        Notification::assertSentTo(
            $notifiable,
            DespesaCadastrada::class,
            function ($notification, $channels) use ($despesa) {
                return $notification->getDespesa()->id === $despesa->id;
            }
        );
    }
}
