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
          <div data-aos="zoom-in" data-aos-delay="300">
            <a href="<?= $appConfig->openTicketLink ?>" target="_blank" rel="noopener noreferrer" class="btn-secondary btn-lg">Abrir um chamado</a>
          </div>
          <div data-aos="zoom-in" data-aos-delay="400">
            <button class="btn-secondary btn-lg w-full lg:w-auto">Conversar agora</button>
          </div>
        </div>
        <div class="text-center mt-5 text-xl" data-aos="fade-up" data-aos-delay="500">(7 dias por semana, 24h por dia)</div>
      </div>
    </div>
    <div class="overlay"></div>
  </div>
</section>