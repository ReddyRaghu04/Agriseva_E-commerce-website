<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .form {
                background: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                margin: auto;
                margin-top: 50px;
                text-align: center;
            }
            body {
                background-image: url('agriseva_form.jpg');
            }
            input {
                width: 50%; 
                padding: 8px;
                margin: 5px 0;
                border: 2px solid #ccc;
                border-radius: 6px;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>
       <div style="text-align: center;">
            <h3>Login</h3>
       </div>
       <div class="form">
            <form action="Login_php_connection.php" method="POST">
                <label>Seller ID</label><br>
                <input id="id" name="id" type="number" required><br>
                <label>Password</label><br>
                <input id="psw" name="psw" type="password" required><br><br>

                <button type="submit" class="btn btn-success">Login</button><br>
                <br>
                <a href="New_account.php" >New Seller</a>
            </form>
       </div>
    </body>
</html>
