<html>
<head>
    <title>My Form valitest</title>
</head>
<body>

    <?= $validation->listErrors() ?>

    <!-- ?= form_open('formv') ? -->
    <form action="http://localhost/formv" method="post" accept-charset="utf-8">

        <h5>Username</h5>
        <input type="text" name="username" value="" size="50">

        <h5>Password</h5>
        <input type="text" name="password" value="" size="50">

        <h5>Password Confirm</h5>
        <input type="text" name="passconf" value="" size="50">

        <h5>Email Address</h5>
        <input type="text" name="email" value="" size="50">

        <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

        <div><input type="submit" value="Submit"></div>

        </form>


    <!-- ?= form_close() ? -->

</body>
</html>