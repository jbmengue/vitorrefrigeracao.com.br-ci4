<section class="py-20 text-center">
  <h1 class="mb-20">
    <span class="block" data-aos="fade-down">Marcas Atendidas</span>
    <small class="font-normal block text-xl mt-5" data-aos="fade-up">Credenciadas e Autorizadas</small>
  </h1>

  <?= cached_cell(App\Cells\Brands\HorizontalMotion::class, ['motionDurationInSeconds' => '70', 'motionGroupNumber' => 2], 300) ?>
  <button class="btn-dark mx-auto mt-20" data-aos="zoom-in">
    Ver todas as marcas
  </button>
</section>
