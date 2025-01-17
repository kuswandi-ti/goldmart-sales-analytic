<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SettingSystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

function canAccess(array $permissions)
{
    $permission = auth()->user()->hasAnyPermission($permissions);
    $super_admin = auth()->user()->hasRole('Super Admin');

    if ($permission || $super_admin) {
        return true;
    } else {
        return false;
    }
}

function getLoggedUserRole()
{
    $role = auth()->user()->getRoleNames();
    return $role->first();
}

function checkPermission(string $permission)
{
    return auth()->user()->hasPermissionTo($permission);
}

function getLoggedUser()
{
    return Auth::user();
}

function setSidebarActive(array $routes): ?string
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'active';
        }
    }

    return '';
}

function setSidebarOpen(array $routes): ?string
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'open';
        }
    }

    return '';
}

function truncateString(string $text, int $limit = 45): ?string
{
    return Str::limit($text, $limit, '...');
}

function capitalAllWord(string $text = null): ?string
{
    return $text != null ? Str::of($text)->upper() : '';
}

function capitalFirstLetter(string $text = null): ?string
{
    return $text != null ? Str::of($text)->ucfirst() : '';
}

function getArraySalesPermission()
{
    return [
        ['guard_name' => 'web', 'name' => 'customer visit create', 'group_name' => 'Customer Visit Permission'],
        ['guard_name' => 'web', 'name' => 'customer visit delete', 'group_name' => 'Customer Visit Permission'],
        ['guard_name' => 'web', 'name' => 'customer visit index', 'group_name' => 'Customer Visit Permission'],
        ['guard_name' => 'web', 'name' => 'customer visit restore', 'group_name' => 'Customer Visit Permission'],
        ['guard_name' => 'web', 'name' => 'customer visit update', 'group_name' => 'Customer Visit Permission'],
        ['guard_name' => 'web', 'name' => 'sales person create', 'group_name' => 'Sales Person Permission'],
        ['guard_name' => 'web', 'name' => 'sales person delete', 'group_name' => 'Sales Person Permission'],
        ['guard_name' => 'web', 'name' => 'sales person index', 'group_name' => 'Sales Person Permission'],
        ['guard_name' => 'web', 'name' => 'sales person restore', 'group_name' => 'Sales Person Permission'],
        ['guard_name' => 'web', 'name' => 'sales person update', 'group_name' => 'Sales Person Permission'],
        ['guard_name' => 'web', 'name' => 'store create', 'group_name' => 'Store Permission'],
        ['guard_name' => 'web', 'name' => 'store delete', 'group_name' => 'Store Permission'],
        ['guard_name' => 'web', 'name' => 'store index', 'group_name' => 'Store Permission'],
        ['guard_name' => 'web', 'name' => 'store restore', 'group_name' => 'Store Permission'],
        ['guard_name' => 'web', 'name' => 'store update', 'group_name' => 'Store Permission'],
        ['guard_name' => 'web', 'name' => 'laporan penjualan per person', 'group_name' => 'Report Permission'],
        ['guard_name' => 'web', 'name' => 'laporan penjualan per store', 'group_name' => 'Report Permission'],
        ['guard_name' => 'web', 'name' => 'laporan penjualan all store', 'group_name' => 'Report Permission'],
        ['guard_name' => 'web', 'name' => 'dashboard gsa', 'group_name' => 'Dashboard Permission'],
    ];
}

function setStatusBadge($status)
{
    return $status == 1 ? 'success' : 'danger';
}

function setStatusText($status)
{
    return $status == 1 ? __('Aktif') : __('Tidak Aktif');
}

function setParamBadge($param_text)
{
    switch ($param_text) {
        case "Lihat":
            return 'primary';
            break;
        case "Tanya":
            return 'warning';
            break;
        case "Coba":
            return 'danger';
            break;
        case "Beli":
            return 'success';
            break;
        default:
            echo 'primary';
    }

    return $status == 1 ? 'success' : 'danger';
}

function saveDateTimeNow()
{
    return Carbon::now()->addHour(7)->format('Y-m-d H:i:s');
}

