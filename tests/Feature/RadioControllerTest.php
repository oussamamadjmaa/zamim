<?php

namespace Tests\Feature;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RadioControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_method()
    {
        \App::setLocale('en');

        $this->actingAs(Admin::first(), 'admin');

        // Define sample data
        $requestData = [
            'semester_id' => 1,
            'week_number' => 10,
            'level' => 'primary',
            'start_date' => Carbon::now()->format('Y-m-d'),
            'radios' => [
                ['subject' => 'Subject 1'],
                ['subject' => 'Subject 2 monday'],
                ['subject' => 'Subject updated'],
                ['subject' => 'Subject 4'],
                ['subject' => 'Subject 5'],
            ]
        ];

        // Simulate POST request to store method
        $response = $this->post(route('admin.radios.store'), $requestData);

        // Assert that the response is successful
        $response->assertStatus(200);

        $response->assertJson([]);
    }
}
