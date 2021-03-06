<?php
/******************************************************************************
* Description: Handle the users response to the follow up email he/she received
*   from follow_up_email.php.
* Purpose: Get status of prayer request from user and send to back-end admin
* HDM
******************************************************************************/
require_once('../server_info.php');
require_once('../access_database.php');

// pull hash parameter from follow_up_email.php link
$hash = $_GET["hash"];

// Found in ../access_database.php
$name = getUserName($mysqli);
?>

<html>
<head>
    <title>The Rock Church Prayer</title>
    <link rel="manifest" href="site.webmanifest">

    <!-- <link rel="stylesheet" href="css/normalize.css"> -->
    <link rel="stylesheet" type="text/css" href="//rock.church/assets/styles/build/base.css?rel=6d7cc76622">
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>
<body>
    <img class="logo" src="../img/New_rock_logo.jpg" alt="Rock Logo">

    <form id="follow_up_form" action="follow_up_handler.php" method="post">
        <h4 style="text-align: center">
            Hey <?php echo $name?>, have you seen your prayer answered?
        </h4>
        <div class="form-check">
            <div class="row">
                <input class="form-check-input" type="radio" name="prayer-answered"
                    id="prayer-answered-yes" value="yes" required>
                <label for="prayer-answered-yes">Yes, praise God, my prayer was answered.</label>

                <div class="reveal-if-active">
                    <label for="testimony">Testimony: </label>
                    <textarea class="require-if-active" cols="50" rows="4" name="testimony" id="testimony" maxlength="300" data-require-pair="#prayer-answered-yes"></textarea>
                </div> <!-- /.reveal-if-active -->
            </div> <!-- /.row -->
        </div><!-- /.form-check -->
        <br>
        <div class="form-check">
            <div class="row">
                <input class="form-check-input" type="radio" name="prayer-answered"
                    id="prayer-answered-no" value="no">
                <label for="prayer-answered-no">Not yet, I'm still believing.</label>

                <div class="reveal-if-active">
                    <label for="request-update">Prayer Update: </label>
                    <textarea class="require-if-active" cols="50" name="request-update" id="request-update" maxlength="300" data-require-pair="#prayer-answered-no"></textarea>
                </div> <!-- ./reveal-if-active -->
            </div> <!-- /.row -->
        </div> <!-- /.form-check -->

        <p>
            <strong>Want a phone call?
            Let us know:</strong>
        </p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="request-contact" id="request-contact" value="request-contact">
            <label class="form-check-label" for="request-contact">I'd like a phone call.</label>

            <div class="reveal-if-active">
                <div id="contact">
                    <label class="sr-only" for="phone-call">Phone Number: </label>
                    <input class="require-if-active" type="tel" name="phone-num"
                        id="phone-num" placeholder="Phone" data-require-pair="#request-contact">
                    <br>
                </div> <!-- /.contact -->
            </div> <!-- /.reveal-if-active -->
        </div> <!-- /.form-check -->

        <!-- pass original prayer request's hash to the submitted page -->
        <input type="hidden" name="hash-value" value="<?php echo $hash ?>">
        <button type="submit">Send</button>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../js/form.js"></script>
</body>
</html>
