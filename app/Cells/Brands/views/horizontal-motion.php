<div class="horizontal-motion bg-white py-1 text-xl text-primary font-bold" style="--motion-duration: <?= $motionDurationInSeconds ?>s;">
  <div class="track">
    <?php
    for ($group = 0; $group < $motionGroupNumber; $group++): ?>
      <div class="flex gap-x-25 pr-50 items-center" <?= $group > 0 ? 'aria-hidden="true"' : '' ?>>
        <?php
        foreach ($brands as $key => $brand):
          $alt = esc($brand->relationshipLabel() . ': ' . $brand->title);
        ?>
          <div class="item">
            <img alt="<?= $alt ?>" title="<?= $alt ?>" src="<?= esc(assets('images', "logos/{$brand->name}/colorful.png")) ?>" loading="lazy" class="max-w-[250px] max-h-[200px]" />
          </div>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>
</div>