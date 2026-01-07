<footer class="bg-cover bg-no-repeat bg-bottom" style="background-image: url(<?= assets('images', 'bg/03.png') ?>);">
  <section class="bg-cover py-20" style="background-image: url(<?= assets('images', 'bg/02.png') ?>);">
    <div class="layout-container">
      <div class="text-center text-white mb-25">
        <h1 class="mb-2">Fale Conosco</h1>
        <p class="text-xl">A nossa equipe está pronta para te ajudar.</p>
      </div>
      <div class="flex flex-col lg:flex-row justify-center gap-x-20 gap-y-10">
        <div>
          <a href="" class="btn-secondary btn-lg h-20 mb-5">
            Abra um chamado
          </a>
          <div class="text-xl text-white font-bold text-center">
            <p>Atendimento 24h, todos os dias da semana</p>
          </div>
        </div>
        <div>
          <a href="" class="btn-primary btn-lg h-20 mb-5">
            <i class="flaticon-telephone"></i>
            <?= config(\Config\App::class)->phone ?>
          </a>
          <div class="text-xl text-white font-bold text-center">
            <p class="m-0">Atendimento na semana das 7h10 - 12h / 13h - 18h30</p>
            <p>Aos sábados das 7h30 às 16h</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="layout-container py-30">
    <?php layout_snippet('brand', ['class' => 'mx-auto block']) ?>
  </div>
  <?php component('nav', [], 'navigation/footer') ?>
  <section class="py-20">
    <div class="layout-container">
      <h1 class="text-center mb-20" data-aos="fade-down">
        Grupo <?= config(\Config\App::class)->name ?>
      </h1>
      <div class="flex flex-col lg:flex-row justify-center items-center gap-20 mb-30">
        <div data-aos="fade-up">
          <img alt="" title="" src="<?= assets('images', 'vitor-refrigeracao.png') ?>" />
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
          <img alt="" title="" src="<?= assets('images', 'multipartspoa.png') ?>" />
        </div>
        <div data-aos="fade-up" data-aos-delay="400">
          <img alt="" title="" src="<?= assets('images', 'lg-center-service.png') ?>" />
        </div>
      </div>

      <?= cached_cell(App\Cells\Location\Footer::class) ?>
    </div>
</section>
<div class="bg-black text-center py-8 px-4 text-white mt-10">
  <?= config(\Config\App::class)->name ?> - Desde 1983 - Todos os direitos reservados. Design e programação: <a href="//agencia-millenium.com" target="_blank" class="underline underline-offset-3">Studio Millenium</a>
</div>
</footer>