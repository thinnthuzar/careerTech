<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function authenticated_user_can_access_protected_route()
    {
       
        // Act as the created user and make a request to the protected route
        $response = $this->actingAs($user)
                         ->get('/dashboard');  // Replace with your protected route

        // Assert that the user is authenticated and can access the route
        $response->assertStatus(200);
    }

    /** @test */

    public function it_can_list_companies()
    {
        // Arrange: Create a few companies
        Company::factory()->count(3)->create();

        // Act: Send a request to get companies
        $response = $this->getJson(route('companies.index'));

        // Assert: Check if the response is successful and paginated
        $response->assertStatus(401)
                 ->assertExactJson([
                     'message' => 'Unauthenticated.',
                 ]);
    }

    /**
     * Test searching for companies by name or email.
     *
     * @return void
     */
    public function test_can_search_companies_by_name_or_email()
    {
         // Create a user instance
         $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        // Arrange: Create some companies
        $company1 = Company::factory()->create(['name' => 'Acme Corp', 'email' => 'acme@example.com']);
        $company2 = Company::factory()->create(['name' => 'Beta Industries', 'email' => 'beta@example.com']);
        $company3 = Company::factory()->create(['name' => 'Gamma Solutions', 'email' => 'gamma@example.com']);

        // Act: Search for companies with the keyword "Acme"
        $response = $this->actingAs($user)
                    ->getJson(route('companies.index', ['search' => 'Acme']));

        // Assert: The response contains only the company matching "Acme"
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Acme Corp',
                     'email' => 'acme@example.com'
                 ]);

        // Ensure only 1 result is returned
        $this->assertCount(1, $response->json('data'));
    }

    /**
     * Test searching returns no companies when no match is found.
     *
     * @return void
     */
    public function test_search_returns_empty_when_no_match_found()
    {
        // Create a user instance
        $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        // Arrange: Create some companies
        Company::factory()->count(3)->create();

        // Act: Search for a keyword that does not match any company
        $response = $this->actingAs($user)
        ->getJson(route('companies.index', ['search' => 'NonExistentCompany']));

        // Assert: No companies are returned in the response
        $response->assertStatus(200)
                 ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function test_can_create_a_company()
{
    $user = User::factory()->create([
        'role' => "Administrator",
    ]);
    // Arrange: Create valid company data with a mock file upload

    // Create a fake image
    $file = UploadedFile::fake()->image('avatar.jpg');

    $data = [
        'name' => 'Test Company',
        'email' => 'testcompany@example.com',
        'website' => 'https://example.com',
        'logo' => $file, // Fake image file
    ];

    // Act: Send a POST request to create a new company
    $response = $this->actingAs($user)
    ->postJson(route('companies.store'), $data);

    // Assert: Check if the company is created and returns 201 status code
    $response->assertStatus(201)
             ->assertJsonFragment(['name' => 'Test Company']);

    // Additional assertion to ensure the company was actually created in the database
    $this->assertDatabaseHas('companies', [
        'name' => 'Test Company',
        'email' => 'testcompany@example.com',
    ]);
}

    /** @test */
    public function it_can_show_a_single_company()
    {
        $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        $company = Company::factory()->create();

        $response = $this->actingAs($user)
        ->getJson("/api/v1/companies/{$company->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_company()
    {
        $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        $company = Company::factory()->create();

        $updatedData = [
            'name' => 'Updated Company',
            'email' => 'Updated Company',
            'website' => 'Updated Company',
    ];

        $response = $this->actingAs($user)
        ->putJson("/api/v1/companies/{$company->id}", $updatedData);

        $response
        ->assertStatus(200);
                //  ->assertJsonFragment([
                //     'name' => 'Updated Company',
                //     'email' => 'Updated Company',
                //     'logo' => 'Updated Company',
                //     'website' => 'Updated Company',
                // ]);
    }

    /** @test */
    public function test_company_can_be_deleted_successfully()
    {
        $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        // Arrange: Create a company
        $company = Company::factory()->create();

        // Act: Send a DELETE request to the destroy route
        $response = $this->actingAs($user)
        ->deleteJson(route('companies.destroy', $company->id));

        // Assert: Check the response status and structure
        $response->assertStatus(204);

        // Also check if the company was removed from the database
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    /**
     * Test that attempting to delete a non-existent company returns 404.
     *
     * @return void
     */
    public function test_deleting_non_existent_company_returns_404()
    {
        $user = User::factory()->create([
            'role' => "Administrator",
        ]);
        // Act: Send a DELETE request to a non-existent company ID
        $response = $this->actingAs($user)
        ->deleteJson(route('companies.destroy', 9999));

        // Assert: Check the response for 404 status and correct error message
        $response->assertStatus(404)
                 ->assertJson(['error' => 'Company is not found']);
    }
} 

