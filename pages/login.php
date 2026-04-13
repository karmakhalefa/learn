<?php
// إيه الغلطات اللي ممكن المستخدم يعملها؟

// ❌ الحالات:
// الاسم فاضي
// الإيميل غلط
// الباسورد أقل من 6 حروف
// confirm مش مطابق
// كله فاضي
// يكتب مسافات بس
$name = "";
$email = "";
$password = "";
$confirm = "";

$nameError = "";
$emailError = "";
$passwordError = "";
$confirmPasswordError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);

    // name
    if(empty($name)){
        $nameError = "Name is required";
    }

    // email
    if(empty($email)){
        $emailError = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError = "Invalid email format";
    }

    // password
    if(empty($password)){
        $passwordError = "Password is required";
    } elseif(strlen($password) < 6){
        $passwordError = "Password must be at least 6 characters";
    }

    // confirm
    if(empty($confirm)){
        $confirmPasswordError = "Confirm password is required";
    } elseif($confirm !== $password){
        $confirmPasswordError = "Passwords do not match";
    }
      // ✅ هنا بقى الحفظ
    if(empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError)){

        $file = '' . __DIR__ . '/users.json';

        if(file_exists($file)){
            $data = file_get_contents($file);
            $users = json_decode($data, true);
        } else {
            $users = [];
        }

        $users[] = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

        echo "تم التسجيل بنجاح ✅";
    }

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/style.css">
<script src="../assets/main.js"></script>
    <title>Document</title>
</head>
<body class="body_login">
    <div class="login_page">
    <div class="headr_form">
    <h1> Zync System</h1>
    <h2>Sign In</h2>
    <p>Enter your credentials to access your account</p>
    </div>
    
<form method="POST">
       
    <div class="form_name"> 

        <label class="label_Name"> Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your name" class="username">
   <span style="color:red;">
        <?php echo $nameError; ?>
    </span>
</div>
 <div class="form_email"> 

<label class="label_email">email</label>
<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email" class="input_email">
<span style="color:red;">
    <?php echo $emailError; ?>
</span>
</div>

     <div class="form_password" style="position: relative;"> 

       <label class="label_password">Password</label>
           <span onclick="togglePassword()" 
          style="position: absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
        👁️
    </span>
    <input type="password" name="password" id="password" placeholder="Enter your password" class="password" >
    <span style="color:red;">
    <?php echo $passwordError; ?>
</span>





        </div>
    <div class="confirm_Password">  
         <label class="label_confirm-password"> confirm Password</label>
    <input type="password" name="confirm_password"  placeholder="Enter your confirm password" class="input_confirm_Password">
    <span style="color:red;">
    <?php echo $confirmPasswordError; ?>
</span>
</div>



    <input type="submit" class="login" value="login"></input>
    <p>Forgot your password?  
        <span>Reset Password</span>
    </p>
</form> 
</div>
</body>
</html>


