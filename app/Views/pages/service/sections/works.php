<section>
  <div class="layout-container">
    <h1 class="font-bold uppercase text-center text-[var(--service-color)] mb-20">Serviços que realizamos</h1>
    <div class="grid grid-cols-1 items-stretch gap-x-10 gap-y-25 lg:grid-cols-3">
      <?php foreach ($post->works as $work): ?>
        <div class="text-center">
          <div class="mb-5">
            <img alt="" title="" src="<?= $appConfig->upload ?>/images/large/<?= $work->fileName ?>" class="object-cover aspect-4/3 rounded-2xl block mx-auto w-full" />
          </div>
          <h2 class="text-[var(--service-color)] text-2xl uppercase"><?= $work->title ?></h2>
          <p class="text-gray-800"><?= $work->description ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="flex justify-center my-20 md:my-35">
      <a href="<?= $appConfig->openTicketLink ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-lg inline-block text-white text-sm md:text-xl">Abrir um chamado agora</a>
    </div>
  </div>
</section>
