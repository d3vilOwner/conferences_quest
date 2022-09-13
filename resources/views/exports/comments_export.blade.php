<table>
    <thead>
    <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Created at</th>
        <th>Content</th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->user->firstname }}</td>
            <td>{{ $comment->user->lastname }}</td>
            <td>{{ $comment->created_at }}</td>
            <td>{{ $comment->content }}</td>
        </tr>
    @endforeach
    </tbody>
</table>