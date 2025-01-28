<table>
    <thead>
        <tr>
            <th colspan="5">{{ __('Laporan Penjualan per Store') }}</th>
        </tr>
        <tr>
            <th colspan="5">{{ $type }}, {{ $filter }}</th>
        </tr>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Store') }}</th>
            <th>{{ __('Kota') }}</th>
            <th>{{ __('Qty') }}</th>
            <th>{{ __('Nominal (Rp.)') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach ($data as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->nama_store }}</td>
                <td>{{ $row->kota_store }}</td>
                <td>{{ $row->total_qty ?? 0 }}</td>
                <td>{{ $row->total_nominal ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
