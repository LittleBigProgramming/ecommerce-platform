<?php

namespace Tests\Unit\Models\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    /**
     * @throws \Exception
     */
    public function testPasswordIsHashedOnCreation()
    {
        $user = factory(User::class)->create([
            'password' => $password = bin2hex(random_bytes(8))
        ]);

        $this->assertNotEquals($user->password, $password);
    }
}
