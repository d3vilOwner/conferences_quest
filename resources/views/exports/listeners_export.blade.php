<table>
    <thead>
    <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Birthdate</th>
        <th>Country</th>
        <th>Phone</th>
        <th>Email</th>
  
    </tr>
    </thead>
    <tbody>
    @foreach($listeners as $listener)
        <tr>
            <td>{{ $listener->user->firstname }}</td>
            <td>{{ $listener->user->lastname }}</td>
            <td>{{ $listener->user->birthdate }}</td>
            <td>{{ $listener->user->country }}</td>
            <td>{{ $listener->user->phone }}</td>
            <td>{{ $listener->user->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>