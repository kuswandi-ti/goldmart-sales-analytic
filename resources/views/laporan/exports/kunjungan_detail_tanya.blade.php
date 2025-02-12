<table>
    <thead>
        <tr>
            <th colspan="6">{{ __('Laporan Kunjungan (Tanya)') }}</th>
        </tr>
        <tr>
            <th colspan="6">{{ activePeriod() }}</th>
        </tr>
        <tr>
            <th>{{ __('Barang') }}</th>
            <th>{{ __('Buy Back') }}</th>
            <th>{{ __('Others') }}</th>
            <th>{{ __('Promo') }}</th>
            <th>{{ __('Range Harga') }}</th>
            <th>{{ __('Reparasi') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->Barang }}</td>
                <td>{{ $row->Buy_Back }}</td>
                <td>{{ $row->Others }}</td>
                <td>{{ $row->Promo ?? 0 }}</td>
                <td>{{ $row->Range_Harga ?? 0 }}</td>
                <td>{{ $row->Reparasi ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
