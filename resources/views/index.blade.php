<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- Datatable CSS -->
<link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

<style type="text/css">
.dt-buttons{
   width: 100%;
}
</style>

<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>    
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2>Laravel</h2>
                <div class="pull-right mb-2">
                    <form method="post" id="orderDetails" accept="javascript:void(0)" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" aria-describedby="helpId">
                                </div>
                      
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-describedby="helpId">
                                </div>
                                <div class="mb-3">
                                  <label for="" class="form-label">Current Discount</label>
                                  <input type="text" name="current_discount" value="0" id="current_discount" class="form-control" placeholder="Current Discount" aria-describedby="helpId" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" aria-describedby="helpId">
                                </div>
                     
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="abc@mail.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>  
                            </div>
                        </div>

                        <table id="productTable" class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Quantity</th>
                                    <th>Product Type</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button type="button" onclick="addRow()" class="btn btn-primary">Add Product</button><br>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="final_amount" class="form-label">Final Amount:</label>
                                    <input type="text" id="final_amount" name="final_amount" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="mb-3">
                                    <label for="nextdiscount" class="form-label">Next Discount</label>
                                    <input type="text" name="nextdiscount" id="nextdiscount" class="form-control" placeholder="Next Discount" aria-describedby="helpId">
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <table id="employee-table" class="display dataTable table table-bordered stripe hover order-column row-border">
                </table>

    </div>
    <script>
    $(document).ready(function() {
        $('#username, #email').on('change', function() {
            var value = $(this).val();
            console.log(value)
            $.ajax({
                url: '{{url("checkuser")}}', 
                method: 'POST',
                data: { value: value },
                success: function(response) {
                    if (response.exists) {
                        $('#current_discount').val(response.next_discount);
                    } else {
                        $('#current_discount').val(0);
                    }
                }
            });
        });
    });
    
