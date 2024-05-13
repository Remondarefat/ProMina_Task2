<?php
namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set the password for the admin user
        $password = 'Admin@1234'; // Change this to the desired password
        
        // Create an admin record
        DB::table('admins')->insert([
            'name' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

