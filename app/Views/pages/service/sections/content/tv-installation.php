<?php
$items = array_map(
  static fn (array $item): object => (object) $item,
  [
    ['label' => 'Instalação', 'icon' => 'pluge.png'],
    ['label' => 'Suporte', 'icon' => 'suporte.png'],
  ]
);
?>
<section class="pb-50">
  <div class="layout-container">
    <h1 class="font-bold uppercase text-center text-[var(--service-color)] mb-20">Trabalhamos com</h1>
    <div class="flex flex-wrap justify-around md:justify-center items-stretch gap-x-10 lg:gap-x-25 gap-y-25">
      <?php foreach ($items as $item): ?>
        <div class="relative px-2 lg:px-5">
          <div class="flex items-center justify-center w-[111px] h-[80px] mx-auto mb-5">
            <img
              alt="<?= $item->label ?>"
              title="<?= $item->label ?>"
              src="<?= assets('icons', "products/$item->icon") ?>"
              loading="lazy"
              decoding="async"
            />
          </div>
          <div class="text-center max-w-[250px] text-base/5 left-0 font-semibold">
            <?= $item->label ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
