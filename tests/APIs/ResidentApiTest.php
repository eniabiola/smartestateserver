<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Resident;

class ResidentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_resident()
    {
        $resident = Resident::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/residents', $resident
        );

        $this->assertApiResponse($resident);
    }

    /**
     * @test
     */
    public function test_read_resident()
    {
        $resident = Resident::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/residents/'.$resident->id
        );

        $this->assertApiResponse($resident->toArray());
    }

    /**
     * @test
     */
    public function test_update_resident()
    {
        $resident = Resident::factory()->create();
        $editedResident = Resident::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/residents/'.$resident->id,
            $editedResident
        );

        $this->assertApiResponse($editedResident);
    }

    /**
     * @test
     */
    public function test_delete_resident()
    {
        $resident = Resident::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/residents/'.$resident->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/residents/'.$resident->id
        );

        $this->response->assertStatus(404);
    }
}
