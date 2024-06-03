<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    /* background: linear-gradient(135deg, #667eea, #764ba2); */
}

.login-container {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.login-form h1 {
    text-align: center;
    margin-bottom: 1rem;
    color: #333;
}

.login-form p {
    text-align: center;
    margin-bottom: 2rem;
    color: #777;
}

.input-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.input-group input {
    width: 100%;
    padding: 10px;
    background: #f1f1f1;
    border: none;
    border-radius: 5px;
    outline: none;
}

.input-group label {
    position: absolute;
    left: 10px;
    top: 10px;
    color: #aaa;
    pointer-events: none;
    transition: all 0.3s ease;
}

.input-group input:focus + label,
.input-group input:valid + label {
    top: -10px;
    left: 5px;
    color: #667eea;
    font-size: 0.75rem;
}

button {
    width: 100%;
    padding: 10px;
    background: #5BAFBC ;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background: #5563c1;
}

.forgot-password {
    text-align: center;
    margin-top: 1rem;
}

.forgot-password a {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.forgot-password a:hover {
    color: #5563c1;
}

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Corporate Profile</h1>
            <p>Please login to your account</p>
            <form method="POST" action="{{ route('login') }}">
                        @csrf
                <div class="input-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit">Login</button>
                <!-- <a href="/"><i>back to landing page</i></a> -->
                <!-- <p class="forgot-password"><a href="#">Forgot Password?</a></p> -->
            </form>
        </div>
    </div>
</body>
</html>
