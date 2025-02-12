<table>
    <thead>
        <tr>
            <th colspan="6">{{ __('Laporan Kunjungan (Datang)') }}</th>
        </tr>
        <tr>
            <th colspan="6">{{ activePeriod() }}</th>
        </tr>
        <tr>
            <th>{{ __('By Buy Back') }}</th>
            <th>{{ __('By Invitation') }}</th>
            <th>{{ __('By Social Media Campaign') }}</th>
            <th>{{ __('Others') }}</th>
            <th>{{ __('Reparation') }}</th>
            <th>{{ __('Walk In Customer') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->By_Buy_Back }}</td>
                <td>{{ $row->By_Invitation }}</td>
                <td>{{ $row->By_Social_Media_Campaign }}</td>
                <td>{{ $row->Others ?? 0 }}</td>
                <td>{{ $row->Reparation ?? 0 }}</td>
                <td>{{ $row->Walk_In_Customer ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
