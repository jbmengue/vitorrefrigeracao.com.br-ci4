<footer class="bg-size-[100%] bg-no-repeat bg-bottom " style="background-image: url(<?= assets('images', 'bg/03.png') ?>);">
  <section class="bg-cover py-20" style="background-image: url(<?= assets('images', 'bg/02.png') ?>);">
    <div class="layout-container">
      <div class="text-center text-white mb-25">
        <h1 class="mb-2">Fale Conosco</h1>
        <p class="text-xl">A nossa equipe está pronta para te ajudar.</p>
      </div>
      <div class="flex flex-col lg:flex-row justify-between gap-x-20 gap-y-10">
        <div>
          <div>
            <div class="flex flex-col lg:flex-row justify-start gap-x-10">
              <a href="<?= $appConfig->openTicketLink ?>" class="btn-secondary btn-lg h-20 mb-5">
                Abra um chamado
              </a>
              <button type="button" class="btn-secondary btn-lg h-20 mb-5" onclick="<?= esc(whatsapp_conversion_onclick(), 'attr') ?>">
                Conversar agora
              </button>
            </div>
            <div class="text-xl text-white font-bold text-center">
              <p>Atendimento online 24h/7 dias por semana</p>
            </div>
          </div>
        </div>
        <div>
          <a href="tel:<?= $appConfig->phone ?>" class="btn-primary btn-lg h-20 mb-5 lg:w-[350px] mx-auto">
            <i class="flaticon-telephone"></i>
            <?= $appConfig->phone ?>
          </a>
          <div class="text-xl text-white font-bold text-center">
            <?php if (!empty($appConfig->serviceHoursWeek)): ?>
              <p class="m-0">
                2ª às 6ª das <?= esc($appConfig->serviceHoursWeek) ?>
                <?php if (!empty($appConfig->serviceHoursSaturday)): ?>
                  - sábados das <?= esc($appConfig->serviceHoursSaturday) ?>
                <?php endif; ?>
              </p>
            <?php endif; ?>
            <p class="m-0"><?= esc($appConfig->email) ?></p>
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
        Grupo <?= $appConfig->name ?>
      </h1>
      <div class="flex flex-col lg:flex-row justify-center items-center gap-20 mb-30">
        <div data-aos="fade-up">
          <img alt="" title="" src="<?= assets('images', 'vitor-refrigeracao.png') ?>" width="266" height="90" decoding="async" />
        </div>
        <div data-aos="fade-up">
          <a href="https://smartfriors.com.br/" target="_blank" rel="noopener noreferrer"><img alt="" title="" src="<?= assets('images', 'smartfrio.png') ?>" width="286" height="62" decoding="async" /></a>
        </div>
      </div>
      <div class="flex flex-col lg:flex-row justify-center items-center gap-20 mb-30">
        <div data-aos="fade-up" data-aos-delay="400">
          <img alt="" title="" src="<?= assets('images', 'lg-center-service.png') ?>" width="348" height="47" decoding="async" />
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
          <a href="https://www.mercadolivre.com.br/pagina/multipartspoa" target="_blank" rel="noopener noreferrer"><img alt="" title="" src="<?= assets('images', 'multipartspoa-mercado-livre.png') ?>" width="612" height="67" decoding="async" /></a>
        </div>
        
      </div>

      <?= cached_cell(App\Cells\Location\Footer::class) ?>
      
      <div class="text-center text-xl mt-20">
        <strong>Atendimento online 24h/7 dias por semana</strong>
        <?php if (!empty($appConfig->serviceHoursWeek)): ?>
        <p class="m-0">
          <strong><?= $appConfig->phone ?></strong><br /><small>(2ª às 6ª das <?= esc($appConfig->serviceHoursWeek) ?>
          <?php if (!empty($appConfig->serviceHoursSaturday)): ?>
            - sábados das <?= esc($appConfig->serviceHoursSaturday) ?>)</small>
          <?php endif; ?>
        </p>
      <?php endif; ?>
      <p class="m-0"><?= esc($appConfig->email) ?></p>
      </div>
    </div>
</section>
<div class="bg-black text-center py-8 px-4 text-white mt-10">
  <?= $appConfig->name ?> - Desde 1983 - Todos os direitos reservados. Design e programação: <a href="//agencia-millenium.com" target="_blank" class="underline underline-offset-3">Studio Millenium</a>
</div>
</footer>
<?php layout_snippet('whatsapp-floating-button') ?>
