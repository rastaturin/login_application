<form class="form-signin">
    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <a href="?action=registerForm" class="btn btn-lg btn-default btn-block">Register</a>
</form>
<div class="form-signin">
    <div class="alert alert-danger" id="error">Incorrect email or password!</div>
    <div class="alert alert-success" id="success"><h2>Success!</h2> Hello <span id="name"></span>! <a href=".">Again</a>?</div>
</div>

<script src="/js/main.js"></script>