function saveDateNow()
{
    return Carbon::now()->addHour(7)->format('Y-m-d');
}

function saveTimeNow()
{
    return Carbon::now()->addHour(7)->format('H:i:s');
}

function formatDate($date = '')
{
    if (!is_null($date) && isset($date)) {
        $date_create = date_create($date);
        $formatDate = SettingSystem::where('key', 'default_date_format')->first();
        return date_format($date_create, $formatDate->value);
    }
}

function formatMonth($month_number)
{
    $month_name = array(
        1 =>
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    return $month_name[(int) $month_number];
}

function formatAmount($amount, $decimal = 0)
{
    $decimal_digit_amount = SettingSystem::where('key', 'decimal_digit_amount')->first();
    $decimal = $decimal == 0 ? (int)$decimal_digit_amount->value : $decimal;
    return number_format((float)$amount, $decimal, ',', '.');
}

function formatPercent($percent, $decimal = 0)
{
    $decimal_digit_percent = SettingSystem::where('key', 'decimal_digit_percent')->first();
    $decimal = $decimal == 0 ? (int)$decimal_digit_percent->value : $decimal;
    return number_format((float)$percent, $decimal, ',', '.');
}

function unformatAmount($str)
{
    $str = str_replace(".", "", $str);
    return (float) $str;
}

function activePeriod(): ?String
{
    $setting_system = SettingSystem::pluck('value', 'key')->toArray();
    return $setting_system['tahun_periode_aktif_2'];
}

function left($text, $length)
{
    return substr($text, 0, $length);
}

function right($text, $length)
{
    return substr($text, -$length);
}

function docNoStore(): ?String
{
    $setting_system = SettingSystem::pluck('value', 'key')->toArray();
    return $setting_system['kode_dokumen_store'];
}

function docNoSalesPerson(): ?String
{
    $setting_system = SettingSystem::pluck('value', 'key')->toArray();
    return $setting_system['kode_dokumen_sales_person'];
}

function docNoCustomerVisit(): ?String
{
    $setting_system = SettingSystem::pluck('value', 'key')->toArray();
    return $setting_system['kode_dokumen_customer_visit'];
}

function paramCustomerVisit($param): ?String
{
    $params = array("Lihat", "Tanya", "Coba", "Beli");
    return $params[$param];
}

function getSession($param): ?String
{
    $params = array(
        Session::get('sess_id_sales_person'),
        Session::get('sess_kode_sales'),
        Session::get('sess_nama_sales'),
        Session::get('sess_id_store'),
        Session::get('sess_kode_store'),
        Session::get('sess_nama_store'),
        Session::get('sess_kota_store'),
    );
    return $params[$param];
}

/**
 * Create document number
 *
 * @param  string $kode_transaksi = Code of Transaction
 * @param  int $bulan = Month of Transaction
 * @param  int $tahun = Year of Transaction
 * @param  int $nomor_terakhir = Current increment of document number transaction
 * @return string
 */
function last_doc_no($kode_transaksi, $bulan, $tahun)
{
    $count = DB::table('counter')
        ->where([['kode_transaksi', $kode_transaksi], ['bulan', intval($bulan)], ['tahun', $tahun]])
        ->max('nomor_terakhir');
    if ($count == 0) {
        $current_no = 1;
        DB::table('counter')->insert([
            [
                'kode_transaksi' => $kode_transaksi,
                'bulan' => intval($bulan),
                'tahun' => $tahun,
                'nomor_terakhir' => $current_no,
            ]
        ]);
    } else {
        $current_no = $count + 1;
        DB::table('counter')
            ->where([['kode_transaksi', $kode_transaksi], ['bulan', intval($bulan)], ['tahun', $tahun]])
            ->update(
                ['nomor_terakhir' => $current_no]
            );
    }

    return $current_no;

    // Format Doc : XX-MMYY-XXXX
    // return $kode_transaksi . '-' . right('0000' . $bulan, 2) . right($tahun, 2) . '-' . right('0000' . $current_no, 4);
}
