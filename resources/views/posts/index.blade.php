<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #111827;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #4f46e5;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav h1 {
            margin: 0;
            font-size: 24px;
        }
        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            width: 90%;
            margin: 30px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px 20px;
            text-align: left;
        }
        th {
            background-color: #6366f1;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tr:hover {
            background-color: #e0e7ff;
        }
        .actions a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 14px;
        }
        .edit {
            background-color: #10b981;
            color: white;
        }
        .edit:hover {
            background-color: #059669;
        }
        .delete {
            background-color: #ef4444;
            color: white;
        }
        .delete:hover {
            background-color: #b91c1c;
        }

        /* Notification badge */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #22c55e;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: fadein 0.5s, fadeout 0.5s 3s;
            z-index: 1000;
        }
        @keyframes fadein {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeout {
            from {opacity: 1; transform: translateY(0);}
            to {opacity: 0; transform: translateY(-20px);}
        }
    </style>
</head>
<body>
    <nav>
        <h1>My Blog</h1>
        <div>
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href="{{ route('posts.create') }}">Create Post</a>
        </div>
    </nav>

    @if(session('success'))
        <div class="notification">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h2 style="margin-bottom: 20px;">All Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post->author ?? 'N/A' }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td class="actions">
                        <a href="{{ route('posts.edit', $post->_id) }}" class="edit">Edit</a>
                        <form action="{{ route('posts.destroy', $post->_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No posts available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
