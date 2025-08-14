<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use App\Models\User;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        // Criar tenant de teste
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'demo'],
            [
                'id'   => \Illuminate\Support\Str::uuid()->toString(),
                'name' => 'Demo Tenant',
                'domain' => 'demo.local',
            ]
        );

        // Criar usuário admin
        $user = User::firstOrCreate(
            ['email' => 'admin@demo.local'],
            [
                'id'       => \Illuminate\Support\Str::uuid()->toString(),
                'name'     => 'Admin Demo',
                'password' => Hash::make('password'),
            ]
        );

        // Caso use relação many-to-many user <-> tenant
        if (method_exists($user, 'tenants')) {
            $user->tenants()->syncWithoutDetaching([$tenant->id]);
        }

        $this->command->info('Tenant de demo e usuário admin criados com sucesso.');
    }
}
