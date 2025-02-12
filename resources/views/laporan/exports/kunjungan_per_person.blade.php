<table>
    <thead>
        <tr>
            <th colspan="9">{{ __('Laporan Kunjungan per Person') }}</th>
        </tr>
        <tr>
            <th colspan="9">{{ $type }}, {{ $filter }}, {{ $store }}</th>
        </tr>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Nama Sales') }}</th>
            <th>{{ __('Store') }}</th>
            <th>{{ __('Kota') }}</th>
            <th>{{ __('Datang') }}</th>
            <th>{{ __('Tanya') }}</th>
            <th>{{ __('Coba') }}</th>
            <th>{{ __('Beli') }}</th>
            <th>{{ __('%Coba-Beli') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach ($data as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->nama_sales_person }}</td>
                <td>{{ $row->nama_store }}</td>
                <td>{{ $row->kota_store }}</td>
                <td>{{ $row->datang ?? 0 }}</td>
                <td>{{ $row->tanya ?? 0 }}</td>
                <td>{{ $row->coba ?? 0 }}</td>
                <td>{{ $row->beli ?? 0 }}</td>
                <td>{{ $row->persentase ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
