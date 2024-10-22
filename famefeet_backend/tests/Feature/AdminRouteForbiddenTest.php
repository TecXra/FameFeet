<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class AdminRouteForbiddenTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_landing_route()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public static function get_all_routes(){
        $routes_collection = Route::getRoutes();
        $route_array = [];
        $dynamicReg = "/{\\S*}/";
        foreach($routes_collection as $route){
            if($route->methods[0] == 'GET' && $route->action['middleware'][0]=='web' )
                $route_array[] = $route->uri();
        }
        $route_array_fixed = [];
        for($i=0;$i<count($route_array);$i++){
            $route_array_fixed[$i] =  str_replace('\/', '/', $route_array[$i]);
            $route_array_fixed[$i] =  preg_replace($dynamicReg, '1', $route_array[$i]);
        }
        return $route_array_fixed;
    }

    public function test_all_routes_fans(){
        $user = User::find(1);
        $failed = 0;
        $success = 0;
        $routes_collection = self::get_all_routes();
        for($i=0;$i<count($routes_collection);$i++){
            $response = $this->actingAs($user)->session(['banned'=>false])->get($routes_collection[$i]);
            if($response->status() != 403){
                echo  $routes_collection[$i] . ' (FAILED) did not return a 403.';
                echo $response->status();
                $failed++;
            }else{
                echo  $routes_collection[$i] . ' Success, returns 403.';
                $this->assertTrue(True);
                $success++;
            }
            echo  "Failed: ".$failed." Success: ". $success;
            echo  PHP_EOL;
        }

    }

    public function test_all_routes_admin(){
        $user = User::find(14);
        $failed = 0;
        $success = 0;
        $routes_collection = self::get_all_routes();
        for($i=0;$i<count($routes_collection);$i++){
            $response = $this->actingAs($user)->session(['banned'=>false])->get($routes_collection[$i]);
            if($response->status() != 200){

                echo  $routes_collection[$i] . ' (FAILED) did not return a 200.';
                echo $response->status();
               $failed++;
            }else{
                echo  $routes_collection[$i] . ' Success, returns 200';
                $this->assertTrue(True);
                $success++;
            }
            echo  PHP_EOL;
            echo  PHP_EOL;
            echo  "Failed: ".$failed." Success: ". $success;
            echo  PHP_EOL;
            echo  PHP_EOL;

        }

    }
}
