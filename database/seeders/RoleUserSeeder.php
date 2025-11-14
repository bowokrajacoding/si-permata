<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder {

    public function run(): void
    {
        $admin = Role::firstOrCreate(['name'=>'admin']);
        $pimpinan = Role::firstOrCreate(['name'=>'pimpinan']);

        // ADMIN 1
        $lia = User::updateOrCreate(
            ['email'=>'lia@example.test'],
            ['name'=>'Lia Oktarina','password'=>bcrypt('password123')]
        );
        $lia->assignRole('admin');

        // ADMIN 2
        $sri = User::updateOrCreate(
            ['email'=>'sri@example.test'],
            ['name'=>'Sri Hartini','password'=>bcrypt('password123')]
        );
        $sri->assignRole('admin');

        // PIMPINAN
        $muherli = User::updateOrCreate(
            ['email'=>'muherli@example.test'],
            ['name'=>'Muherli','password'=>bcrypt('password123')]
        );
        $muherli->assignRole('pimpinan');
    }
}
