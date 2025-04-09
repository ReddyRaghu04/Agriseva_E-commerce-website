<!DOCTYPE html>
<html>
<head>
    <title>Seller Registration</title>
    
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
        input, select {
            width: 50%; 
            padding: 8px;
            margin: 5px 0;
            border: 2px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
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
</head>
<body>
    <form action="New_account_php_connection.php" method="POST" enctype="multipart/form-data">
        <div id="Personal" class="form">
            <h3>Personal Details</h3>
            <label class="form-label">Full Name of the Seller</label><br>
            <input type="text" name="full_name"><br>
            <label class="form-label">Date of Birth</label><br>
            <input type="date" name="dob"><br>

            <label class="form-label">State</label><br>
            <select id="state" name="state">
                <option value="">--Select State--</option>
                <option value="telangana">Telangana</option>
                <option value="andhra_pradesh">Andhra Pradesh</option>
                <option value="gujarat">Gujarat</option>
            </select><br>
            
            <label class="form-label">Mobile No</label><br>
            <input type="number" name="mobile"><br>
            <label class="form-label">Email</label><br>
            <input type="email" name="email"><br>
            <br>
            <button onclick="Next()" type="button" class="btn btn-success">Next</button>
        </div>

        <div id="business" style="display: none;" class="form">
            <h3>Business Details</h3><br>
            <label class="form-label">Company/Shop Name</label> <br>
            <input type="text" name="shop_name"> <br>
            <label class="form-label">Address</label> <br>
            <input type="text" name="business_address"> <br>
            <label class="form-label">Mobile No</label> <br>
            <input type="number" name="business_mobile"> <br>
            <label class="form-label">Business Email ID</label> <br>
            <input type="email" name="business_email"> <br>

            <label class="form-label">Categories of Products</label><br>
            <input type="radio" name="category" value="Seeds"> <label>Seeds</label><br>
            <input type="radio" name="category" value="Fertilizers"> <label>Fertilizers</label><br>
            <input type="radio" name="category" value="Pesticides"> <label>Pesticides</label><br>

            <label class="form-label">GST Number</label><br>
            <input type="text" name="gst_number"><br>
            <label class="form-label">PAN Card No</label><br>
            <input type="text" name="pan_number"><br>
            <br>
            <button type="button" class="btn btn-secondary" onclick="Previous_1()">Previous</button>
            <button type="button" onclick="NextBusiness()" class="btn btn-success">Next</button>
        </div>

        <div id="bank" style="display: none;" class="form">
            <h3 style="display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16" style="margin-right: 10px;">
                    <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z"/>
                </svg>
             Bank Details
            </h3>

            <label class="form-label">Bank Account Holder Name</label><br>
            <input type="text" name="bank_holder_name"><br>
            <label class="form-label">Bank Account Number</label><br>
            <input type="number" name="bank_account"><br>
            <label class="form-label">Bank Name</label><br>
            <input type="text" name="bank_name"><br>
            <label class="form-label">IFSC Code</label><br>
            <input type="text" name="ifsc_code"><br>
            <br>
            <button type="button" class="btn btn-secondary" onclick="Previous_2()">Previous</button>
            <button type="button" onclick="NextBank()" class="btn btn-success">Next</button>  
        </div>

        <div id="documents" style="display: none;" class="form">
            <h3>Upload Documents</h3>
            <label class="form-label">GST Registration Certificate</label><br>
            <input type="file" name="gst_certificate"><br>
            <label class="form-label">Trade License</label><br>
            <input type="file" name="trade_license"><br>
            <label class="form-label">Seed Dealer License</label><br>
            <input type="file" name="seed_license"><br>
            <br>
            <button type="button" class="btn btn-secondary" onclick="Previous_3()">Previous</button>
            <button type="button" class="btn btn-success" onclick="submitForm()">Submit</button>  
        </div>
    </form>

    <script>
        function Next() {
            document.getElementById('Personal').style.display = "none";
            document.getElementById('business').style.display = "block";
        }

        function NextBusiness() {
            document.getElementById('business').style.display = "none";
            document.getElementById('bank').style.display = "block";
        }

        function NextBank() {
            document.getElementById('bank').style.display = "none";
            document.getElementById('documents').style.display = "block";
        }
        
        function Previous_1() {
            document.getElementById('business').style.display = "none";
            document.getElementById('Personal').style.display = "block";
        }

        function Previous_2() {
            document.getElementById('bank').style.display = "none";
            document.getElementById('business').style.display = "block";
        }

        function Previous_3() {
            document.getElementById('documents').style.display = "none";
            document.getElementById('bank').style.display = "block";
        }

        function submitForm() {
            let formData = new FormData(document.querySelector("form")); // Automatically collects all input values
            
            fetch("New_account_php_connection.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.status === "success" ? "Registration Successful!" : "Error: " + data.message);
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
</body>
</html>
