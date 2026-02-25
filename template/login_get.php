

<section>
    <div class="container">
        <h3 class="my-3">Login Page</h3>
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Sign In</button>
        </form>
        <p class="mt-3">Already have an account? <a href="/create_account">Register here</a></p>
        <hr>
        <a href="home.php" class="btn btn-secondary">Go back</a>
</section>