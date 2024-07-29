<?php

namespace Database\Factories;

use App\Enums\UserRoles;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function root(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => 'root@localhost.com',
            'password' => Hash::make('root1234'),
            'email_verified_at' => now(),
        ])->afterCreating(function (User $user) {
            $user->assignRole(UserRoles::Root->value);
            UserProfile::create([
                'user_id' => $user->id,
                'name' => 'Root',
                'surname' => 'Root',
            ]);
        });
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => 'admin@localhost.com',
            'password' => Hash::make('admin1234'),
            'email_verified_at' => now(),
        ])->afterCreating(function (User $user) {
            $user->assignRole(UserRoles::Admin->value);
            UserProfile::create([
                'user_id' => $user->id,
                'name' => 'Admin',
                'surname' => 'Admin',
            ]);
        });
    }

    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => 'user@localhost.com',
            'password' => Hash::make('user1234'),
            'email_verified_at' => now(),
        ])->afterCreating(function (User $user) {
            $user->assignRole(UserRoles::User->value);
            UserProfile::create([
                'user_id' => $user->id,
                'name' => 'User',
                'surname' => 'User',
            ]);
        });
    }
}