</script>
<script>
    function validateForm() {
    var name = document.getElementById("name").value;
    var username = document.getElementById("username").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var productRows = document.querySelectorAll("#productTable tbody tr");
    var nextDiscount = document.getElementById("nextdiscount").value;
    var finalAmount = document.getElementById("final_amount").value;

    if (name === "") {
        alert("Please enter your name.");
        return false;
    }

    if (username === "") {
        alert("Please enter a username.");
        return false;
    }

    if (phone === "" || isNaN(phone)) {
        alert("Please enter a valid phone number.");
        return false;
    }

    if (email === "" || !validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (password === "" || password.length < 6) {
        alert("Please enter a password with at least 6 characters.");
        return false;
    }

    for (var i = 0; i < productRows.length; i++) {
        var productName = productRows[i].querySelector(".product-name").value;
        var productPrice = productRows[i].querySelector(".product-price").value;
        var productQuantity = productRows[i].querySelector(".product-quantity").value;
        var productType = productRows[i].querySelector(".product-type").value;
        var discount = productRows[i].querySelector(".product-discount").value;

        if (productName === "") {
            alert("Please enter a product name.");
            return false;
        }

        if (isNaN(productPrice) || productPrice === "") {
            alert("Please enter a valid product price.");
            return false;
        }

        if (isNaN(productQuantity) || productQuantity === "") {
            alert("Please enter a valid product quantity.");
            return false;
        }

        if (productType === "") {
            alert("Please select a product type.");
            return false;
        }

        if (discount !== "" && isNaN(discount)) {
            alert("Please enter a valid discount value.");
            return false;
        }
    }

    if (nextDiscount !== "" && isNaN(nextDiscount)) {
        alert("Please enter a valid next discount value.");
        return false;
    }

    if (finalAmount === "" || isNaN(finalAmount)) {
        alert("Please calculate the final amount before submitting.");
        return false;
    }

    return true;
}

function validateEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

</script>
<script>
      $(document).ready(function() {
    $('#employee-table').DataTable({        

        ajax: {
            url: 'getuser',
            type: 'POST',
            dataSrc: '',
            
        },
        dom: 'Blfrtip',
     buttons: [
       {  
          extend: 'copy'
       },
       {
          extend: 'pdf',
       },
       {
          extend: 'csv',
       },
       {
          extend: 'excel',
       },
       {
        extend: 'colvis'
       }
      
     ],        columns: [
            { data: 'name', title: 'Name' },
            { data: 'username', title: 'Username' },
            { data: 'phone', title: 'Phone Number' },
            { data: 'email', title: 'Email' },
            { data: 'password', title: 'Password' },
        ],
    });
});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
    
    </script>
    <script>
        function addRow() {
            const table = document.getElementById('productTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);

            const cell1 = newRow.insertCell(0);
            const cell2 = newRow.insertCell(1);
            const cell3 = newRow.insertCell(2);
            const cell4 = newRow.insertCell(3);
            const cell5 = newRow.insertCell(4);
            const cell6 = newRow.insertCell(5);
            const cell7 = newRow.insertCell(6);

            cell1.innerHTML = '<input type="text" name="product_name[]" class="form-control" required>';
            cell2.innerHTML = '<input type="number" name="product_price[]" class="form-control" step="0.01" required>';
            cell3.innerHTML = '<input type="number" name="product_quantity[]" class="form-control" required>';
            cell4.innerHTML = '<select name="product_type[]" class="form-control"><option selected>Offers</option><option value="flat">Flat</option><option value="discount">Discount</option></select>';
            cell5.innerHTML = '<input type="number" name="discount[]" class="form-control" step="0.01" required>';
            cell6.innerHTML = '<input type="number" name="amount[]" class="form-control" step="0.01" readonly>';
            cell7.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>';

            const productTypeDropdown = newRow.querySelector('[name="product_type[]"]').value;
            const productDiscount = newRow.querySelector('[name="discount[]"]')
            if (productTypeDropdown === 'flat') {
                productTypeDropdown.addEventListener('change', function() {
                    calculateFinalAmount();
                });
            } else {
                productDiscount.addEventListener('change', function() {
                    calculateFinalAmount();
                });
            }
            const productDropDown = newRow.querySelector('[name="product_type[]"]');
            productDropDown.addEventListener('change', function() {
                toggleDiscountInput(this)
            })
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateFinalAmount(); 
        }

        function calculateFinalAmount() {
            const productRows = document.querySelectorAll('#productTable tbody tr');
            const currentDiscount = parseFloat(document.getElementById("current_discount").value);
            console.log(currentDiscount);
            let totalAmount = 0;
            let cumulativeNextDiscount = 0;

            productRows.forEach(row => {
                const price = parseFloat(row.querySelector('[name="product_price[]"]').value) || 0;
                const quantity = parseFloat(row.querySelector('[name="product_quantity[]"]').value) || 0;
                const discount = parseFloat(row.querySelector('[name="discount[]"]').value) || 0;
                const rowAmount = row.querySelector('[name="amount[]"]');
                let rowTotal = price * quantity;
                const productType = row.querySelector('[name="product_type[]"]').value;
                if (productType === 'discount') {
                    var discountAmount = (discount / 100) * rowTotal;
                    rowTotal -= discountAmount;
                }
                rowAmount.value = rowTotal;
                totalAmount += rowTotal;
            });
            if (currentDiscount > 0.00  && currentDiscount < 100.00) {
                const totalDiscount = (currentDiscount / 100) * totalAmount;
                totalAmount -= totalDiscount;
            }
            $('#final_amount').val(totalAmount);
        }


        function toggleDiscountInput(dropdown) {
            const discountInput = dropdown.closest('tr').querySelector('[name="discount[]"]');
            const Amount = dropdown.closest('tr').querySelector('[name="amount[]"]');
            if (dropdown.value === 'flat') {
                discountInput.readOnly = true;
                discountInput.value = '';
                Amount.readOnly = true;
                calculateFinalAmount();
            } else {
                discountInput.readOnly = false;
                Amount.readOnly = true;

            }

        }
    </script>

    <script>
        $(document).ready(function() {
            $('#orderDetails').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{url("store")}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert("Details are Saved Successfully")
                    },
                    error: function(data) {
                        console.log(data)
                    }
                })

            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        })
    </script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>