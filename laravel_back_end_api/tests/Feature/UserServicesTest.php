<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class UserServicesTest extends TestCase
{
    /**
     *
     * @test
     */
    public function can_signup_a_user()
    {
        $this->withoutExceptionHandling();
        $faker=Factory::create();
        $email=$faker->email;
        $response = $this->json('POST','api/register',[
            'firstname'=>$faker->name,
            'lastname'=>$faker->name,
            'email'=>$email,
            'password'=>'bbbbb',
            'password_confirmation'=>'bbbbb',
            'role_name'=>'employee',
        ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
       
        
      
    }
}
