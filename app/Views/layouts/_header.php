<header>
    <div class="w-full bg-black py-3 text-center uppercase text-primary overflow-hidden">
        <span class="block" data-aos="fade-up" data-aos-delay="500">Atendimento online <strong>24h/7</strong> dias por semana</span>
    </div>
    <div class="layout-container wide flex justify-between items-center py-10 gap-x-5">
        <div class="w-2/12">
            <?php layout_snippet('brand', ['class' => 'max-w-[175px]']) ?>
        </div>
        <div class="w-1/12 xl:w-8/12 order-2 xl:order-1">
            <?php component("navbar", ['navbarSubmenuClass' => 'hidden'], 'navigation/primary'); ?>
        </div>
        <div class="hidden order-1 md:w-9/12 xl:order-2 xl:w-2/12 sm:block">
            <button class="btn-secondary btn-sm float-end">
                Seja atendido agora
            </button>
        </div>
    </div>
</header>