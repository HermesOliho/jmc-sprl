<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RuntimeException;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::findOrCreate('admin', 'web');

        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD');

        if (blank($password)) {
            if (app()->environment('production')) {
                throw new RuntimeException('ADMIN_PASSWORD must be set before seeding in production.');
            }

            $password = 'password';
        }

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrateur',
                'password' => $password,
            ],
        );

        if (! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        if (! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        $this->call(ServiceSeeder::class);
    }
}
