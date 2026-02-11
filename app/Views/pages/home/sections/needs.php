<section class="bg-[#f6f8fc] py-20 bg-center bg-no-repeat" style="background-image: url('<?= assets('images', 'bg/04.png') ?>');">
  <div class="layout-container text-center">
    <div class="mb-15">
      <h1 class="mb-5" data-aos="fade-up">O que você precisa hoje?</h1>
      <p class="text-2xl font-light">Temos a solução e o atendimento sob medida para a sua necessidade.</p>
    </div>
    <div class="flex flex-wrap justify-around items-center gap-y-5">
      <div data-aos="zoom-in" class="w-full md:w-[350px]">
        <a href="<?= $appConfig->openTicketLink ?>"  target="_blank" rel="noopener noreferrer" class="block btn-tertiary btn-lg ">Abrir um chamado</a>
      </div>
      <div data-aos="zoom-in" data-aos-delay="300" class="w-full md:w-[350px]">
        <a href="<?= $appConfig->openSalesOrdersLink ?>" target="_blank" rel="noopener noreferrer" class="block btn-tertiary btn-lg w-full">Ordem de vendas</a>
      </div>
      <div data-aos="zoom-in"  data-aos-delay="600" class="w-full md:w-[350px]">
        <a href="<?= $appConfig->openQuotesLink ?>" target="_blank" rel="noopener noreferrer" class="block btn-tertiary btn-lg w-full">Orçamentos</a>
      </div>
    </div>
  </div>
</section>