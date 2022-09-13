<table>
    <thead>
    <tr>
        <th>Topic</th>
        <th>Time</th>
        <th>Description</th>
        <th>Comments</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
        <tr>
            <td>{{ $report->topic }}</td>
            <td>{{ $report->report_start }} - {{ $report->report_end }}</td>
            <td>{{ $report->description }}</td>
            <td>{{ count($report->comments) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>