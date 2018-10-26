<?php

/*
 * upload.php
 * created by Avery Wald on 5/31/18
 * 
 * when running 'http://www.sun-aviation.com/htmlFiles/contact.html',
 * form data is uploaded to phpMyAdmin from the website order form
 * 
 * database: 'sunaviation'
 * table: 'Orders'
 * 
 * the form data is also sent to Sun's sales dept. via email (line 126)
 * 
 * ANYTHING NOT DEFINED IN 'upload.php' IS IN 'uploadConfig.php'
*/

// redirect to avoid 404 error
?>
<head>
    <meta http-equiv="refresh" content="0; URL='http://www.sun-aviation.com/htmlFiles/contact.html'"/>
</head>
<?php

// grab sensitive data
require 'uploadConfig.php';

// set current time to central timezone
date_default_timezone_set("America/Chicago");

// if upload button pressed
if (isset($_POST['upload'])) {

    // time stamp for new `Orders` record
    $timeStamp = date("Y/m/d h:i:s a");
    
    try {
        // connect to database
        $pdo = new PDO($dsn, $user, $password);

        // set error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // initialize form field variables
        $customerName = $company = $address = $email = $phone = $refNum = $partNum = $quantity = $comments = null;
        // initialize form field ERROR variables
        $nameError = $companyError = $addressError = $emailError = $phoneError = $refNumError = $partNumError = $quantityError = null;

        // cleans the raw user input for submission
        function testInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES);
            return $data;
        }
        
        // get all submitted data from form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // check if the form fields are empty
            if (empty($_POST["customerName"])) {
                $nameError = "Name is required";
            } else {
                $customerName = testInput($_POST["customerName"]);
                // validate name format
                if (!preg_match("/^[a-zA-Z ]*$/", $customerName)) {
                    $nameError = "Only letters and spaces allowed"; 
                }
            }

            if (empty($_POST["company"])) {
                $companyError = "Company name is required";
            } else {
                $company = testInput($_POST["company"]);
            }

            if (empty($_POST["address"])) {
                $addressError = "Address is required";
            } else {
                $address = testInput($_POST["address"]);
            }

            if (empty($_POST["email"])) {
                $emailError = "Email address is required";
            } else {
                $email = testInput($_POST["email"]);
                // validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Invalid email format"; 
                }
            }

            if (empty($_POST["phone"])) {
                $phoneError = "Phone number is reqiured";
            } else {
                $phone = testInput($_POST["phone"]);
            }

            if (empty($_POST["refNum"])) {
                $refNumError = "Reference number is required";
            } else {
                $refNum = testInput($_POST["refNum"]);
            }

            if (empty($_POST["partNum"])) {
                $partNumError = "Part number is required";
            } else {
                $partNum = testInput( $_POST["partNum"]);
            }

            if (empty($_POST["quantity"])) {
                $quantityError = "Quantity is required";
            } else {
                $quantity = testInput($_POST["quantity"]);
            }

            $comments = testInput($_POST["comments"]);
        }

        // prepared insert statement
        $sql = "INSERT INTO `Orders` (timeStamp, customerName, company, address, email, phoneNum, refNum, partNum, quantity, comments)
            VALUES ('$timeStamp', '$customerName', '$company', '$address', '$email', '$phone', '$refNum', '$partNum', '$quantity', '$comments')";

        // run db query
        $stmt = $pdo->exec($sql);

        if ($stmt === false) {
            // submission error
            echo "<script type='text/javascript'>alert('Order Submission Error');</script>";
        } else {
            // successful submission into the database table: orders
            echo "<script type='text/javascript'>alert('Order Submitted');</script>";
        }
        
        // phpMailer ----------------------------------------------------------

        // send email notifications
        require '../phpMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        $mail->SMTPDebug = 0;               // Enable verbose debug output

        $mail->isSMTP();                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;             // Enable SMTP authentication
        $mail->Username = $userName;        // SMTP username
        $mail->Password = $passWord;        // SMTP password
        $mail->SMTPSecure = $smtpSecure;    // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $tcpPort;             // TCP port to connect to

        $mail->setFrom($userName, 'admin');
        $mail->addAddress($emails[0]);
        $mail->addAddress($emails[1]);
        $mail->addAddress($emails[2]);
        $mail->addAddress($emails[3]);
        $mail->addAddress($emails[4]);

        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        $mail->isHTML(true);                                     // Set email format to HTML

        $mail->Subject = 'New Order Submitted';

        // html for order info table - 
        // /htmlFiles/extras/orderEmailTable.html/
        // to view
        $mail->Body = 
        "
        <!doctype html>
        <html>
            <style type='text/css'>
            .tg {
                border-collapse: collapse;
                border-spacing: 0;
                table-layout: fixed;
                width: 479px;
            }
            .tg td {
                font-family: Arial, sans-serif;
                font-size :14px;
                padding: 10px 5px;
                border-style: solid;
                border-width: 1px;
                overflow: hidden;
                word-break :normal;
                border-color: black;
            }
            .tg th {
                font-family: Arial, sans-serif;
                font-size :14px;
                font-weight: normal;
                padding: 10px 5px;
                border-style: solid;
                border-width: 1px;
                overflow: hidden;
                word-break: normal;
                border-color: black;
            }
            .tg .tg-baqh {
                text-align: center;
                vertical-align: top;
            }
            .tg .tg-amwm {
                font-weight: bold;
                text-align: center;
                vertical-align: top;
            }
            .tg .tg-yw4l {
                vertical-align: top;
            }
            </style>
            <body>
                <table class='tg'>
                    <colgroup>
                        <col style='width: 164px'>
                        <col style='width: 315px'>
                    </colgroup>
                    <tr>
                        <th class='tg-baqh' colspan='2'><span style='font-weight:bold'>New Order Submission</span></th>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Time Submitted:</td>
                        <td class='tg-yw4l'>" . date("Y/m/d h:i:s a") . "</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Name:</td>
                        <td class='tg-yw4l'>". $customerName ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Company:</td>
                        <td class='tg-yw4l'>". $company ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Address:</td>
                        <td class='tg-yw4l'>". $address ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Email:</td>
                        <td class='tg-yw4l'>". $email ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Phone Number:</td>
                        <td class='tg-yw4l'>". $phone ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Reference Number:</td>
                        <td class='tg-yw4l'>". $refNum ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Part Number:</td>
                        <td class='tg-yw4l'>". $partNum ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Quantity:</td>
                        <td class='tg-yw4l'>". $quantity ."</td>
                    </tr>
                    <tr>
                        <td class='tg-amwm'>Comments:</td>
                        <td class='tg-yw4l'>". $comments ."</td>
                    </tr>
                </table>
            </body>
        </html>";

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // actually sending the email
        $mail->send();
        
        // disconnect from server
        $pdo = null;

        // redirect to 'orderForm.html'
        header("refresh:1; url=http://www.sun-aviation.com/htmlFiles/contact.html#bodyText");

        
        // send order confirmation email to customer
    }

    // PHP fatal error
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}

?>