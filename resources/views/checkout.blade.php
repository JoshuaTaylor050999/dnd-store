<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Amaranth" rel="stylesheet">

    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body class="bg-auto  bg-cover text-slate-100" style="font-family: 'Amaranth'">
    <section class="bg-top bg-auto  bg-cover animation-wrapper flex flex-col justify-center" style="background-image: url(assets/bg-bottom.png);">    
<form class="form" method="POST" action="{{ route('stripe.checkout') }}">
    @csrf
    <h1 class="text-xl">Personal Details</h1>
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" name="first_name">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="last_name" name="last_name">
    </div>
    <div class="form-group">
        <label for="country">Country/Region:</label>
        <select class="form-control" id="country" name="country">
            <option value="">Please select...</option>
            <option value="US">United States</option>
            <option value="CA">Canada</option>
            <option value="GB">United Kingdom</option>
        </select>
    </div>
    <div class="form-group">
        <label for="street_address">Street Address:</label>
        <input type="text" class="form-control" id="street_address" name="street_address">
    </div>
    <div class="form-group">
        <label for="town_city">Town/City:</label>
        <input type="text" class="form-control" id="town_city" name="town_city">
    </div>
    <div class="form-group">
        <label for="county">County:</label>
        <input type="text" class="form-control" id="county" name="county">
    </div>
    <div class="form-group">
        <label for="postcode">Postcode:</label>
        <input type="text" class="form-control" id="postcode" name="postcode">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" class="form-control" id="phone" name="phone">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <h1 class="text-xl">Card Details</h1>

    <div class="form-group">
        <label for="number">Card Number:</label>
        <input type="text" class="form-control" id="number" name="number">
    </div>
    <div class="form-group">
        <label for="expiry_date">Expiry Date:</label>
        <input type="month" class="form-control" id="expiry_date" name="expiry_date">
    </div>
    <div class="form-group">
        <label for="cvc">CVC:</label>
        <input type="text" class="form-control" id="cvc" name="cvc">
    </div>
        <button type="submit" class="button">Submit</button>
    </form>
    <section>
</body>
</html>
<style>

.form-control{
    display:flex;
    flex-direction: column;
    border-bottom: darkslategray 1px solid;

}
.form{
    padding:2em;
    margin:2em;

    background-color: #f5f5f5;
    color:darkslategrey;


}
input:-webkit-autofill {
    -webkit-text-fill-color: darkslategrey !important;
    font-size: 18px !important;
}

</style>