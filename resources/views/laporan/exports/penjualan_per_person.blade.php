<table>
    <thead>
        <tr>
            <th colspan="6">{{ __('Laporan Penjualan per Person') }}</th>
        </tr>
        <tr>
            <th colspan="6">{{ $type }}, {{ $filter }}</th>
        </tr>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Nama Sales') }}</th>
            <th>{{ __('Store') }}</th>
            <th>{{ __('Kota') }}</th>
            <th>{{ __('Beli') }}</th>
            <th>{{ __('Total (Qty)') }}</th>
            <th>{{ __('Total (Rp.)') }}</th>
            <th>{{ __('%Beli-Qty') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $persentase_beli = 0;
        @endphp
        @foreach ($data as $row)
            @php
                $persentase_beli = $row->total_qty == 0 ? 0 : ($row->total_beli / $row->total_qty) * 100;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->nama_sales_person }}</td>
                <td>{{ $row->nama_store }}</td>
                <td>{{ $row->kota_store }}</td>
                <td>{{ $row->total_beli ?? 0 }}</td>
                <td>{{ $row->total_qty ?? 0 }}</td>
                <td>{{ $row->total_nominal ?? 0 }}</td>
                <td>{{ $persentase_beli ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
