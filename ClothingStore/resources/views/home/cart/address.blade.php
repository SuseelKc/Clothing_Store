@include('home.header')
<style>
    /* Add this CSS to your stylesheet */

/* Container styles */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Form styles */
.order-form {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
}

.order-form h2 {
    font-size: 24px;
    margin-top: 0;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

/* Label styles */
.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #555;
}

/* Input and select styles */
input[type="text"],
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    color: #333;
}

/* Button styles */
button[type="submit"] {
    background: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 18px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background: #0056b3;
}

/* Responsive styles */
@media (max-width: 600px) {
    .container {
        padding: 10px;
    }

    .order-form {
        padding: 10px;
    }

    input[type="text"],
    select {
        font-size: 14px;
    }

    button[type="submit"] {
        font-size: 16px;
        padding: 8px 16px;
    }
}

</style>
<div class="container">
    
    <div class="order-form">
    <!-- store_address = before route for cash in delivery -->
        <form action="{{ route('payment') }}" method="POST" id="paymentForm">  
            @csrf

            <h2 style="padding-bottom:20px;">Delivery Address</h2>

            <div class="form-group">
                <label for="address_name">Address In:</label>
                <select id="address_name" name="address_name">
                    <option value="home" selected>Home</option>
                    <option value="office">Office</option>
                    <!-- Add other payment options here if needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="state">State/Province:</label>
                <input type="text" id="state" name="state" required>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>
            </div>

            <h2 style="padding-bottom:20px;">Contact Information</h2>

            <div class="form-group">
                <label for="contact_name">Contact Name:</label>
                <input type="text" id="contact_name" name="contact_name" required>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" required>
            </div>

            <div class="form-group">
                <label for="payment_type">Payment Type:</label>
                <select id="payment_type" name="payment_type">
                    <option value="1">Cash on Delivery</option>
                    <option value="2" selected>Paypal</option>
                    <option value="3">Khalti</option>
                </select>
            </div>

            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

            <div class="form-group">
                <button type="button" id="placeOrderButton" style="background-color: green; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-size: 18px; cursor: pointer;">Place Order</button>
            </div>

        </form>
    </div>
</div>
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script>
    // Function to show Khalti checkout popup
    function showKhaltiPopup() {
        var config = {
            "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT"
            ],
            "eventHandler": {
                onSuccess(payload) {
                    console.log(payload);
                },
                onError(error) {
                    console.log(error);
                },
                onClose() {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        checkout.show({ amount: 20000 }); // Adjust amount as needed
        setTimeout(() => {
            config.eventHandler.onClose();
        }, 2000);
    }

    // Add event listener to the "Place Order" button
    document.getElementById("placeOrderButton").addEventListener("click", function() {
        var selectedPaymentType = document.getElementById("payment_type").value;
        if (selectedPaymentType === "3") {
            // If Khalti is selected, show the Khalti checkout popup
            showKhaltiPopup();
        } else {
            // Otherwise, submit the form
            document.getElementById("paymentForm").submit();
        }
    });
</script>
<script>
    // Listen for the change event on the "Payment Type" select element
    const paymentTypeSelect = document.getElementById('payment_type');
    paymentTypeSelect.addEventListener('change', function() {
        // Get the selected payment type
        const selectedPaymentType = paymentTypeSelect.value;

        // Get the form element
        const paymentForm = document.getElementById('paymentForm');

        // Set the form's action attribute based on the selected payment type
        if (selectedPaymentType === '1') {
            // Cash on Delivery selected, set the form action to the 'store_address' route
            paymentForm.action = "{{ route('store_address') }}";
        } else if (selectedPaymentType === '2') {
            // Paypal selected, set the form action to the 'payment' route
            paymentForm.action = "{{ route('payment') }}";
        }
    });
</script>

@include('home.footer')