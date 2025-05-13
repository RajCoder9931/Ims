<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #222;
            color: #ddd;
        }

        .container {
            display: flex;
            background: white;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            width: 900px;
            max-width: 95%;
        }

        body.dark-mode .container {
            background: #333;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
        }

        /* Left Side Illustration */
        .left-side {
            width: 50%;
            background-color: #f4f4f4;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body.dark-mode .left-side {
            background-color: #444;
        }

        .left-side img {
            max-width: 80%;
            height: auto;
        }

        /* Toggle Button */
        .toggle-mode {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

        body.dark-mode .toggle-mode {
            background-color: #ffbb00;
            color: #333;
        }

        /* Right Side Form */
        .right-side {
            width: 50%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        body.dark-mode .right-side h1 {
            color: #fff;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tabs button {
            border: none;
            background-color: transparent;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            padding: 10px 15px;
            transition: color 0.3s ease;
            color: #777;
        }

        .tabs button.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }

        body.dark-mode .tabs button {
            color: #bbb;
        }

        body.dark-mode .tabs button.active {
            color: #ffbb00;
            border-bottom-color: #ffbb00;
        }

        form {
            display: none;
        }

        form.active {
            display: block;
        }

        form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: white;
            color: #333;
        }

        body.dark-mode form input {
            background-color: #555;
            color: #fff;
            border: 1px solid #777;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        body.dark-mode form button {
            background-color: #ffbb00;
            color: #333;
        }

        /* Social Media Links */
        .social-login {
            margin-top: 20px;
            text-align: center;
        }

        .social-login span {
            display: block;
            margin-bottom: 10px;
            color: #777;
        }

        body.dark-mode .social-login span {
            color: #bbb;
        }

        .social-login a {
            text-decoration: none;
            display: inline-block;
            margin: 0 5px;
            font-size: 18px;
            color: #333;
            transition: color 0.3s ease;
        }

        body.dark-mode .social-login a {
            color: #ffbb00;
        }

        .social-login a:hover {
            color: #007bff;
        }

        body.dark-mode .social-login a:hover {
            color: #fff;
        }
        form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: white;
            color: #333;
            cursor: pointer; /* Change cursor to pointer for better UX */
        }
        
        body.dark-mode form select {
            background-color: #555;
            color: #fff;
            border: 1px solid #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side Illustration -->
        <div class="left-side">
            <button class="toggle-mode" id="toggleMode">Dark Mode</button>
            <img src="logo.png" alt="Illustration">
        </div>

        <!-- Right Side Forms -->
        <div class="right-side">
            <h1>Sign up & Login</h1>
            <div class="tabs">
                <button id="loginTab" class="active">Login</button>
                <button id="signupTab">Signup</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="active" method="POST" action="auth.php">
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <!-- Signup Form -->
            <form id="signupForm" method="POST" action="auth.php">
                <input type="hidden" name="action" value="signup">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="user_type" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                </select>
                <button type="submit">Signup</button>
            </form>

            <!-- Social Login -->
            <div class="social-login">
                <span>Or login with</span>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-google"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById("loginTab");
        const signupTab = document.getElementById("signupTab");
        const loginForm = document.getElementById("loginForm");
        const signupForm = document.getElementById("signupForm");
        const toggleMode = document.getElementById("toggleMode");
        const body = document.body;

        // Tab switching logic
        loginTab.addEventListener("click", () => {
            loginTab.classList.add("active");
            signupTab.classList.remove("active");
            loginForm.classList.add("active");
            signupForm.classList.remove("active");
        });

        signupTab.addEventListener("click", () => {
            signupTab.classList.add("active");
            loginTab.classList.remove("active");
            signupForm.classList.add("active");
            loginForm.classList.remove("active");
        });

        // Dark Mode Toggle
        toggleMode.addEventListener("click", () => {
            body.classList.toggle("dark-mode");
            toggleMode.textContent = body.classList.contains("dark-mode") ? "Light Mode" : "Dark Mode";
        });
    </script>
    <script src="https://kit.fontawesome.com/90e6c044e5.js" crossorigin="anonymous"></script>
</body>
</html>
