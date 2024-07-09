<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="port filterable-content" style="opacity: 1;">
    <div class="card-columns">
        <?php
        $urls = verGaleriaFotos($album);
        foreach($urls as $url){
                echo '<div class="card filter-item all webdesign illustrator" style="">
                        <a href="'.$url.'" data-lightbox="roadtrip" class="image-popup">
                            <div class="portfolio-masonry-box">
                                <div class="portfolio-masonry-img">
                                    <img src="'.$url.'" class="thumb-img img-fluid" alt="work-thumbnail">
                                </div>
                            </div>
                        </a>
                    </div>';
        }?>
    </div> <!-- End row -->
</div>