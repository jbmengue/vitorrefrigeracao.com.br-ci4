<div class="relative overflow-x-hidden">
  <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center z-1">
    <div class="text-center">
      <img alt="" title="" src="<?= $appConfig->upload ?>/images/large/<?= $post->logoName ?>" class="block mx-auto mb-8 max-w-[75%] lg:max-w-2xl" />
      <h1 class="font-normal text-4xl normal-case"><?= $post->phrase ?></h1>
      <div class="lg:mt-20">
        <div class="flex flex-wrap justify-center items-center gap-x-10  gap-y-5">
          <a href="<?= $appConfig->openTicketLink ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-lg">Abrir um chamado</a>
          <a href="tel:<?= $appConfig->phone ?>" class="btn-primary btn-lg py-3 bg-white text-[var(--service-color)]">
              <i class="flaticon-telephone"></i>
              <?= $appConfig->phone ?>
            </a>
          <div data-aos="zoom-in" data-aos-delay="400">
            <button class="btn-secondary btn-lg w-full lg:w-auto" onclick="<?= esc(
              whatsapp_conversion_onclick(),
              'attr',
            ) ?>">Conversar agora</button>
          </div>
        </div>
        <div class="text-center mt-5 text-xl" data-aos="fade-up" data-aos-delay="500">Atendimento on-line 24h / 7 dias por semana</div>
      </div>
    </div>
  </div>
  <img alt="<?= "{$appConfig->name}: {$post->title}" ?>" title="<?= "{$appConfig->name}: {$post->title}" ?>" src="<?= $appConfig->upload ?>/images/large/<?= $post->imageName ?>" class="w-full h-[calc(100vh-280px)] object-cover min-h-[590px]" />
  <div class="absolute w-[200%] h-[200%] lg:h-[600%] bg-white/75 bottom-15 -left-[50%] rounded-[50%]"></div>
</div>