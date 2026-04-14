<?php
session_start();

$name = $email = $password = $confirm = $image = "";
$nameError = $emailError = $passwordError = $confirmPasswordError = $imageError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

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

    // image
    $imageName = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['png', 'jpg', 'jpeg'];
        if(!in_array($ext, $allowedExt)){
            $imageError = "يجب رفع صورة بصيغة png أو jpg";
        } elseif($_FILES['image']['size'] > 2 * 1024 * 1024){
            $imageError = "حجم الصورة كبير (أكثر من 2MB)";
        } else {
            $imageName = bin2hex(random_bytes(8)) . "." . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/uploads/' . $imageName);
        }
    }

    // حفظ لو مفيش أخطاء
    if(empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError) && empty($imageError)){

     $file = __DIR__ . '/../date/users.json';
        $users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        // فحص الإيميل موجود؟
        foreach($users as $u){
            if($u['email'] === $email){
                $emailError = "هذا الإيميل مسجل مسبقاً";
                break;
            }
        }

        if(empty($emailError)){
            $users[] = [
                'name'     => $name,
                'email'    => $email,
                'image'    => $imageName,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
            header("Location: login.php");
            exit();
        }
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
    <title>Register - Zync System</title>
</head>
<body class="body_login">
<div class="login_page">
    <div class="headr_form">
        <h1>Zync System</h1>
        <h2>Sign Up</h2>
        <p>Create a new account</p>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <div class="form_name">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your name" class="username">
            <span style="color:red;"><?php echo $nameError; ?></span>
        </div>

        <div class="form_email">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email" class="input_email">
            <span style="color:red;"><?php echo $emailError; ?></span>
        </div>

        <div class="form_password" style="position:relative;">
            <label>Password</label>
            <span onclick="togglePassword()" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">👁️</span>
            <input type="password" name="password" id="password" placeholder="Enter your password" class="password">
            <span style="color:red;"><?php echo $passwordError; ?></span>
        </div>

        <div class="confirm_Password">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm your password" class="input_confirm_Password">
            <span style="color:red;"><?php echo $confirmPasswordError; ?></span>
        </div>

        <div class="form_image">
            <label>Profile Image (optional)</label>
            <input type="file" name="image" accept="image/*">
            <span style="color:red;"><?php echo $imageError; ?></span>
        </div>

        <input type="submit" class="login" value="Register">

        <p>Already have an account? <a href="login.php">Login</a></p>

    </form>
</div>
</body>
</html>