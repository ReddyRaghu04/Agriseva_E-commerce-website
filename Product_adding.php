<html>
    <head>
        <title>
            Adding Product
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
        body{
            background-image: url('agriseva_form.jpg');
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 50px;
        }
        h3 {
            text-align: center;
            
        }
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
        .btn-submit {
            width: 100%;
            margin-top: 15px;
        }
        input, select {
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
        <h3>Product Adding Form</h3>

        <div class="form">
            <form action="Product_php_connection.php" method="POST" enctype="multipart/form-data">
                <label>Seller Id</label><br>
                <input type="number" name="seller_id"><br>
                <label>Seller Full Name</label><br>
                <input type="text" name="seller_name"><br>
                <label>Product Name</label><br>
                <input type="text"  name="product_name" ><br>
                <label>Product Category</label><br>
                <select id="category" name="category" onchange="showSubCategory()">
                    <option value="">--Select Category--</option>
                    <option value="seeds">Seeds</option>
                    <option value="insecticides">Insecticides</option>
                </select><br>
                <div id="seedsSubCategory"  style="display: none;">
                    <label>Seed Type</label><br>
                    <select name="subcategory">
                        <option>--Select Type--</option>
                        <option>Paddy Seeds</option>
                        <option>Cotton Seeds</option>
                    </select>
                </div>
                <label>Product description</label><br>
                <input type="text" name="product_description" placeholder="Plaese give detailed description minimum 5 lines"><br>
                <label>Upload image of Product</label><br>
                <input type="file" name="product_image" accept="image/*"><br>
                This image will display to the customer<br>
                <label>Unit of Measurement</label><br>
                <select id="units"  name="unit" onchange="update_quantity()">
                    <option>--Select--</option>
                    <option>Kgs</option>
                    <option>Liters</option>
                    <option>Packets</option>
                </select><br>
                <label>Available Quantity Options</label><br>
                <select id="quantity"  name="quantity">
                    <option>--select--</option>

                </select><br>
                <label>Price per Unit</label><br>
                <input type="number" name="price"><br>
                <button class="btn btn-success">Submit</button>

            </form>
        </div>
    </body>
    <script>
        function update_quantity(){
            var unit=document.getElementById('units').value
            var quantity=document.getElementById('quantity')

            quantity.innerHTML = "<option>--Select--</option>"

            var options = [];
            if (unit === "Kgs") {
                options = ["5 Kg", "10 Kg", "20 Kg", "50 Kg", "100 Kg"];
            } 
            else if (unit === "Liters") {
                options = ["5 L", "10 L", "20 L", "50 L", "100 L"];
            } 
            else if (unit === "Packets") {
                options = ["1 Packet", "5 Packets", "10 Packets", "20 Packets"];
            }
        
        options.forEach(function(value) {
            var option = document.createElement("option");
            option.text = value;
            quantity.appendChild(option);
        });
    }

    </script>
    <script>
function showSubCategory() {
    var category = document.getElementById("category").value;
    var subCategoryDiv = document.getElementById("seedsSubCategory");
    
    if (category === "seeds") {
        subCategoryDiv.style.display = "block";
    } else {
        subCategoryDiv.style.display = "none";
    }
}
</script>
</html>