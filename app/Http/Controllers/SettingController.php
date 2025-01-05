<?php

namespace App\Http\Controllers;

use App\Models\SettingSystem;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingEmailUpdateRequest;
use App\Http\Requests\SettingFeeUpdateRequest;
use App\Http\Requests\SettingOtherUpdateRequest;
use App\Http\Requests\SettingGeneralUpdateRequest;
use App\Http\Requests\SettingTransactionUpdateRequest;

class SettingController extends Controller
{
    use FileUploadTrait;

    function __construct()
    {
        $this->middleware('permission:setting system', ['only' => ['index', 'generalSettingUpdate', 'feeSettingUpdate']]);
    }

    public function index()
    {
        return view('setting.index');
    }

    public function generalSettingUpdate(SettingGeneralUpdateRequest $request)
    {
        foreach ($request->only('company_name', 'site_title', 'company_phone', 'company_email', 'company_address') as $key => $value) {
            SettingSystem::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_by' => auth()->user()->name],
            );
        }

        if ($request->hasFile('image_company_logo')) {
            $imagePath = $this->handleImageUpload($request, 'image_company_logo', $request->old_image_company_logo, 'company_logo');
            SettingSystem::updateOrCreate(
                ['key' => 'company_logo'],
                ['value' => $imagePath, 'updated_by' => auth()->user()->name],
            );
        }

        if ($request->hasFile('image_company_logo_desktop')) {
            $imagePath = $this->handleImageUpload($request, 'image_company_logo_desktop', $request->old_image_company_logo_desktop, 'company_logo_desktop');
            SettingSystem::updateOrCreate(
                ['key' => 'company_logo_desktop'],
                ['value' => $imagePath, 'updated_by' => auth()->user()->name],
            );
        }

        if ($request->hasFile('image_company_logo_toggle')) {
            $imagePath = $this->handleImageUpload($request, 'image_company_logo_toggle', $request->old_image_company_logo_toggle, 'company_logo_toggle');
            SettingSystem::updateOrCreate(
                ['key' => 'company_logo_toggle'],
                ['value' => $imagePath, 'updated_by' => auth()->user()->name],
            );
        }

        return redirect()->route('setting.index')->with('success', __('Pengaturan informasi umum berhasil diperbarui'));
    }

    public function feeSettingUpdate(SettingFeeUpdateRequest $request)
    {
        foreach ($request->only('fee_loan_regular', 'fee_loan_funding', 'fee_loan_social') as $key => $value) {
            SettingSystem::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_by' => auth()->user()->name],
            );
        }

        return redirect()->route('setting.index')->with('success', __('Pengaturan persentase jasa berhasil diperbarui'));
    }

    public function otherSettingUpdate(SettingOtherUpdateRequest $request)
    {
        foreach ($request->only('decimal_digit_amount', 'decimal_digit_percent', 'tahun_periode_aktif') as $key => $value) {
            SettingSystem::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_by' => auth()->user()->name],
            );
        }

        return redirect()->route('setting.index')->with('success', __('Pengaturan lainnya berhasil diperbarui'));
    }

    public function transactionSettingUpdate(SettingTransactionUpdateRequest $request)
    {
        foreach (
            $request->only(
                'sale_prefix',
                'sale_last_number',
            ) as $key => $value
        ) {
            SettingSystem::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_by' => auth()->user()->name],
            );
        }

        return redirect()->route('setting.index')->with('success', __('Pengaturan transaksi berhasil diperbarui'));
    }

    public function emailSettingUpdate(SettingEmailUpdateRequest $request)
    {
        foreach ($request->only('mail_type', 'mail_host', 'mail_username', 'mail_password', 'mail_encryption', 'mail_port', 'mail_from_address', 'mail_from_name') as $key => $value) {
            SettingSystem::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_by' => auth()->user()->name],
            );
        }

        return redirect()->route('setting.index')->with('success', __('Pengaturan persentase email berhasil diperbarui'));
    }
}
