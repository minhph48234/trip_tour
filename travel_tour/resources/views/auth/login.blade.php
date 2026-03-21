<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .auth-container {

            width: 380px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);

        }

        .auth-container h2 {

            text-align: center;
            margin-bottom: 25px;
            color: #333;

        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {

            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;

        }

        .form-group input:focus {
            outline: none;
            border-color: #4facfe;
        }

        button {

            width: 100%;
            padding: 12px;
            border: none;
            background: #4facfe;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;

        }

        button:hover {
            background: #2196f3;
        }

        .auth-footer {

            text-align: center;
            margin-top: 15px;

        }

        .auth-footer a {

            text-decoration: none;
            color: #4facfe;
            font-weight: bold;

        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="auth-container">

        <form method="POST" action="/login">

            @csrf

            <h2>Đăng nhập</h2>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Đăng nhập</button>

            <div class="auth-footer">
                <a href="/register">Chưa có tài khoản? Đăng ký</a>
            </div>

        </form>

    </div>

</body>

</html>