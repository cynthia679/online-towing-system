<html>
<head></head>
<body>
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$category->name}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
