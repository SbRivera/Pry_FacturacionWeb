<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('roles')->truncate();
        collect(['Administrador','Secretario','Bodega','Ventas'])
        ->each(fn($r) => Role::firstOrCreate(
            ['name' => $r, 'guard_name' => config('auth.defaults.guard')]
        ));

    }
}
