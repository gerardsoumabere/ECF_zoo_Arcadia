<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST["name"];
      $email = $_POST["email"];
      $message = $_POST["message"];

      // Adresse e-mail du destinataire
      $to = "destinataire@example.com";

      // Sujet de l'e-mail
      $subject = "Message de contact de $name";

      // Contenu de l'e-mail
      $email_content = "Nom: $name\n";
      $email_content .= "Email: $email\n\n";
      $email_content .= "Message:\n$message\n";

      // En-têtes de l'e-mail
      $headers = "From: $name <$email>";

      // Envoyer l'e-mail
      if (mail($to, $subject, $email_content, $headers)) {
          echo '<div class="alert alert-success" role="alert">
                  Votre message a bien été envoyé. Nous vous répondrons dès que possible.
                </div>';
      } else {
          echo '<div class="alert alert-danger" role="alert">
                  Désolé, une erreur s\'est produite. Veuillez réessayer plus tard.
                </div>';
      }
  }
  ?>

<div class="container">
    <form action="/contact_form.php" method="post">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" class="form-control" id="name" name="name"
                required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
                required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5"
                required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

</body>