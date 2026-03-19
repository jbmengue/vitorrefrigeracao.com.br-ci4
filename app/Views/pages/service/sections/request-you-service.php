<section class="pt-20 bg-[#fff4ec] mb-25">
  <div class="layout-container flex flex-col xl:flex-row justify-center items-center xl:items-end gap-x-25">
    <div class="order-2 xl:order-1">
      <img alt="" title="" src="<?= assets('images', 'figures/01.png') ?>" width="517" height="471" decoding="async" class="h-auto w-full max-w-[517px]" />
    </div>
    <div class="order-1 xl:order-2">
      <div class="text-center xl:text-start">
        <h1 class="text-4xl xl:text-6xl">Solicite seu atendimento ainda hoje</h1>
        <h2 class="text-2xl xl:text-4xl font-normal">Abra seu chamado de forma rápida e fácil</h2>
      </div>
      <div class="flex flex-wrap justify-center xl:justify-start my-20 md:my-10 gap-x-10">
        <div>
          <a href="<?= $appConfig->openTicketLink ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-lg inline-block text-white">Abrir um chamado</a>
        </div>
        <div>
          <a href="tel:<?= $appConfig->phone ?>" class="btn-primary btn-lg py-3 lg:w-[350px] mx-auto text-white">
            <i class="flaticon-telephone"></i>
            <?= $appConfig->phone ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
