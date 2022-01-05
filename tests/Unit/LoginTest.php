<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_success_login() {
        $response = $this->post('/api/login',[
            'email' => 'backend@multicorp.com',
            'password' => 'test123'
        ]);

        $response->assertStatus(201);
    }

    public function test_unsuccess_login() {
        $response = $this->post('/api/login',[
            'email' => 'backend@multicorp.com',
            'password' => '123test123'
        ]);

        $response->assertStatus(401);
    }
}
