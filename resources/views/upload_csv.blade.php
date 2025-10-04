<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #333;
            padding-top: 50px;
        }

        .container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 700px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }

        h1 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        input[type="file"] {
            display: block;
            margin: 20px auto;
            padding: 12px 20px;
            border: 2px dashed #6a11cb;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        input[type="file"]:hover {
            border-color: #2575fc;
            background-color: #f0f4ff;
        }

        button {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #e0f8e9;
            color: #2d7a3e;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #2d7a3e;
            font-weight: bold;
        }

        .progress-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            text-align: center;
        }

        .progress-box {
            flex: 1;
            margin: 0 5px;
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .progress-box:hover {
            transform: translateY(-2px);
        }

        .progress-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .progress-box p {
            font-size: 18px;
            font-weight: bold;
            color: #2575fc;
        }

        @media(max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .progress-container {
                flex-direction: column;
            }

            .progress-box {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload CSV File</h1>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit">Upload</button>
        </form>

        @isset($progress)
        <div class="progress-container">
            <div class="progress-box">
                <h3>Queued</h3>
                <p>{{ $progress['queued'] }}</p>
            </div>
            <div class="progress-box">
                <h3>Processing</h3>
                <p>{{ $progress['processing'] }}</p>
            </div>
            <div class="progress-box">
                <h3>Completed</h3>
                <p>{{ $progress['completed'] }}</p>
            </div>
            <div class="progress-box">
                <h3>Failed</h3>
                <p>{{ $progress['failed'] }}</p>
            </div>
        </div>
        @endisset
    </div>
</body>
</html>
