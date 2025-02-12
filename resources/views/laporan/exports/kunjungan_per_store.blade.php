<table>
    <thead>
        <tr>
            <th colspan="8">{{ __('Laporan Kunjungan per Store') }}</th>
        </tr>
        <tr>
            <th colspan="8">{{ $type }}, {{ $filter }}, {{ $kota }}</th>
        </tr>
        <tr>
            <th>{{ __('No') }}</th>
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
