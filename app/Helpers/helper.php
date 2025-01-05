<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SettingSystem;

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

function getArrayAllPermission()
{
    return [
        ['guard_name' => 'web', 'name' => 'user approve', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'user create', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'user delete', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'user index', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'user restore', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'user update', 'group_name' => 'User Permission'],
        ['guard_name' => 'web', 'name' => 'role create', 'group_name' => 'Role Permission'],
        ['guard_name' => 'web', 'name' => 'role delete', 'group_name' => 'Role Permission'],
        ['guard_name' => 'web', 'name' => 'role index', 'group_name' => 'Role Permission'],
        ['guard_name' => 'web', 'name' => 'role update', 'group_name' => 'Role Permission'],
        ['guard_name' => 'web', 'name' => 'permission create', 'group_name' => 'Permission Permission'],
        ['guard_name' => 'web', 'name' => 'permission delete', 'group_name' => 'Permission Permission'],
        ['guard_name' => 'web', 'name' => 'permission index', 'group_name' => 'Permission Permission'],
        ['guard_name' => 'web', 'name' => 'permission update', 'group_name' => 'Permission Permission'],
        ['guard_name' => 'web', 'name' => 'kredit nasabah index', 'group_name' => 'Kredit Nasabah Permission'],
        ['guard_name' => 'web', 'name' => 'kredit nasabah update', 'group_name' => 'Kredit Nasabah Permission'],
        ['guard_name' => 'web', 'name' => 'setting system', 'group_name' => 'Setting System Permission'],
        ['guard_name' => 'web', 'name' => 'nasabah index', 'group_name' => 'Nasabah Permission'],
        ['guard_name' => 'web', 'name' => 'nasabah update', 'group_name' => 'Nasabah Permission'],
        ['guard_name' => 'web', 'name' => 'external update', 'group_name' => 'External Permission'],
    ];
}

function setStatusKreditBadge($status)
{
    $status_kredit_badge = '';

    switch ($status) {
        case 'Berjalan':
            $status_kredit_badge = 'danger';
            break;

        case 'Lunas':
            $status_kredit_badge = 'success';
            break;

        default:
            $status_kredit_badge = '';
            break;
    }
    return $status_kredit_badge;
}

function setStatusKirimBarangBadge($status)
{
    $status_kirim_barang_badge = '';

    switch ($status) {
        case 'Belum Dikirim':
            $status_kirim_barang_badge = 'danger';
            break;

        case 'Sudah Dikirim':
            $status_kirim_barang_badge = 'success';
            break;

        default:
            $status_kirim_barang_badge = '';
            break;
    }
    return $status_kirim_barang_badge;
}

function setStatusBadge($status)
{
    return $status == 1 ? 'success' : 'danger';
}

function setStatusText($status)
{
    return $status == 1 ? __('Aktif') : __('Tidak Aktif');
}

function setApproveBadge($status)
{
    $status_badge = '';

    switch ($status) {
        case '0':
            $status_badge = 'danger';
            break;

        case '1':
            $status_badge = 'success';
            break;

        case '2':
            $status_badge = 'dark';
            break;

        default:
            $status_badge = '';
            break;
    }
    return $status_badge;
}

function setApproveText($status)
{
    $status_text = '';

    switch ($status) {
        case '0':
            $status_text = 'Belum Approve';
            break;

        case '1':
            $status_text = 'Sudah Approve';
            break;

        case '2':
            $status_text = 'Ditolak';
            break;

        default:
            $status_text = '';
            break;
    }
    return $status_text;
}

function setVerifyBadge($status)
{
    return $status == 1 ? 'success' : 'danger';
}

function setVerifyText($status)
{
    return $status == 1 ? __('Sudah Verify Email') : __('Belum Verify Email');
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
    return $setting_system['tahun_periode_aktif'];
}
