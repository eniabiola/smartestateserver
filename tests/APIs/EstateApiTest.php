<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Estate;

class EstateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_estate()
    {
        $estate = Estate::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/estates', $estate
        );

        $this->assertApiResponse($estate);
    }

    /**
     * @test
     */
    public function test_read_estate()
    {
        $estate = Estate::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/estates/'.$estate->id
        );

        $this->assertApiResponse($estate->toArray());
    }

    /**
     * @test
     */
    public function test_update_estate()
    {
        $estate = Estate::factory()->create();
        $editedEstate = Estate::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/estates/'.$estate->id,
            $editedEstate
        );

        $this->assertApiResponse($editedEstate);
    }

    /**
     * @test
     */
    public function test_delete_estate()
    {
        $estate = Estate::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/estates/'.$estate->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/estates/'.$estate->id
        );

        $this->response->assertStatus(404);
    }
}
