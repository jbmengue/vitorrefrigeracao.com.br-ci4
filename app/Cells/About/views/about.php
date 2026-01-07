<div class="flex flex-col lg:flex-row gap-y-10 justify-between">
  <div class="lg:w-5/12">
    <h1 class="normal-case text-center md:text-start" data-aos="fade-down">Mais de 40 anos de história</h1>
    <div class="text-justify text-lg" data-aos="zoom-in" data-aos-delay="500">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
    </div>
  </div>
  <div class="lg:w-5/12">
    <ul>
      <?php 
      foreach ($highlights as $key => $highlight): ?>
        <li class="flex gap-x-10 mb-10" data-aos="fade-down" data-aos-delay="<?= ($key + 1) * 200 ?>">
          <span>
            <i class="flaticon-<?= $highlight->icon ?> before:text-primary before:text-7xl"></i>
          </span>
          <span>
            <h3 class="mb-2"><?= $highlight->title ?></h3>
            <?php 
              foreach ($highlight->text as $text): ?>
              <p class="m-0"><?= $text ?></p>
            <?php endforeach ?>
          </span>
        </li>

      <?php endforeach?>
    </ul>
  </div>
</div>