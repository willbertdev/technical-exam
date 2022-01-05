<?php

namespace Tests\Unit;

use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_success_login() {
        $response = $this->post('/api/order',[
            'product_id' => '1',
            'quantity' => '1'
        ], [
            'Authorization' => 'Bearer Whew9KSzWpBhIp4L5Z7YsUopaK6t3dDLdJv7zRruxzTA7u4mADoyGOcKnKM4'
        ]);

        $response->assertStatus(201);
    }

    public function test_unsuccess_login() {
        $response = $this->post('/api/order',[
            'product_id' => '2',
            'quantity' => '9999'
        ], [
            'Authorization' => 'Bearer Whew9KSzWpBhIp4L5Z7YsUopaK6t3dDLdJv7zRruxzTA7u4mADoyGOcKnKM4'
        ]);

        $response->assertStatus(400);
    }
}
