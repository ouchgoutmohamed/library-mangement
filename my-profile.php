<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
require("login-check/login-check-m.php");
include("connection/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biblio-Gest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/jpg" href="Images/icon.ico"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body id="body-pd">
<?php include("Includes/navbar.php");?>
<?php
include 'repository/MemberService.php';
include 'model/Member.php';
$memberService = new MemberService();
$member=new Member();
try {

    $result = $memberService->getMember($_SESSION["M_ID"]);
    foreach ($result as $row) {
        $id =$row[0];
        $name=$row[1];
        $email=$row[2];
        $no=$row[3];
        $imgUrl=$row[6];
        $password=$row[5];

    }
} catch (PDOException $th) {
    echo $th->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        try {

            $id =$member->setMemberId($id);
            $name=$member->setName($_POST['name']);
            $email=$member->setEmail($_POST['email']);
            $no=$member->setNo($_POST['no']);
            $imgUrl=$member->setImgUrl($_POST['imgUrl']);

            //  Write to db
            try {
                $check=$memberService->updateMember($member);
                if ($check==1){
                    echo "<script>";
                    echo "$(document).ready(function() {";
                    echo "Swal.fire({";
                    echo " icon: 'success',";
                    echo "text: 'Profile details updated successfully!',";
                    echo "}).then((result) => {";
                    echo "window.history.back();";
                    echo "});";
                    echo "});";
                    echo "</script>";
                }
                else{
                    echo "<script> alert(' Failed!');</script>";
                }
            }
            catch(Exception $ex){
                echo $ex;
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save-pw'])) {
            try {
                $oPw = md5($_POST["oPw"]);
                if ($oPw == $password) {
                    if ($_POST["rNPw"] == $_POST["nPw"]) {
                        $npw = md5($_POST["nPw"]);
                        if ($npw==$password){
                            echo "<script>";
                            echo "$(document).ready(function() {";
                            echo "Swal.fire({";
                            echo " icon: 'warning',";
                            echo "text: 'New password & old password cannot be same!',";
                            echo "}).then((result) => {";
                            echo "});";
                            echo "});";
                            echo "</script>";
                        }else{
                            $check=$memberService->changePassword($id,$npw);

                            if($check==1){
                                echo "<script>";
                                echo "$(document).ready(function() {";
                                echo "Swal.fire({";
                                echo " icon: 'success',";
                                echo "text: 'Password updated Successfully!',";
                                echo "}).then((result) => {";
                                echo "});";
                                echo "});";
                                echo "</script>";
                            }
                            else{
                                echo "<script>";
                                echo "$(document).ready(function() {";
                                echo "Swal.fire({";
                                echo " icon: 'warning',";
                                echo "text: 'Password update failed!',";
                                echo "}).then((result) => {";
                                echo "});";
                                echo "});";
                                echo "</script>";
                            }
                        }
                    } else {
                        echo "<script>";
                        echo "$(document).ready(function() {";
                        echo "Swal.fire({";
                        echo " icon: 'warning',";
                        echo "text: 'The reentered password does not match to the new password!',";
                        echo "}).then((result) => {";
                        echo "});";
                        echo "});";
                        echo "</script>";
                    }
                } else {
                    echo "<script>";
                    echo "$(document).ready(function() {";
                    echo "Swal.fire({";
                    echo " icon: 'warning',";
                    echo "text: 'Enter the correct old password!',";
                    echo "}).then((result) => {";
                    echo "});";
                    echo "});";
                    echo "</script>";
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
    }
}
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
?>

<!--Container Main start-->
<div class="main container">

    <div class="row">
        <div class="col-md-4" id="imageHolder" style="margin: auto">
            <!--            <img src="https://via.placeholder.com/200x300" alt="Book Cover" class="img-fluid book-cover">-->
            <img src="<?php echo $imgUrl;?>" alt="Book Cover" class="book-cover" style="border-radius: 50%;width: 300px;height: 300px;object-fit: cover;"
                 onerror="this.onerror=null;this.src='Images/userPlaceholder.png';" >
        </div>
        <div class="col-md-8">
            <h1 class="mb-4">My Profile</h1>
            <form method="post" enctype="multipart/form-data" action="" class="book-form">
                <div class="row mb-3">
                    <label for=member-id" class="col-sm-3 col-form-label">Member ID</label>
                    <div class="col-sm-9">
                        <label for="id" class="col-sm-3 col-form-label" name="memberId"><?php echo $id;?></label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" required disabled>
                        <span id="nameErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" required disabled>
                        <span id="emailErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="edition" class="col-sm-3 col-form-label">Contact No</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="no" name="no" value="<?php echo $no;?>" required disabled>
                        <span id="noErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="url" class="col-sm-3 col-form-label">Image URL</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="imgUrl" name="imgUrl" value="<?php echo $imgUrl;?>" required disabled>
                        <span id="urlErr"></span>
                    </div>
                </div>
                <div class="row mb-3" id="oldPw" hidden>
                    <label for="pw" class="col-sm-3 col-form-label">Enter Old Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="oPW" name="oPw"  disabled>
                    </div>
                </div>
                <div class="row mb-3" id="newPw" hidden>
                    <label for="npw" class="col-sm-3 col-form-label">Enter New Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="nPw" name="nPw"  disabled>
                    </div>
                </div>
                <div class="row mb-3" id="reNewPw" hidden>
                    <label for="rnpw" class="col-sm-3 col-form-label">Re-enter the New Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="rNPw" name="rNPw"  disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-flex" id="edit-btn">Update Profile</button>
                        <input type="submit" class="btn btn-success d-none btn-flex" id="save-btn" value="Save" name="save">
                        <button type="button" class="btn btn-primary btn-flex" id="pw-btn">Change Password</button>
                        <input type="submit" class="btn btn-success d-none btn-flex" id="save-pw" value="Save Password" name="save-pw">
                        <button type="button" id="cancel" class=" btn btn-danger d-none btn-flex" onclick="window.location.replace('my-profile.php');">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!--Container Main end-->
<script src="js/navbar.js"></script>
<script src="js/validateEditProfile.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        const $imageLinkInput = $('#imgUrl');
        const $imageHolder = $('#imageHolder');

        $imageLinkInput.on('input', function() {
            const imageUrl = $imageLinkInput.val();
            $imageHolder.html(`<img src="${imageUrl}" alt="Profile Picture" class="img-fluid book-cover" style="border-radius: 50%;width: 300px;height: 300px;object-fit: cover;"
                        onerror="this.onerror=null;this.src='https://bmva.org.uk/images/listings/no-image.jpg';">`);
        });
    });
    $(function () {
        $('#edit-btn').click(function () {
            $('input').prop('disabled', false);
            $('#edit-btn').addClass('d-none');
            $('#save-btn').removeClass('d-none');
            $('#cancel').removeClass('d-none');
            $('#pw-btn').addClass('d-none');
            $('#newCopies').prop('hidden',false);
        });
    });
    $(function () {
        $('#pw-btn').click(function () {
            // $('input').prop('disabled', false);
            $('#edit-btn').addClass('d-none');
            $('#pw-btn').addClass('d-none');
            $('#save-pw').removeClass('d-none');
            $('#cancel').removeClass('d-none');
            $('#oldPw').prop('hidden',false);
            $('#newPw').prop('hidden',false);
            $('#reNewPw').prop('hidden',false);
            $('#oPW').prop('disabled',false);
            $('#nPw').prop('disabled',false);
            $('#rNPw').prop('disabled',false);
            $('#oPW').prop('required',true);
            $('#nPw').prop('required',true);
            $('#rNPw').prop('required',true);


        });
    });
</script>
<?php include 'Includes/footer.php' ?>
</body>
</html>
