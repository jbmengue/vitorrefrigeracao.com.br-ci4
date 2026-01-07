<div class="flex flex-col lg:flex-row justify-center items-center gap-20">
  <?php
  foreach ($locations as $key => $location): ?>
    <address class="not-italic text-center text-xl" data-aos="zoom-in" data-aos-delay="<?= ($key + 1) * 100 ?>">
      <i class="flaticon-maps-and-flags before:text-5xl before:text-primary"></i>
      <h3 class="text-xl mb-0 mt-5"><?= $location->title ?></h3>
      <span class="block"><?= $location->street ?>, <?= $location->number ?></span>
      <span class="block"><?= $location->district ?>, CEP: <?= $location->zipcode ?></span>
      <span class="block"><?= $location->city ?> - <?= $location->stateAbbr ?></span>
    </address>
  <?php endforeach; ?>
</div>