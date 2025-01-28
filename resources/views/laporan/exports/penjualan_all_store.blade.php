<table>
    <thead>
        <tr>
            <th colspan="3">{{ __('Laporan Penjualan All Store') }}</th>
        </tr>
        <tr>
            <th colspan="3">{{ $type }}, {{ $filter }}</th>
        </tr>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Qty') }}</th>
            <th>{{ __('Nominal (Rp.)') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach ($data as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->total_qty ?? 0 }}</td>
                <td>{{ $row->total_nominal ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
