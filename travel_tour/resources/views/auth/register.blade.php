<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">
<title>Đăng ký</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

body{

height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#43e97b,#38f9d7);

}

.auth-container{

width:420px;
background:white;
padding:40px;
border-radius:10px;
box-shadow:0 10px 30px rgba(0,0,0,0.2);

}

.auth-container h2{

text-align:center;
margin-bottom:25px;
color:#333;

}

.form-group{
margin-bottom:15px;
}

.form-group input{

width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:6px;
font-size:14px;

}

.form-group input:focus{

outline:none;
border-color:#43e97b;

}

button{

width:100%;
padding:12px;
border:none;
background:#43e97b;
color:white;
font-size:16px;
border-radius:6px;
cursor:pointer;
transition:0.3s;

}

button:hover{
background:#2ecc71;
}

.auth-footer{

text-align:center;
margin-top:15px;

}

.auth-footer a{

text-decoration:none;
color:#2ecc71;
font-weight:bold;

}

.auth-footer a:hover{
text-decoration:underline;
}

</style>

</head>
<body>

<div class="auth-container">

<form method="POST" action="/register">

@csrf

<h2>Đăng ký</h2>

<div class="form-group">
<input type="text" name="name" placeholder="Tên" required>
</div>

<div class="form-group">
<input type="email" name="email" placeholder="Email" required>
</div>

<div class="form-group">
<input type="text" name="phone" placeholder="Số điện thoại" required>
</div>

<div class="form-group">
<input type="password" name="password" placeholder="Password" required>
</div>

<button type="submit">Đăng ký</button>

<div class="auth-footer">
<a href="/login">Đã có tài khoản? Đăng nhập</a>
</div>

</form>

</div>

</body>
</html>