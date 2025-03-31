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
            <button type="submit" class="btn btn-success">Login</button><br><br>
            <a href="New_account.php">New Seller</a>
        </form>
    </div>
</body>
</html>
