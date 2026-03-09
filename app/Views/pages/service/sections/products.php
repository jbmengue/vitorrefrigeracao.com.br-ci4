<section class="pb-50">
  <div class="layout-container">
    <h1 class="font-bold uppercase text-center text-[var(--service-color)] mb-20">Produtos que atendemos</h1>
    <div class="flex flex-wrap justify-around md:justify-center items-stretch gap-x-10 lg:gap-x-25 gap-y-25">
      <?php foreach ($post->products as $product): ?>
        <div class="relative px-2 lg:px-5">
          <div class="flex items-center justify-center w-full h-full">
            <img alt="<?= $product->label ?>" title="<?= $product->label ?>" src="<?= assets('icons', "products/$product->icon") ?>" class="mx-auto block" />
          </div>
          <div class="text-center w-full h-20 absolute -bottom-23 text-base/5 left-0 font-semibold">
            <?= $product->label ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>