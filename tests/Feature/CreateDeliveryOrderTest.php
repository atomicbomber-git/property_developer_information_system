<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class CreateDeliveryOrderTest extends TestCase
{
    use DatabaseTransactions;

    public function testExample()
    {
        $user = factory(User::class)
            ->states('admin')
            ->create();

        echo route('delivery-order.create');
        $response = $this->actingAs($user)
            ->get(route('delivery-order.create'));

        $response->assertStatus(200);
    }
}