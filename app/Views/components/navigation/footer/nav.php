<div class="layout-container wide">
  <nav class="flex flex-col lg:flex-row justify-between">
    <ul class="text-center lg:text-start">
      <?php component("items", ['only' => ['technical-assistance', 'contracts', 'installations', 'cleaning'], 'order' => ['technical-assistance', 'contracts'], 'navItemClass' => 'mb-5', 'navLinkClass' => 'font-bold'], 'navigation') ?>
    </ul>
    <ul class="text-center lg:text-start">
      <?php component("items", ['only' => ['authorized'], 'navItemClass' => 'mb-5', 'navLinkClass' => 'font-bold'], 'navigation') ?>
    </ul>
    <ul class="text-center lg:text-start">
      <?php component("items", ['only' => ['gas-heaters', 'commercial-refrigeration-gastronomy-equipment', 'vrf', 'tailor-made-commercial-projects', 'equipment-rental-air-quality'], 'navItemClass' => 'mb-5', 'navLinkClass' => 'font-bold'], 'navigation') ?>
      <li>
        <strong>Siga-nos nas redes</strong>
        <div class="flex justify-center lg:justify-start gap-x-3 mt-5">
          <a href="<?= $appConfig->instagram ?>" target="_blank">
            <img alt="<?= $appConfig->name ?>: Instagram" title="" src="<?= assets('images', 'svg/social-networks/instagram.svg') ?>" width="55" height="55" />
          </a>
          <a href="<?= $appConfig->facebook ?>" target="_blank">
            <img alt="<?= $appConfig->name ?>: Facebook" title="" src="<?= assets('images', 'svg/social-networks/facebook.svg') ?>" width="55" height="55" />
          </a>
        </div>
      </li>
    </ul>
  </nav>
</div>
