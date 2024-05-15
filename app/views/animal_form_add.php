<div class="container">
    <h2>Ajouter un animal</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/animals/add" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de
                        l'animal:</label>
                    <input type="text" class="form-control" id="name"
                        name="name" value="Lion">
                </div>
                <div class="mb-3">
                    <label for="race" class="form-label">Race de
                        l'animal:</label>
                    <input type="text" class="form-control" id="race"
                        name="race" value="Lion d'Afrique">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo isset($_SESSION['newfileurl']) ? "/public" .$_SESSION['newfileurl'] : ""; ?>"
                        readonly>
                    <?php if(isset($_SESSION['newfileurl'])) { ?>
                    <img src="<?php  echo "/public".$_SESSION['newfileurl']; ?>"
                        class="img-fluid" alt="Image téléchargée">
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="habitat" class="form-label">Habitat:</label>
                    <select class="form-select" id="habitat" name="habitat">
                        <option value="1">Savane</option>
                        <option value="2">Jungle</option>
                        <option value="3">Marais</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="animal_detail" class="form-label">Détail de
                        l'animal:</label>
                    <textarea class="form-control" id="animal_detail"
                        name="animal_detail">L'animal vit en groupe dans les savanes africaines. Il se nourrit principalement de viande.</textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitAnimal">Enregistrer</button>
            </form>
        </div>
    </div>
</div>