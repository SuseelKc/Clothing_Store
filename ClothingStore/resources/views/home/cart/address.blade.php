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
        <form action="{{ route('store_address') }}" method="POST">
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
                    <option value="1" selected>Cash on Delivery</option>
                    <option value="2">Paypal</option>
                    <!-- Add other payment options here if needed -->
                </select>
            </div>

            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

            <div class="form-group">
                <button type="submit">Place Order</button>
            </div>

        </form>
    </div>
</div>

@include('home.footer')