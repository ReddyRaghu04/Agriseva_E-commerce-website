<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('agriseva_form.jpg');
        }
        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
            text-align: center;
        }
        input {
            width: 80%;
            padding: 8px;
            margin: 10px 0;
            border: 2px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
    </style>
    <script>
        function handleLogin(event) {
            event.preventDefault();

            let formData = new FormData(document.getElementById("loginForm"));

            fetch("Login_php_connection.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text()) // Read raw response first
            .then(text => {
                try {
                    let data = JSON.parse(text);
                    let msgBox = document.getElementById("errorMessage");
                    msgBox.innerHTML = `<div class="alert ${data.status === 'error' ? 'alert-danger' : 'alert-success'}">${data.message}</div>`;

                    if (data.status === "success") {
                        setTimeout(() => window.location.href = data.redirect, 1500);
                    }
                } catch (error) {
                    console.error("JSON Parse Error:", error, "Raw Response:", text);
                }
            })
            .catch(error => console.error("Fetch Error:", error));
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h3>Login</h3>
        <div id="errorMessage"></div>
        <form id="loginForm" onsubmit="handleLogin(event)">
            <label>Seller ID</label><br>
            <input id="id" name="id" type="number" required><br>
            <label>Password</label><br>
            <input id="psw" name="psw" type="password" required><br><br>
            <button type="submit" class="btn btn-success">
                Login
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
            </button><br><br>
            <a href="New_account.php">New Seller</a>
        </form>
    </div>
</body>
</html>
