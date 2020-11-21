<?php
include ("input_validation.php");
include_once ("conf/pdo.php");
?>
<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email =  $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $val_object = new validation();

    $name = $val_object->test_input($_POST['name']);
    $email = $val_object->test_input($_POST['email']);
    $website = $val_object->test_input($_POST['website']);
    $comment= $val_object->test_input($_POST['comment']);
    if(isset($_POST['gender'])) $gender = $val_object->test_input($_POST['gender']);


    $result=$val_object->input_validation($name,"/^[a-zA-Z ]*$/","Name is required","Only letters and white space allowed");
    $nameErr=$result[0];
    $Check['name']=$result[1];

    $result=$val_object->input_validation($email,"(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)","Email is required","email must be in style example@example.com");
    $emailErr=$result[0];
    $Check['email']=$result[1];

    $result=$val_object->input_validation($website,"/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i","Website is required","Website must be in style http:// or https://  or ftp://");
    $websiteErr=$result[0];
    $Check['website']=$result[1];

    $result=$val_object->selection_validation($gender,"gender selection is required");
    $genderErr=$result[0];
    $Check['gender']=$result[1];

    foreach($Check as $value)
    {
        if($value==false)
        {
            $flag=false;
            break;
        }
        $flag=true;
    }

    if($flag==true){

        try{
            // input DB
            $sql = "INSERT INTO data (name, email, website, comment, gender)
  VALUES ('$name', '$email', '$website', '$comment', '$gender')";
            // use exec() because no results are returned
            $conn->exec($sql);
            header("location:ValidationOK.html");
            exit(0);

        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
    Website: <input type="text" name="website" value="<?php echo $website;?>">
    <span class="error">*<?php echo $websiteErr;?></span>
    <br><br>
    Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
    <br><br>
    Gender:
    <input type="radio" name="gender" value="female" <?php if ($gender == "female") echo "checked";?> >Female
    <input type="radio" name="gender" value="male" <?php if ($gender == "male") echo "checked";?>>Male
    <input type="radio" name="gender" value="other" <?php if ($gender == "other") echo "checked";?>>Other
    <span class="error">* <?php echo $genderErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>