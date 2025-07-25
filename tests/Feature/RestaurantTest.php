<?php
use Tests\TestCase;

class RestaurantControllerTest extends TestCase{

    public function test_index_RestaurantController_getRestaurants_ReturnStatus200(): void
    {
        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/restaurants");
    
        $response->assertStatus(200);
    }

    public function test_index_RestaurantController_getRestaurants_ReturnStatus404(): void
    {
        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/restaurantss");
    
        $response->assertStatus(404);
    }
}
