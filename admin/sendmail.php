<?php

function sendmail($email, $msg, $subject)
{
    //Load Composer's autoloader
    require '../phpmailer/PHPMailerAutoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'email@example.com';                     //SMTP username
        $mail->Password   = 'Your password';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                   

        //Recipients
        $mail->setFrom('bhartametamb@gmail.com', 'bhart ameta');
        $mail->addAddress($email);     //Add a recipient
        // $mail->addReplyTo('bhartametamb@gmail.com', 'bhart');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->AltBody = $msg;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function sendsms($mnumber, $msg, $subject)
{
    $fields = array(
        "sender_id" => "FSTSMS",
        "message" => "Subject : ".$subject."\n".$msg,
        "language" => "english",
        "route" => "p",
        "numbers" => $mnumber,
        "flash" => "0"
    );
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($fields),
      CURLOPT_HTTPHEADER => array(
        "authorization: LpxE1RivCcsBF4VrTuaA8Pb5y6jw9dhWzOl7eKtNoZGqX3k2YHUGOIr6sA8Ce5u21EoatmiZTfJPjcW3",
        "accept: */*",
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      return false;
    } else {
      return true;
    }
}
