<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Login</title>
  <link rel="icon" href="Agriseva_icon.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background-image: url('agriseva_form.jpg');
      background-size: cover;
    }

    .form-container {
        position: relative;
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

    /* Toast Styling */
    .toast-message {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 12px;
        visibility: hidden;
        background-color: #28a745;
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 16px;
        opacity: 0;
        z-index: 1000;
        transition: all 0.4s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .toast-message.show {
        visibility: visible;
        opacity: 1;
    }

    .toast-error {
        background-color: #dc3545;
    }
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}




  </style>

  <script>
    function showToast(message, type = 'success') {
      const toast = document.getElementById('toast');
      const toastText = document.getElementById('toast-text');
      const toastIcon = document.getElementById('toast-icon');

      toastText.innerText = message;
      toast.className = `toast-message show ${type === 'error' ? 'toast-error' : ''}`;
      toastIcon.innerText = type === 'error' ? '❌' : '✅';

      setTimeout(() => {
        toast.classList.remove("show");
      }, 2000);
    }

    function handleLogin(event) {
      event.preventDefault();

      let formData = new FormData(document.getElementById("loginForm"));

      fetch("Login_php_connection.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.text())
      .then(text => {
        try {
          let data = JSON.parse(text);
          showToast(data.message, data.status);

          if (data.status === "success") {
            setTimeout(() => window.location.href = data.redirect, 1500);
          }
        } catch (error) {
          console.error("JSON Parse Error:", error, "Raw Response:", text);
        }
      })
      .catch(error => {
        console.error("Fetch Error:", error);
        showToast("Something went wrong!", "error");
      });
    }
  </script>
</head>
<body>
     <!-- 🔔 Toast Notification -->
  <div id="toast" class="toast-message">
    <span id="toast-icon">✔️</span>
    <span id="toast-text"></span>
  </div>
  <div class="form-container">
   
    <h3>Login</h3>
    <div id="errorMessage"></div>
    <form id="loginForm" onsubmit="handleLogin(event)">
      <label>Seller ID</label><br />
      <input id="id" name="id" type="number"   onwheel="this.blur()"   required     oninput="this.value = this.value.replace(/[^0-9]/g, '')"/><br/>
      <label>Password</label><br />
      <input id="psw" name="psw" type="password" required /><br /><br />
      <button type="submit" class="btn btn-success">
        Login
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd"
            d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
          <path fill-rule="evenodd"
            d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
        </svg>
      </button><br /><br />
      <a href="New_account.php">New Seller</a>
    </form>
  </div>

  
</body>
</html>
