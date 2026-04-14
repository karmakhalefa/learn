<?php
session_start();

$errors = [];

if(isset($_FILES['image'])){

    $file = $_FILES['image'];

    $fileName = $file['name'];
    $tmpName  = $file['tmp_name'];
    $error    = $file['error'];
    $size     = $file['size'];

    // هل في صورة؟
    if($error === 4){
        $errors['image'] = "من فضلك اختار صورة";
    } elseif($error !== 0){
        $errors['image'] = "حصل خطأ أثناء رفع الصورة";
    }

    // الامتداد
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExt = ['png', 'jpg', 'jpeg'];

    if(!in_array(strtolower($ext), $allowedExt)){
        $errors['image'] = "لازم ترفع صورة بـ png أو jpg أو jpeg";
    }

    // الحجم (2MB)
    if($size > 2 * 1024 * 1024){
        $errors['image'] = "حجم الصورة كبير";
    }

    // لو مفيش errors
    if(empty($errors)){

        // التحقق من MIME type الحقيقي (أمان إضافي)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpName);
        finfo_close($finfo);

        $allowedMime = ['image/png', 'image/jpeg'];
        if(!in_array($mimeType, $allowedMime)){
            $errors['image'] = "نوع الملف غير مسموح به";
        } else {
            // اسم فريد وآمن
            $newName = bin2hex(random_bytes(16)) . "." . $ext;
            $uploadPath = "uploads/" . $newName;

            if(move_uploaded_file($tmpName, $uploadPath)){
                $_SESSION['success'] = "تم رفع الصورة بنجاح";
            } else {
                $errors['image'] = "فشل في حفظ الصورة";
            }
        }
    }
}
?>