<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Roles;
use DB;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Admin::truncate();

        $adminRoles = Roles::where('name','admin')->first();
        $authorRoles = Roles::where('name','author')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_name' => 'Ti Văn',
            'admin_email' => 'tivan@gmail.com',
            'admin_phone' => '13134141',
            'admin_password' => md5('tivan1234'),
        ]);
        $author = Admin::create([
            'admin_name' => 'Ty Vuong',
            'admin_email' => 'tivuong@gmail.com',
            'admin_phone' => '13132141',
            'admin_password' => md5('tivuong1234'),
        ]);
        $user = Admin::create([
            'admin_name' => 'Toản Văn',
            'admin_email' => 'toanvan@gmail.com',
            'admin_phone' => '121312',
            'admin_password' => md5('toan1234'),
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);
    }
}
