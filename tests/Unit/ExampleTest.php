<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testHomePage():void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok',
            'msg' => 'nothing to see here',
        ]);
    }
}
