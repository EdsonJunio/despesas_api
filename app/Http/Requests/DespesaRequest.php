<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descricao' => 'required|string|max:191',
            'data' => 'required|date|before_or_equal:today',
            'valor' => 'required|numeric|min:0',
            'usuario_id' => 'required|integer|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'A descrição da despesa é requerida.',
            'descricao.string' => 'A descrição da despesa deve ser uma string.',
            'descricao.max' => 'A descrição da despesa não pode ter mais que 191 caracteres.',
            'data.required' => 'A data é requerida.',
            'data.date' => 'A data deve ser um formato de data válido.',
            'data.before_or_equal' => 'A data não pode ser no futuro.',
            'valor.required' => 'O valor é requerido.',
            'valor.numeric' => 'O valor deve ser uma número.',
            'valor.min' => 'O valor não pode ser negativo.',
            'usuario_id.required' => 'O ID do usuário é requerido.',
            'usuario_id.exists' => 'O ID do usuário deve existir na tabela de usuários.',
        ];
    }
}
