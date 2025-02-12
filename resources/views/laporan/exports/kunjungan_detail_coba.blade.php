<table>
    <thead>
        <tr>
            <th colspan="5">{{ __('Laporan Kunjungan (Coba - Goldmart)') }}</th>
            <th colspan="10">{{ __('Laporan Kunjungan (Coba - Goldmaster)') }}</th>
        </tr>
        <tr>
            <th colspan="15">{{ activePeriod() }}</th>
        </tr>
        <tr>
            <th>{{ __('Bracelet') }}</th>
            <th>{{ __('Earring') }}</th>
            <th>{{ __('Necklace') }}</th>
            <th>{{ __('Pendant') }}</th>
            <th>{{ __('Ring') }}</th>

            <th>{{ __('Bangle') }}</th>
            <th>{{ __('Bracelet') }}</th>
            <th>{{ __('Brooch') }}</th>
            <th>{{ __('Charm') }}</th>
            <th>{{ __('Collier') }}</th>
            <th>{{ __('Earring') }}</th>
            <th>{{ __('Necklace') }}</th>
            <th>{{ __('Pendant') }}</th>
            <th>{{ __('Ring') }}</th>
            <th>{{ __('Tietack') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($data1 as $row)
                <td>{{ $row->Bracelet }}</td>
                <td>{{ $row->Earring }}</td>
                <td>{{ $row->Necklace }}</td>
                <td>{{ $row->Pendant ?? 0 }}</td>
                <td>{{ $row->Ring ?? 0 }}</td>
            @endforeach
            @foreach ($data2 as $row)
                <td>{{ $row->Bangle }}</td>
                <td>{{ $row->Bracelet }}</td>
                <td>{{ $row->Brooch }}</td>
                <td>{{ $row->Charm }}</td>
                <td>{{ $row->Collier }}</td>
                <td>{{ $row->Earring }}</td>
                <td>{{ $row->Necklace }}</td>
                <td>{{ $row->Pendant ?? 0 }}</td>
                <td>{{ $row->Ring ?? 0 }}</td>
                <td>{{ $row->Tietack ?? 0 }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
