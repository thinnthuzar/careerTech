<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_company()
    {
        $company = Company::factory()->create();

        $this->assertDatabaseHas('companies', [
            'name' => $company->name,
            'email' => $company->email,
            'logo' => $company->logo,
            'website' => $company->website,
        ]);
    }

    /** @test */
    public function it_can_update_a_company()
    {
        $company = Company::factory()->create();

        $company->update([
            'name' => 'Updated Name',
            'logo' => 'Updated logo',
            'website' => 'Updated website']);

        $this->assertDatabaseHas('companies', [
            'name' => 'Updated Name',
            'logo' => 'Updated logo',
            'website' => 'Updated website']);
    }

    /** @test */
    public function it_can_delete_a_company()
    {
        $company = Company::factory()->create();

        $company->delete();

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }
}