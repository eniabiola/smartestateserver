<?php namespace Tests\Repositories;

use App\Models\Resident;
use App\Repositories\ResidentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ResidentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ResidentRepository
     */
    protected $residentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->residentRepo = \App::make(ResidentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_resident()
    {
        $resident = Resident::factory()->make()->toArray();

        $createdResident = $this->residentRepo->create($resident);

        $createdResident = $createdResident->toArray();
        $this->assertArrayHasKey('id', $createdResident);
        $this->assertNotNull($createdResident['id'], 'Created Resident must have id specified');
        $this->assertNotNull(Resident::find($createdResident['id']), 'Resident with given id must be in DB');
        $this->assertModelData($resident, $createdResident);
    }

    /**
     * @test read
     */
    public function test_read_resident()
    {
        $resident = Resident::factory()->create();

        $dbResident = $this->residentRepo->find($resident->id);

        $dbResident = $dbResident->toArray();
        $this->assertModelData($resident->toArray(), $dbResident);
    }

    /**
     * @test update
     */
    public function test_update_resident()
    {
        $resident = Resident::factory()->create();
        $fakeResident = Resident::factory()->make()->toArray();

        $updatedResident = $this->residentRepo->update($fakeResident, $resident->id);

        $this->assertModelData($fakeResident, $updatedResident->toArray());
        $dbResident = $this->residentRepo->find($resident->id);
        $this->assertModelData($fakeResident, $dbResident->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_resident()
    {
        $resident = Resident::factory()->create();

        $resp = $this->residentRepo->delete($resident->id);

        $this->assertTrue($resp);
        $this->assertNull(Resident::find($resident->id), 'Resident should not exist in DB');
    }
}
