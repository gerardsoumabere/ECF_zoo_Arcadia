<?php
    // Include the HabitatController
    require_once __DIR__.'/../controllers/HabitatController.php';

    use Controllers\HabitatController;

    // Create an instance of HabitatController
    $habitatController = new HabitatController($conn);

    // Get all habitats
    $habitats = $habitatController->index();
?>

<style>
.habitat-img:hover,
.animal-img:hover {
    cursor: zoom-in;
}
</style>

<!-- Modal -->
<div class="modal fade" id="animalModal" tabindex="-1"
    aria-labelledby="animalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="animalModalLabel">Animal Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="animalInfoModalBody"></div>
        </div>
    </div>
</div>

<div class="container">
    <h1>Liste des habitats</h1>
    <div class="row">
        <?php foreach ($habitats as $habitat): ?>
        <div class="col-md-4">
            <div class="card">
                <img class="card-img-top habitat-img"
                    src="<?php echo $habitat->getImages(); ?>"
                    alt="<?php echo $habitat->getName(); ?>"
                    data-toggle="collapse"
                    data-target="#habitat<?php echo $habitat->getId(); ?>">
                <div class="card-body">
                    <h5 class="card-title habitat-title" data-toggle="collapse"
                        data-target="#habitat<?php echo $habitat->getId(); ?>">
                        <?php echo $habitat->getName(); ?></h5>
                    <div id="habitat<?php echo $habitat->getId(); ?>"
                        class="collapse">
                        <p class="card-text">
                            <?php echo $habitat->getDescription(); ?></p>
                        <p class="card-text">Animaux dans cet habitat :</p>
                        <ul class="list-group list-group-flush">
                            <?php
                                $animals = $habitatController->getAnimalsByHabitat($habitat->getId());
                                foreach ($animals as $animal):
                            ?>
                            <li class="list-group-item">
                                <img src="<?php echo $animal->getImage(); ?>"
                                    alt="<?php echo $animal->getName(); ?>"
                                    width="50" class="animal-img"
                                    data-toggle="modal"
                                    data-target="#animalModal"
                                    data-animal-name="<?php echo $animal->getName(); ?>"
                                    data-animal-image="<?php echo $animal->getImage(); ?>"
                                    data-animal-description="<?php echo $animal->getAnimalStatus(); ?>">
                                <?php echo $animal->getName(); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js">
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const habitatImages = document.querySelectorAll('.habitat-img');
    const habitatTitles = document.querySelectorAll('.habitat-title');
    const animalImages = document.querySelectorAll('.animal-img');

    habitatImages.forEach((image) => {
        image.addEventListener('click', toggleHabitatDetails);
    });

    habitatTitles.forEach((title) => {
        title.addEventListener('click', toggleHabitatDetails);
    });

    animalImages.forEach((image) => {
        image.addEventListener('click', openAnimalModal);
    });

    function toggleHabitatDetails(event) {
        const habitatId = event.target.dataset.target.slice(1);
        const habitatDetails = document.getElementById(habitatId);

        if (habitatDetails.classList.contains('show')) {
            habitatDetails.classList.remove('show');
        } else {
            const openDetails = document.querySelector(
                '.collapse.show');
            if (openDetails) {
                openDetails.classList.remove('show');
            }
            habitatDetails.classList.add('show');
        }
    }

    function openAnimalModal(event) {
        const animalName = event.target.dataset.animalName;
        const animalImage = event.target.dataset.animalImage;
        const animalDescription = event.target.dataset
            .animalDescription;

        const modalTitle = document.querySelector(
            '#animalModal .modal-title');
        modalTitle.textContent = animalName + ' Information';

        const modalBody = document.querySelector(
            '#animalInfoModalBody');
        modalBody.innerHTML = `
                <img src="${animalImage}" alt="${animalName}" class="img-fluid">
                <p>${animalDescription}</p>
            `;

        $('#animalModal').modal('show');
    }
});
</script>