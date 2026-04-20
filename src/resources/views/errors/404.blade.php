<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
            overflow: hidden;
        }
        .container {
            text-align: center;
        }
        h1 {
            font-size: 10rem;
            margin: 0;
        }
        h2 {
            font-size: 2rem;
            margin: 20px 0;
        }
        p {
            font-size: 1rem;
            margin: 20px 0;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #e74c3c;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #c0392b;
        }
        /* .astronaut {
            width: 300px;
            height: 300px;
            background: url('https://i.imgur.com/Jd8E5b2.png') no-repeat center center;
            background-size: contain;
            margin: 0 auto;
        } */
    </style>
</head>
<body>
    <div class="container">
        <div class="astronaut"></div>
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        {{-- <p>We can't seem to find the page you're looking for.</p> --}}
        <p>halaman yang kamu cari gak ada bosss!!</p>
        <a href="/">Go Home</a>
    </div>
</body>
</html>
