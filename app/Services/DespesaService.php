<?php

namespace App\Services;

use App\Models\Despesa;
use App\Models\User;
use App\Notifications\DespesaCadastrada;

class DespesaService
{
    public function getAll()
    {
        return Despesa::where('usuario_id', auth()->id())->get();
    }

    public function create(array $data)
    {
        $despesa = Despesa::create($data);

        $user = $despesa->user;
        if ($user) {
            $user->notify(new DespesaCadastrada($despesa));
        }

        return $despesa;
    }

    public function update(Despesa $despesa, array $data): Despesa
    {
        $despesa->update($data);
        return $despesa;
    }

    public function delete(Despesa $despesa): void
    {
        $despesa->delete();
    }
}
