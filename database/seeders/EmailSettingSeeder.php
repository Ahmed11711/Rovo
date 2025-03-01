<?php

namespace Database\Seeders;

use App\Models\EmailSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailSetting::create([
            'mail_from_name' => config('app.name'),
            'mail_from_email' => 'from@email.com',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '465',
            'mail_driver' => 'smtp',
            'smtp_encryption' => 'ssl',
            'mail_username' => 'myemail@gmail.com',
            'enable_queue' => 'no',
        ]);
    }

}
