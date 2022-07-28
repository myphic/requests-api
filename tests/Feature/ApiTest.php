<?php

namespace Tests\Feature;

use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тест для GET /requests.
     *
     * @return void
     */
    public function test_service()
    {
        $response = $this->get('/requests');
        $response->assertStatus(200);
    }

    /**
     * Тест для POST /requests.
     *
     * @return void
     */
    public function test_post_request()
    {
        $req = Request::factory()->create();
        $response = $this->post('/requests', [
            'name' => $req->name,
            'email' => $req->email,
            'message' => $req->message,
        ]);
        $response->assertStatus(201);
    }
}
