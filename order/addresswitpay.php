<?php

require '../base.php';

$_title = 'Payment Detail';
include '../head.php';
auth("Member");

$id = req('order_id');

$userInfo = $_db->prepare('SELECT * FROM user_payment WHERE user_id = ?');
$userInfo->execute([$_user->id]);
$u = $userInfo->fetch();

if (is_post()) {
    //for address
    // $street_number = req('street_number');
    // $city = req('city');
    // $state = req('state');
    // $postcode = req('postcode');

    // if ($street_number == '') {
    //     $_err['street_number'] = 'Street number is required';
    // }
    // if ($city == '') {
    //     $_err['city'] = 'City is required';
    // }
    // if ($state == '') {
    //     $_err['state'] = 'State is required';
    // }
    // if ($postcode == '' || !is_numeric($postcode)) {
    //     $_err['postcode'] = 'Valid postcode is required.Must be 5 digits.';
    // }


    //for cardpayment
    $cardholder_name = req('cardholder_name');
    $card_no = req('card_no');
    $expiry_month = req('expiry_month');
    $expiry_year = req('expiry_year');
    $cvv = req('cvv');



    if ($cardholder_name == '') {
        $_err['cardholder_name'] = 'Cardholder name is required.';
    }

    if (strlen($card_no) != 16 || !is_numeric($card_no)) {
        $_err['card_no'] = 'Invalid card number. Must be 16 digits.';
    } elseif (!is_unique($card_no, 'user_payment', 'card_no')) {
        $_err['card_no'] = 'Duplicate Card';
    }
    /*if ($expiry_month < 1 || $expiry_month > 12) {
        $_err['expiry_month'] = 'Invalid expiry month. Please enter a value between 1 and 12.';
    }
    if ($expiry_year < 25 || $expiry_year > 50) {
        $_err['expiry_month'] = 'Invalid expiry year. Please enter a value between 25 and 50.';
    }
    */

    if (empty($cvv) || strlen($cvv) != 3 || !is_numeric($cvv)) {
        $_err['cvv'] = 'Invalid CVV. Must be 3 digits.';
    }


    if (!$_err) {
        //$address = "$street_number,$postcode, $city, $state "; //combine 4in1
        if($u){
        $stm = $_db->prepare('
        UPDATE user_payment SET cardholder_name=?,card_no=?, expiry_month=?, expiry_year=?, cvv=? 
        WHERE user_id = ?
    ');
        $stm->execute([$cardholder_name, $card_no, $expiry_month, $expiry_year, $cvv, $_user->id]);

        temp('info', 'Payment save successfully!');
        
        }else{
            $stm = $_db->prepare('
            INSERT INTO user_payment (cardholder_name,card_no, expiry_month, expiry_year, cvv,user_id)
            VALUES (?, ?, ?, ?,?,?)
        ');
            $stm->execute([$cardholder_name, $card_no, $expiry_month, $expiry_year, $cvv, $_user->id]);
    
            temp('info', 'Payment save successfully!');
        }
        redirect("payment.php?order_id=" . $id);
    }
}
?>

<!-- <div class="address-container">
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
</div> -->



<div class="payment-container">
    <div class="payment-details">
    <form method="post">
        <h3>Payment</h3>

        <!-- <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" id="cardholder_name" name="cardholder_name" maxlength="100" placeholder="Name" 
        value="<?php //echo ($u && isset($u['cardholder_name'])) ? $u['cardholder_name'] : ''; ?>" required><br><br>
        <?php //err('cardholder_name')  ?> 
        -->

        <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" id="cardholder_name" name="cardholder_name" maxlength="100" placeholder="Name" required><br><br>
        <?php err('cardholder_name') ?>


        <label for="card_no">Card Number:</label>
        <input type="text" id="card_no" name="card_no" maxlength="16" placeholder=" 0000 0000 0000 0000" required><br><br>
        <?php err('card_no') ?>

        <label for="expiry_date">Expiry Month/Year:</label><br>
        <div class="expiry-date-container">
            <input type="number" name="expiry_month" id="expiry_month" min="1" max="12" step="1" maxlength="2" required placeholder="MM">
            <span>/</span>
            <input type="number" name="expiry_year" id="expiry_year" min="25" max="50" step="1" maxlength="2" required placeholder="YY">
        </div>


        <label for="cvv">CVV:</label><br>
        <input type="text" name="cvv" id="cvv" maxlength="3" required placeholder="3 digit only">
        <?php err('cvv') ?><br><br>


        <button type="submit">Proceed Payment</button>

    </div>
    </form>

    <?php
    include '../foot.php';
