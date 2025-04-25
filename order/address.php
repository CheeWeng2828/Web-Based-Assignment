<?php
if (is_post()) {
    //for address validation
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

    if (!$_err) {
        $address = "$street_number,$postcode, $city, $state "; //combine 4in1
        if ($u) {
            $stm = $_db->prepare('
        UPDATE user_payment SET address=?,cardholder_name=?,card_no=?, expiry_month=?, expiry_year=?, cvv=? 
        WHERE user_id = ?
    ');
            $stm->execute([$address, $cardholder_name, $card_no, $expiry_month, $expiry_year, $cvv, $_user->id]);

            temp('info', 'Payment method save successfully!');

            if ($id) {
                redirect("paymentInfo.php");
            } else {
                redirect("/");
            }
        }
        if (!$u) {
            $stm = $_db->prepare('
            INSERT INTO user_payment (address,cardholder_name,card_no, expiry_month, expiry_year, cvv,user_id)
            VALUES (?,?,?,?,?,?,?)
        ');
            $stm->execute([$address, $cardholder_name, $card_no, $expiry_month, $expiry_year, $cvv, $_user->id]);

            temp('info', 'Payment save successfully!');

            if ($id) {
                redirect("payment.php");
            } else {
                redirect("/");
            }
        }
    }
}
?>
<div class="address-container">
    <div class="address_details">
        <form method="post">
            <h3>Address Information</h3>

            <label for="street_number">Street Number :</label><br>
            <textarea id="street_number" name="street_number" rows="4" cols="55"></textarea><br><br>
            <?= err("street_number") ?>

            <label for="city">City:</label>
            <?= html_text('city', 'maxlength = "50"') ?><br><br>
            <?= err("city") ?>

            <label for="state">State:</label>
            <?= html_text('state', 'maxlength = "50"') ?><br><br>
            <?= err("state") ?>

            <label for="postcode">Postcode:</label>
            <?= html_text('postcode', 'maxlength="10"') ?><br><br>
            <?= err("postcode") ?>

    </div>
</div>
</form>

<?php
include '../foot.php';
