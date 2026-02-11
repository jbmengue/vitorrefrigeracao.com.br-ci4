<div id="navbarOffcanvas" class="fixed bg-white z-50 p-10 h-screen top-0 transform transition-transform duration-800 ease-[cubic-bezier(0.68,-0.55,0.27,1.55)] max-sm:w-screen max-xl:w-1/2 max-xl:right-0 max-xl:translate-x-full xl:bg-none xl:relative xl:p-0 xl:h-auto">
  <div class="navbar-wrapper">
    <div class="xl:mb-15 px-15 mb-10 xl:hidden">
      <?php layout_snippet('brand', ['class' => 'mx-auto block']) ?>
    </div>
    <nav>
      <ul class="xl:flex  justify-between">
        <?= component("items", ['useShortLabel' => true, 'except' => ['commercial-refrigeration-gastronomy-equipment', 'gondolas', 'vrf', 'tailor-made-commercial-projects', 'equipment-rental']], 'navigation') ?>
      </ul>
    </nav>
  </div>
</div>
<button id="navbarOffcanvasToggle" class="xl:hidden float-end">
  <span class="block w-12 h-[2px] rounded-xl bg-black/75"></span>
  <span class="block w-12 h-[2px] rounded-xl bg-black/75 my-2"></span>
  <span class="block w-12 h-[2px] rounded-xl bg-black/75"></span>
</button>