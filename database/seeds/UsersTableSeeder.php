<?php
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<40; $i++){
            User::create([
                'name'=>'John'.$i,
                'email'=>"john$i@kileo.com",
                'password'=>bcrypt('secret'),
            ]);
         }
    }
}
