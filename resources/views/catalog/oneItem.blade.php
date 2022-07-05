<div class="col-xs-12 col-sm-6  col-xs-6 col-md-4 mt-4 mb-2 col-lg-3 position-relative catalog-item text-center">
    <a href="/catalog/{{$item->id}}">
        <div class="catalog-img">
            <img class=" img-fit-100 lazyload"
                 data-src="https://soeasy.moscow/images/content/{{$item->previewNew}}" alt="prev">
            <div class="make-favorite">
                <img class="l-icon lazyload" data-src="/images/heart22.svg">
            </div>
            <?php
            if (!empty($item->tmpImages) && isset($item->tmpImages[0])) :
                ?>

                <img class="hover-img lazyload"
                     data-src="https://soeasy.moscow/images/content/{{$item->tmpImages[0]->image}}"   />
            <?php
            endif;
            ?>
        </div>
        <div class="justify-content-center w-100 d-flex">
            <div class="text-center w-100">
                <div class="desc">
                    {{$item->name}}
                </div>
                <div class="price">
                    {{$item->price}} <i class="rub_icon">₽</i>
                </div>
            </div>
        </div>

    </a>
</div>