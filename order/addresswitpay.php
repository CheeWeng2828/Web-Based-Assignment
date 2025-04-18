<?php

require '../base.php';
include '../head.php';

auth("Member");

if (is_post()) {
    //for addres<string>
    $street_number = req('street_number');
    $city = req('city');
    $state = req('state');
    $postcode = req('postcode');

    if ($street_number == '') {
        $_err['street_number'] = 'Street number is required';
    }
    if ($city == '') {
        $_err['city'] = 'City is required';
    }
    if ($state == '') {
        $_err['state'] = 'State is required';
    }
    if ($postcode == '' || !is_numeric($postcode)) {
        $_err['postcode'] = 'Valid postcode is required.Must be 5 digits.';
    }


    //for cardpayment
    $card_no = req('card_no');
    $expiry_month = req('expiry_month');
    $expiry_year = req('expiry_year');
    $cvv = req('cvv');

    if (strlen($card_no) != 16 || !is_numeric($card_no)) {
        $_err['card_no'] = 'Invalid card number. Must be 16 digits.';
    }
    elseif(!is_unique($card_no,'user_payment','card_no')){
        $_err['card_no'] = 'Duplicate Card';
    }
    if (empty($cvv) || strlen($cvv) != 3 || !is_numeric($cvv)) {
        $_err['cvv'] = 'Invalid CVV. Must be 3 digits.';
    }


    if (!$_err) {
        $address = "$street_number,$postcode, $city, $state "; //combine 4in1
        $stm = $_db->prepare('
        INSERT INTO user_payment (address, card_no, expiry_month, expiry_year, cvv,user_id)
        VALUES (?, ?, ?, ?,?,?)
    ');
        $stm->execute([$address, $card_no, $expiry_month, $expiry_year, $cvv,$_user->id]);

        temp('info','Payment method and address saved successfully!');
        redirect('/');
    }
}
?>

<div class="address-container">
    <div class="address_details">
        <form method="post">
            <h3>Address Information</h3>

            <label for="street_number">Street Number :</label><br>
            <textarea id="street_number" name="street_number" rows="4" cols="55" required></textarea><br><br>

            <label for="city">City:</label>
            <input type="text" name="city" id="city" maxlength="50" required>

            <label for="state">State:</label>
            <input type="text" name="state" id="state" maxlength="50" required><br><br>

            <label for="postcode">Postcode:</label>
            <input type="text" name="postcode" id="postcode" maxlength="10" required><br><br>

    </div>
</div>



<div class="payment-container">
    <div class="payment-details">

        <h3>Payment</h3>
        <label for="card_no">Card Number:</label>
        <input type="text" id="card_no" name="card_no" maxlength="16" required><br><br>
        <?php err('card_no')?>

        <label for="expiry_month">Expiry Month/Year:</label><br>
        <input type="number" name="expiry_month" id="expiry_month" min="1" max="12" step="1" maxlength="2" required placeholder="MM" oninput="validateExpiryMonth(this)">

        <label for="expiry_year"></label>
        <input type="number" name="expiry_year" id="expiry_year" min="25" max="50" step="1" maxlength="2" required placeholder="YY" oninput="validateExpiryYear(this)"><br><br>

        <label for="cvv">CVV:</label><br>
        <input type="text" name="cvv" id="cvv" maxlength="3" required placeholder="CVV">
        <?php err('cvv') ?><br><br>


        <button type="submit">Proceed Payment</button>

    </div>
    </form>

    <?php
    include '../foot.php';
