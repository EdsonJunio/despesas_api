<?php

namespace Feature;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DespesaControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;
    private $despesa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }

    public function testIndexCanRetrieveUserExpenses()
    {
        $this->despesa = Despesa::factory()->count(5)->create(['usuario_id' => $this->user->id]);

        $response = $this->getJson('/api/despesas');

        $response->assertStatus(200);
        $response->assertJsonCount(count($this->despesa), 'data');
    }

    public function testStoreCanCreateAnExpense()
    {
        $despesaData = Despesa::factory()->make(['usuario_id' => $this->user->id])->toArray();

        $response = $this->postJson('/api/despesas', $despesaData);

        $response->assertCreated();
        $response->assertJson(['descricao' => $despesaData['descricao']]);
    }

    public function testUpdateCanModifyAnExpense()
    {
        $this->despesa = Despesa::factory()->create(['usuario_id' => $this->user->id]);

        $updatedData = ['valor' => 5000, 'descricao' => 'Nova descricao', 'data' => '2022-12-12', 'usuario_id' => $this->user->id];

        $response = $this->putJson("/api/despesas/{$this->despesa->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['descricao' => $updatedData['descricao']]);
    }

    public function testShowCanDisplayAnExpense()
    {
        $this->despesa = Despesa::factory()->create(['usuario_id' => $this->user->id]);

        $response = $this->getJson("/api/despesas/{$this->despesa->id}");

        $response->assertStatus(200);
    }

    public function testDestroyCanRemoveAnExpense()
    {
        $this->despesa = Despesa::factory()->create(['usuario_id' => $this->user->id]);

        $response = $this->deleteJson("/api/despesas/{$this->despesa->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('despesas', ['id' => $this->despesa->id]);
    }
}
