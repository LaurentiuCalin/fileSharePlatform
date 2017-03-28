<?php

$userId = $_GET['userId'];
$passCode = $_GET['code'];

?>
<form action="resetPassword.php?userId=<?php echo $userId;?>&passCode=<?php echo $passCode;?>" method="post">
<h1>Reset your password</h1>

<input type="password" name="newPassword" placeholder="new password">
<input type="password" name="confirmNewPassword" placeholder="repeat the new password">

<button id="btn-new-password">Submit</button>
</form>