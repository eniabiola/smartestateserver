<?php namespace Tests\Repositories;

use App\Models\Cities;
use App\Repositories\CitiesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CitiesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CitiesRepository
     */
    protected $citiesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->citiesRepo = \App::make(CitiesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_cities()
    {
        $cities = Cities::factory()->make()->toArray();

        $createdCities = $this->citiesRepo->create($cities);

        $createdCities = $createdCities->toArray();
        $this->assertArrayHasKey('id', $createdCities);
        $this->assertNotNull($createdCities['id'], 'Created Cities must have id specified');
        $this->assertNotNull(Cities::find($createdCities['id']), 'Cities with given id must be in DB');
        $this->assertModelData($cities, $createdCities);
    }

    /**
     * @test read
     */
    public function test_read_cities()
    {
        $cities = Cities::factory()->create();

        $dbCities = $this->citiesRepo->find($cities->id);

        $dbCities = $dbCities->toArray();
        $this->assertModelData($cities->toArray(), $dbCities);
    }

    /**
     * @test update
     */
    public function test_update_cities()
    {
        $cities = Cities::factory()->create();
        $fakeCities = Cities::factory()->make()->toArray();

        $updatedCities = $this->citiesRepo->update($fakeCities, $cities->id);

        $this->assertModelData($fakeCities, $updatedCities->toArray());
        $dbCities = $this->citiesRepo->find($cities->id);
        $this->assertModelData($fakeCities, $dbCities->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_cities()
    {
        $cities = Cities::factory()->create();

        $resp = $this->citiesRepo->delete($cities->id);

        $this->assertTrue($resp);
        $this->assertNull(Cities::find($cities->id), 'Cities should not exist in DB');
    }
}
