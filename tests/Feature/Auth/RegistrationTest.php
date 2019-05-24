<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{

    public function testRequiresName()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function testRequiresEmail()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function testRequiresValidEmail()
    {
        $this->json('POST', 'api/auth/register', [
            'email' => 'incorrect_email'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function testRequiresUniqueEmail()
    {
        $user = factory(User::class)->create();
        $this->json('POST', 'api/auth/register', [
            'email' => $user->email
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function testRequiresRegistersUser()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'Joe',
            'email' => $email = 'joe@test.com',
            'password' => $password = bin2hex(random_bytes(8))
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name,
        ]);
    }

    public function testReturnsUserResource()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'Joe',
            'email' => $email = 'joe@test.com',
            'password' => $password = bin2hex(random_bytes(8))
        ])
            ->assertJsonFragment([
                'email' => $email
            ]);
    }
}
