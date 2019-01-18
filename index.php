<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require './config-mail.php';
require './camera/lib/db.php';

if(isset($_POST['send'])){

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {

    $dataemail = $_POST['email']; 
    $datasubject = $_POST['subject'];
    $datadeskripsi = $_POST['deskripsi'];

    $query = mysqli_query($link,"INSERT INTO mailer (email,subject,deskripsi)VALUES('$dataemail','$datasubject','$datadeskripsi')");

    if($query){
        echo "sukses";
    }
    else {
        echo "gagal";
    }
    



    $emailTo = $_POST['email'];
    $subject = $_POST['subject'];
    $deskripsi = $_POST['deskripsi'];

    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = SMTPUSER;                 // SMTP username
    $mail->Password = SMTPPASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('netkom2013@gmail.com', 'adi rahman');
    $mail->addAddress($emailTo);     // Add a recipient
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $deskripsi;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My mail</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        })
    </script>
</head>
<body>

    <h1 class="text-center">My Mail Apps</h1>
    
    <div class="container">
    <form method="post">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control"/>

            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control"/>

            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea cols="5" rows="5" name="deskripsi" class="form-control"></textarea>

            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-danger" name="send" class="form-control" value="kirim"/>

            </div>
        </div>
    </form>
    <table id="myTable">
        <thead>
            <tr>
                <th>Email</th>
                <th>Subjek</th>
                <th>Pesan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $querySelect = mysqli_query($link,"SELECT * FROM mailer");
                while($row = mysqli_fetch_array($querySelect)){
            ?>
                <tr>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['subject'] ?></td>
                    <td><?php echo $row['deskripsi'] ?></td>
                </tr>
            <?php 
                }
            ?>
        </tbody>
    </table>
    </div>
</body>
</html>