<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
           .form{

            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
            text-align: center;
           }
           body{
            background-image: url('agriseva_form.jpg');
           }
        </style>
    </head>
    <body>
       <div style="text-align: center;">
        <h3>Login</h3>
       </div>
       <div class="form">
        <form>
            <label>Seller ID</label><br>
            <input id="id" type="number"><br>
            <label>Password</label><br>
            <input id="psw" type="password"><br>
            <br>
            <button  class="btn btn-success">Submit</button>
        </form>
       </div>
    </body>
</html>
