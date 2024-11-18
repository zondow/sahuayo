<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="port filterable-content " style="opacity: 1;">
    <div class="card-columns">
        <?php foreach ($albums as $album) {
            $urlportada = portadaGaleria($album['gal_Nombre']); ?>
            <div class="card filter-item all webdesign illustrator">
                <a href="<?= base_url('Comunicados/verGaleria/' . $album['gal_Galeria']) ?>" class="image-popup">
                    <div class="portfolio-masonry-box">
                        <div class="portfolio-masonry-img">
                            <img src="<?= $urlportada[0] ?>" class="thumb-img img-fluid" alt="work-thumbnail">
                        </div>
                        <div class="portfolio-masonry-detail">
                            <h4 class="font-18"><?= strtoupper($album['gal_Nombre']) ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>