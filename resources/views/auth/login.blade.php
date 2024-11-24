<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Gradient */
        body {
            background: linear-gradient(135deg, #446496, #88A5DB);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Logo */
        .logo-wrapper {
            margin-bottom: 20px;
        }

        .logo-wrapper img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Input Fields */
        .form-control {
            border-radius: 30px;
            padding-left: 40px;
            box-shadow: none;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #446496;
            box-shadow: 0 0 5px rgba(68, 100, 150, 0.5);
        }

        .input-group-text {
            border-radius: 30px 0 0 30px;
            background: transparent;
            border-right: none;
            color: #446496;
        }

        /* Button */
        .btn-primary {
            background-color: #446496;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #335a80;
            transform: scale(1.05);
        }

        /* Toggle Text */
        .toggle-text {
            font-size: 0.9rem;
            color: #335a80;
            cursor: pointer;
        }

        .toggle-text:hover {
            text-decoration: underline;
        }


        .btn-home:hover {
            background-color: #446496;
            transform: scale(1.05);
        }

        /* Show/Hide Password Icon */
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>

<div class="text-center">
    <!-- Logo -->
    <div class="logo-wrapper">
        <img src="{{ asset('images/7309682.png') }}" alt="Logo">
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <h2 class="mb-4" id="form-title">Login to Your Account</h2>
        <form id="authForm" method="POST" action="{{ route('login.store') }}">
            @csrf

            <!-- Name Input (Hidden by Default) -->
            <div id="name-field" class="input-group mb-3 d-none">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
            </div>

            <!-- Email Input -->
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <!-- Password Input -->
            <div class="input-group mb-3 position-relative">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                <i class="fas fa-eye toggle-password" id="toggle-password"></i>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 mb-3" id="auth-button">Login</button>
        </form>

        <!-- Toggle Login/Register -->
        <p class="toggle-text" id="toggle-form">Don't have an account? Register here</p>

    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleForm = document.getElementById('toggle-form');
        const formTitle = document.getElementById('form-title');
        const authForm = document.getElementById('authForm');
        const nameField = document.getElementById('name-field');
        const authButton = document.getElementById('auth-button');
        const loginCard = document.querySelector('.login-card');
        const togglePassword = document.getElementById('toggle-password');
        const passwordField = document.getElementById('password');

        let isLoginMode = true;

        toggleForm.addEventListener('click', () => {
            isLoginMode = !isLoginMode;

            // Animate the form switch (fade-out, fade-in)
            loginCard.classList.add('hidden');
            setTimeout(() => {
                // Update UI for Login/Register Mode
                formTitle.textContent = isLoginMode ? 'Login to Your Account' : 'Create Your Account';
                toggleForm.textContent = isLoginMode ? "Don't have an account? Register here" : "Already have an account? Login here";
                nameField.classList.toggle('d-none', isLoginMode);
                authButton.textContent = isLoginMode ? 'Login' : 'Register';
                authForm.action = isLoginMode ? "{{ route('login.store') }}" : "{{ route('register.store') }}";

                // Show form again with animation
                loginCard.classList.remove('hidden');
            }, 500); // Timing to match with fade out duration
        });

        // Show/Hide password toggle
        togglePassword.addEventListener('click', () => {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            togglePassword.classList.toggle('fa-eye-slash');
        });
    });
</script>

</body>
</html>
