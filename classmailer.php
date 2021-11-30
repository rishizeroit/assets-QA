<?php

  include('dbconfig.php');
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fname = strip_tags(trim($_POST["fname"]));
				$fname = str_replace(array("\r","\n"),array(" "," "),$fname);
        $lname = trim($_POST["lname"]);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $address = trim($_POST["address"]);
        $city = trim($_POST["city"]);
        $state = trim($_POST["state"]);
        $zipcode = trim($_POST["zipc"]);
        $edb = trim($_POST["edb"]);
        $wh = trim($_POST["work"]);
        $cr = trim($_POST["classt"]);
         
        $query2="INSERT INTO class (ClassRegistered,FirstName,LastName,Email,Phone,Address,city,state,Zipcode,educb,cuemp) VALUES ('$cr','$fname','$lname','$email','$phone','$address','$city','$state','$zipcode','$edb','$wh')";
        // echo $query2;exit;
         $result2 = mysqli_query($con, $query2);
     

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        //$recipient = "veerendrareddy@krify.net";
          $recipient = "carolinasoftech@gmail.com,sadguna@krify.net, swarna@krify.net";

        // Set the email subject.
        $subject = "New Register from $name";
        $subject2 = "Confirmation contact form - Carolina";

        // Build the email content.
        $email_content .= "Class Registered:$cr\n";
        $email_content = "First Name: $fname\n";
        $email_content .= "Last Name: $lname\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone:$phone\n";
      //  $email_content .= "Address: $address\n";
      //  $email_content .= "City: $city\n";
      //  $email_content .= "State: $state\n";
      //  $email_content .= "Zipcode: $zipcode\n";
        $email_content .= "Education Background: $edb\n";
        $email_content .= "Current Employer: $wh\n";
        
      //echo  $email_content ;
        // Build the email headers.
        $email_headers = "From: $name <$email>";
        $email_headers2 = "From: Admin <$recipient>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            
            mail($email, $subject2, $email_content, $email_headers2);  //costmer mail
            http_response_code(200);
            echo "<script>window.location.href = 'thanyou.php';</script>";
            
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
             echo "<script>window.location.href = 'sorry.php';</script>";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
