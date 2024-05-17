<div class="container">
    <h1 class="mt-5">Connexion</h1>
    <form action="/login/process" method="post" class="mt-3">
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email"
                required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" id="password"
                name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'auth_failed'): ?>
    <div class="alert alert-danger mt-3">Email ou mot de passe incorrect</div>
    <?php endif; ?>
</div>