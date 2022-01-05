<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    public function test_success_regitration() {
        
        $findUser = User::where('email', 'backend@multicorp.com')->first();
        
        $response = $this->post('/api/register',[
            'email' => 'backend@multicorp.com',
            'password' => 'test123'
        ]);

        if ($findUser) {
            $response->assertStatus(400);
        } else {
            $response->assertStatus(201);
        }

    }

    public function test_unsuccess_registration() {
        $response = $this->post('/api/register',[
            'email' => 'backend@multicorp.com',
            'password' => 'test123'
        ]);

        $response->assertStatus(400);
    }
}
