<form class="form-signin" method="post">
    <input type="hidden" name="action" value="register">
    <h2 class="form-signin-heading">Please Register</h2>
    <?php
        if ($error = $this->getVar('error')) { ?>
            <div class="alert alert-danger"><?php echo $error ?></div>
        <?php }
    ?>
    <label for="inputEmail">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus value="<?php echo $this->param('email') ?>">
    <label for="inputName">Name</label>
    <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" required autofocus value="<?php echo $this->param('name') ?>">
    <label for="inputPassword">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required value="<?php echo $this->param('password') ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register!</button>
</form>