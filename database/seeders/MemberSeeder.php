<?php

namespace Database\Seeders;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $members = [];
        for ($i = 1; $i <= 20; $i++) {
            $members[] = [
                'name' => 'Member '.$i,
                'email' => 'member'.$i.'@gmail.com',
                'phone' => '555-555-'.sprintf("%04d", $i),
                'joining_date' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d')
            ];
        }

        // Insert members into the database
        Member::insert($members);
    }
}
