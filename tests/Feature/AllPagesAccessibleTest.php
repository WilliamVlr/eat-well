<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllPagesAccessibleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_all_get_routes_all_accessible(): void
    {
        // $this->actingAs(\App\Models\User::factory()->create());

        foreach (Route::getRoutes() as $route) {
            if (
                in_array('GET', $route->methods()) &&
                !$this->routeHasParameters($route->uri())
            ) {

                if (str_starts_with($route->uri(), '_ignition')) {
                    continue; // skip route ignition
                }


                $url = '/' . ltrim($route->uri());
                $response = $this->get($url);

                if ($response->status() !== 200) {
                    echo "Gagal akses: $url => Status {$response->status()}\n";
                }


                $response->assertStatus(200, "Route [$url] gagal diakses.");
            }
        }
    }

    private function routeHasParameters($uri)
    {
        return preg_match('/{.*}/', $uri);
    }
}
