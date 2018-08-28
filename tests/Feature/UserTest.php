<?php

namespace Tests\Feature;

use Opencycle\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test a user can register.
     *
     * @return void
     */
    public function testUserCanRegister()
    {
        $this->post(route('users.store'), [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => 'test123456',
            'password_confirmation' => 'test123456',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test a user can view their profile.
     *
     * @return void
     */
    public function testUserCanViewProfile()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertSee($user->username);
    }

    /**
     * Test a user can edit their profile.
     *
     * @return void
     */
    public function testUserCanEditProfile()
    {
        $user = factory(User::class)->create();

        $newData = [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
        ];

        $this->actingAs($user)->patch(route('users.update', $user), $newData);

        $this->assertDatabaseHas('users', $newData);
    }
}