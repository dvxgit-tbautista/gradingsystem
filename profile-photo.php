<?php
require_once "pdo.php";
session_start();
$userUid = $_SESSION['username'];
$stmt = $pdo->query("SELECT * FROM users WHERE username = '$userUid'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['submit'])) {
    // Count total files
    $countfiles = count($_FILES['files']['name']);


    $sql = "UPDATE users SET profilePhoto = :profilePhoto WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    /**/
    // Loop all files
    for ($i = 0; $i < $countfiles; $i++) {

        // File name
        $filename = $_FILES['files']['name'][$i];
        // Location
        $target_file = 'photo/' . $filename;

        // file extension
        $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);

        // Valid image extension
        $valid_extension = array("png", "jpeg", "jpg");

        if (in_array($file_extension, $valid_extension)) {

            // Upload file
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {

                // Execute query
                $stmt->execute(array(
                    ':profilePhoto' => $target_file,
                    ':username' => $userUid
                ));
                $_SESSION['success'] = 'Profile Photo updated!';
                header('Location: profile-photo.php');
                return;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="page-content">
        <br>
        <div class="container">
            <div class="row">

                <div class="col-md-3"></div>

                <div class="col-md-4">
                    <div class="post">
                        <div class="post-thumbnail" style="height:200px; width:200px; border-radius:50%;">
                            <img src="<?php echo $row['profilePhoto']; ?>" alt="Profile Photo" style="height:200px; width:200px;">
                        </div><!-- .post-thumbnail -->
                        <br>
                        <form method="post" enctype='multipart/form-data'>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <span class="form-label"><b>Upload Profile Photo</b></span>
                                    <br>
                                    <br><input type='file' name='files[]' />
                                </div>
                            </div><!-- .col -->

                            <div class="col-lg-12">
                                <div class="form-group--submit">
                                    <button class="button button--square button--primary button--large button--submit" type="submit" name="submit">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                            <p>
                                <a href="profile.php">Back to profile</a>
                            </p>
                        </form>
                    </div><!-- .post -->
                </div><!-- .col -->
            </div>
        </div>
    </div>

</body>

</html>