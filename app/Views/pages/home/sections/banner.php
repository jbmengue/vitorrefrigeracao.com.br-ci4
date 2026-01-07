<section class="main-banner">
  <img
    src="<?= assets('images', 'banners/main-banner/bg.jpg') ?>"
    alt=""
    class="absolute inset-0 h-full w-full object-cover"
    loading="eager"
  />
  <div class="wrapper">
    <div class="layout-container wide relative flex flex-col md:justify-center md:items-end h-full text-center md:text-end z-20 py-15 md:py-0">
      <i class="flaticon-support text-7xl mb-10" data-aos="flip-left"></i>
      <h1 data-aos="fade-right" data-aos-delay="100">Todas as Soluções<br />em um só lugar</h1>
      <div class="text-2xl" data-aos="fade-left" data-aos-delay="200">
        Atendimento on-line<br />24h / 7 dias por semana
      </div>
      <div class="mt-15">
        <div class="flex flex-col md:flex-row justify-between gap-10">
          <button class="btn-secondary btn-lg" data-aos="zoom-in" data-aos-delay="300">Abrir um chamado</button>
          <button class="btn-primary btn-lg" data-aos="zoom-in" data-aos-delay="400"><i class="flaticon-telephone"></i><?= config(\Config\App::class)->whatsapp ?></button>
        </div>
        <div class="text-end mt-5" data-aos="fade-up" data-aos-delay="500">(aos Sábados das 7h30 às 16h)</div>
      </div>
    </div>
    <div class="overlay"></div>
  </div>
</section>