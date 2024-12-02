<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Division;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $kominfo = Division::create(['name' => 'Kominfo']);
        $pengurus = Division::create(['name' => 'Pengurus']);
        $kerohanian = Division::create(['name' => 'Kerohanian']);
        $pengunjung = Division::create(['name' => 'Pengunjung']);

        $user1 = User::factory()->create([
            'name' => 'Developer',
            'email' => 'ilhamputra0601@gmail.com',
            'division_id' => $kominfo->id,
        ]);

        $user2 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'division_id' => $kerohanian->id,
        ]);

        $user3 = User::factory()->create([
            'name' => 'pengurus',
            'email' => 'pengurus@gmail.com',
            'division_id' => $pengurus->id,
        ]);

        $user4 = User::factory()->create([
            'name' => 'anggota',
            'email' => 'anggota@gmail.com',
            'division_id' => $kerohanian->id,
        ]);

        $user5 = User::factory()->create([
            'name' => 'pengunjung',
            'email' => 'pengunjung@gmail.com',
            'division_id' => $pengunjung->id,
        ]);

        $role1 = Role::create(['name' => 'Developer']);
        $user1->assignRole($role1);
        $role2 = Role::create(['name' => 'Admin']);
        $user2->assignRole($role2);
        $role3 = Role::create(['name' => 'Pengurus']);
        $user3->assignRole($role3);
        $role4 = Role::create(['name' => 'Anggota']);
        $user4->assignRole($role4);
        $role5 = Role::create(['name' => 'Pengunjung']);
        $user5->assignRole($role5);



        Permission::create(['name' => 'Akses Role']);
        Permission::create(['name' => 'Akses Reel']);
        Permission::create(['name' => 'Akses Divisi']);
        Permission::create(['name' => 'Akses Pengguna']);
    }
}
