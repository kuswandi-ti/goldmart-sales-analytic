<?php

namespace Database\Seeders;

use App\Models\SettingSystem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['key' => 'company_name', 'value' => 'PT. Gold Martindo', 'created_by' => $user],
            ['key' => 'site_title', 'value' => 'Goldmart System Analytic (GSA)', 'created_by' => $user],
            ['key' => 'company_email', 'value' => 'admin@goldmart.com', 'created_by' => $user],
            ['key' => 'company_phone', 'value' => '62-21-6508688', 'created_by' => $user],
            ['key' => 'company_address', 'value' => 'Jl Mitra Sunter Boulevard, Sunter, Jakarta Utara', 'created_by' => $user],
            ['key' => 'default_date_format', 'value' => 'd-m-Y', 'created_by' => $user],
            ['key' => 'default_time_format', 'value' => 'H:i:s', 'created_by' => $user],
            ['key' => 'default_language', 'value' => 'id', 'created_by' => $user],
            ['key' => 'decimal_digit_amount', 'value' => '0', 'created_by' => $user],
            ['key' => 'decimal_digit_percent', 'value' => '2', 'created_by' => $user],
            ['key' => 'mail_type', 'value' => config('common.mail_mailer'), 'created_by' => $user],
            ['key' => 'mail_host', 'value' => config('common.mail_host'), 'created_by' => $user],
            ['key' => 'mail_username', 'value' => config('common.mail_username'), 'created_by' => $user],
            ['key' => 'mail_password', 'value' => config('common.mail_password'), 'created_by' => $user],
            ['key' => 'mail_encryption', 'value' => config('common.mail_encryption'), 'created_by' => $user],
            ['key' => 'mail_port', 'value' => config('common.mail_port'), 'created_by' => $user],
            ['key' => 'mail_from_address', 'value' => config('common.mail_from_address'), 'created_by' => $user],
            ['key' => 'mail_from_name', 'value' => config('common.mail_from_name'), 'created_by' => $user],
            ['key' => 'tahun_periode_aktif', 'value' => date('Y'), 'created_by' => $user],
            ['key' => 'kode_dokumen_customer_visit', 'value' => 'CVI', 'created_by' => $user],
            ['key' => 'kode_dokumen_store', 'value' => 'STR', 'created_by' => $user],
            ['key' => 'kode_dokumen_sales_person', 'value' => 'SLS', 'created_by' => $user],
        ];
        foreach ($input as $item) {
            SettingSystem::create($item);
        }
    }
}
