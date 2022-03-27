<?php namespace Tests\Repositories;

use App\Models\Estate;
use App\Repositories\EstateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EstateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EstateRepository
     */
    protected $estateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->estateRepo = \App::make(EstateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_estate()
    {
        $estate = Estate::factory()->make()->toArray();

        $createdEstate = $this->estateRepo->create($estate);

        $createdEstate = $createdEstate->toArray();
        $this->assertArrayHasKey('id', $createdEstate);
        $this->assertNotNull($createdEstate['id'], 'Created Estate must have id specified');
        $this->assertNotNull(Estate::find($createdEstate['id']), 'Estate with given id must be in DB');
        $this->assertModelData($estate, $createdEstate);
    }

    /**
     * @test read
     */
    public function test_read_estate()
    {
        $estate = Estate::factory()->create();

        $dbEstate = $this->estateRepo->find($estate->id);

        $dbEstate = $dbEstate->toArray();
        $this->assertModelData($estate->toArray(), $dbEstate);
    }

    /**
     * @test update
     */
    public function test_update_estate()
    {
        $estate = Estate::factory()->create();
        $fakeEstate = Estate::factory()->make()->toArray();

        $updatedEstate = $this->estateRepo->update($fakeEstate, $estate->id);

        $this->assertModelData($fakeEstate, $updatedEstate->toArray());
        $dbEstate = $this->estateRepo->find($estate->id);
        $this->assertModelData($fakeEstate, $dbEstate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_estate()
    {
        $estate = Estate::factory()->create();

        $resp = $this->estateRepo->delete($estate->id);

        $this->assertTrue($resp);
        $this->assertNull(Estate::find($estate->id), 'Estate should not exist in DB');
    }
}
