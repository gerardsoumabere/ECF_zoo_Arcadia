<div class="container">
    <h1>Connexion</h1>
    <form action="/login" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password"
                name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>