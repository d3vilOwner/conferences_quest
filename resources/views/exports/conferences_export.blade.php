<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Country</th>
        <th>Reports</th>
        <th>Listeners</th>
    </tr>
    </thead>
    <tbody>
    @foreach($conferences as $conference)
        <tr>
            <td>{{ $conference->title }}</td>
            <td>{{ $conference->conferences_date }}</td>
            <td>{{ $conference->latitude }}</td>
            <td>{{ $conference->longitude }}</td>
            <td>{{ $conference->country }}</td>
            <td>{{ count($conference->reports) }}</td>
            <td>{{ count($conference->listeners) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>