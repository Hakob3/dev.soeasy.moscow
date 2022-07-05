@extends('welcome')
@section('content')


    <?php
    $modifications = $catalog_item->modifications;
    $materials = explode(',', $catalog_item->material);
    $care = explode(',', $catalog_item->care);
    $materialsStr = implode('<br>', $materials);
    $careStr = implode('<br>', $care);

    function checkAvailabilityStores($modifications)
    {
        $innerBody = '';
        $checkIcon = '<img src="https://soeasy.moscow/images-new/tick.svg" style="height:14px "/>';


        $avi = 0;
        $xox = 0;
        foreach ($modifications as $key => $val) {
            $avi += intval($val->stockAvi);
            $xox += intval($val->stockXox);

            if (intval($val->stockAvi) + intval($val->stockXox) > 0) {
                $innerBody .= '<tr>
<td>' . $val->size . '</td>
<td>' . (intval($val->stockAvi) > 0 ? $checkIcon : '') . '</td>
<td>' . (intval($val->stockXox) > 0 ? $checkIcon : '') . '</td>
</tr>';
            }
        }


        if ($innerBody !== '') {
            $checkBlock = '<table class="leftCountTable table">
<thead><th></th><th>Авиапарк</th><th>Шоурум</th></thead><tbody>' . $innerBody . '</tbody></table>';
        } else {
            $checkBlock = '';
        }

        return $checkBlock;
    }


    function colorsBlock($colors)
    {
//        var_dump($colors); die;
        if (count($colors) > 0) {
            $res = '<div class="colorsBlock">
                <div>Другие цвета</div>
                <ul class="colors-ul">';
            foreach ($colors as $key => $val) {
                if ($val->image !== '') {
                    $c = '<span  class="img-b"><img src="https://soeasy.moscow/images/content/' . $val->image . '"></span>';
                } else {
                    $c = '<span  class="clr-b" style="background: #' . $val->color . '"></span>';
                }
                $res .= '<li><a href="/catalog/' . $key . '">' . $c . '</a></li>';
            }
            $res .= '</ul> </div>';
        } else {
            $res = '';
        }
        return $res;
    }
    function sizesBlock($sizes)
    {
        $res = '';
        if (count($sizes) > 0) {
            $res = '<div class="sizesBlock">

                <select class="so-select" id="sizesSelect">
<option value="0">Выбрите размер</option>';

            foreach ($sizes as $key => $val) {
                $res .= '<option value="' . $val->id . '">' . strtoupper($val->name) . '</option>';
            }
            $res .= '</select> </div>';
        } else {
            $res = '';
        }
        return $res;
    }



    $tmpIsNew = '';
    $soTumbs = '';
    $swiperSlide = '';


    if (isset($catalog_item->tmpImages)) {
        foreach ($catalog_item->tmpImages as $v) {

            if ($v) {
                $swiperSlide .= ' <div class="swiper-slide">
                                         <div class="img-block">
                    <div class="forPhoto" id="' . $v['id'] . '">
                                             <a name="' . $v['id'] . '"></a>
                                             <img class="photo-slide"  src="https://soeasy.moscow/images/content/' . $v['image'] . '"> </div></div>
                                         </div>';
                $soTumbs .= '<div class="swiper-slide">
                                    <img class="photo" href="javascript:"  src="https://soeasy.moscow/images/content/' . $v['image'] . '" alt="" />
                                    </div>';
            }
        }
    }


    ?>

    <div class="d-flex align-center justify-content-center">
        <div class="cartItem">
            <div class="leftCol">
                <div class="slider-relative">
                    <div class="tumbs">
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <?= $soTumbs ?>
                            </div>
                        </div>
                    </div>
                    <div class="soeasy-slide swiper-container">
                        <div class="swiper-wrapper">
                            <?= $swiperSlide ?>
                        </div>
                        <div class="swiper-button-next">
                            <img class="n-p-btn" src="/images-new/arrow-inst-right.png" alt=">"/>
                        </div>
                        <div class="swiper-button-prev">
                            <img class="n-p-btn" src="/images-new/arrow-inst-left.png" alt="<"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightCol">
                <p class="p-name"> {{$catalog_item->name}} </p>
                <p class="p-price"> {{number_format(($catalog_item->price), 0, ',', ' ')}} <i class="fa fa-rub"
                                                                                              aria-hidden="true"></i>
                </p>
                <p class="p-article">АРТ:{{$catalog_item->article}}</p>

                <?php
                echo colorsBlock($catalog_item->otherColorsByCatalogIds());
                echo sizesBlock($catalog_item->modificationSizes($modifications));
                ?>
                <div class="cart-wishlist d-flex">
                    <div id="add-cart" class="add-cart" data-id="{{$catalog_item->id}}">
                        <span>в корзину</span>
                        <img class="l-icon" src="/images/add.svg">
                    </div>
                    <div class="add-wishlist" id="add-wishlist" data-id="{{$catalog_item->id}}">
                        <span> ДОБАВИТЬ В WISHLIST </span>
                        <img class="l-icon" style="width: 18px;" src="/images/heart.svg">
                    </div>
                </div>

                <div class="toggle-bar">
                    <div class="toggle-header">
                        <span>
                            Гид по размерам
                            <img src="https://soeasy.moscow/images-new/info.svg"
                                 style="height: 10px; margin: 0 0 0 5px;" class="inf-icon"
                                 alt="info">
                        </span>
                    </div>
                    <div class="toggle-body">
                        <div class="more-inf-gid">
                            <ul>
                                <li class="label">
                                    <p class="title-bar">
                                        <img src="https://soeasy.moscow/images-new/info.svg" style="height: 11px;"
                                             class="inf-icon cursor-pointer" alt="info" data-hover="sizeSet"/>
                                        Размерная сетка
                                    </p>
                                    <div class="moreInfSizes sizeSet target-block" style="display: none"
                                         data-target="sizeSet">
                                        <p>При выборе размера обратите внимание на размерную сетку, размеры разных
                                            брендов
                                            одежды могут отличаться.</p>
                                        <p>Советуем делать выбор, исходя из ваших параметров.</p>

                                        <p>Для правильного выбора размера снимите мерки, следуя инструкции, изложенной
                                            ниже.</p>
                                        <p><strong>ОГ</strong> Обхват груди - измеряется вокруг туловища по самым
                                            выступающим точкам грудных желез.</p>
                                        <p><strong>ОТ</strong> Обхват талии - измеряется вокруг туловища на уровне линии
                                            талии.</p>
                                        <p><strong>ОБ</strong> Обхват бедер - измеряется вокруг бедер по самой
                                            выступающей
                                            области ягодиц.</p>
                                    </div>
                                    <?= $structure->text?>
                                </li>
                                <li class="label">
                                    <p class="title-bar">
                                        <img src="https://soeasy.moscow/images-new/info.svg" style="height: 11px;"
                                             class="inf-icon cursor-pointer" data-hover="measurements" alt="info"/>Обмеры
                                        изделия
                                    </p>
                                    <div class="target-block measurements" style="display: none"
                                         data-target="measurements">
                                        Обмеры изделия — параметры готового изделия, которые указаны для того чтобы вы
                                        смогли самостоятельно определить нужную степень облегания, длины подола или
                                        деталей
                                        (рукава, спинка и пр).

                                    </div>
                                    <?=$mTable?>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="toggle-bar">
                    <div class="toggle-header">
                        <span>
                           состав и уход
                            <img src="https://soeasy.moscow/images-new/info.svg"
                                 style="height: 10px; margin: 0 0 0 5px;" class="inf-icon"
                                 alt="info">
                        </span>
                    </div>
                    <div class="toggle-body">
                        <div class="more-inf-gid">
                            <?=$materialsStr?>
                            @if($careStr !== '')
                                <h5 class="mt-4">РЕКОМЕНДАЦИИ ПО УХОДУ </h5>
                                <p><?=$careStr?> </p>
                            @endif
                        </div>
                    </div>
                </div>
                <?php
                $r = checkAvailabilityStores($modifications);
                if($r) :
                ?>
                <div class="toggle-bar">
                    <div class="toggle-header">
                        <span>
                        проверить наличие в магазинах
                        </span>
                    </div>
                    <div class="toggle-body">
                        <div class="more-inf-gid">
                            <?=$r?>
                        </div>
                    </div>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>

    @if($catalog_item->alsoIds !== '')
        <div class="d-flex align-center justify-content-center mob-wrap">
            <?php $items = $catalog_item->alsoBar(explode(',', $catalog_item->alsoIds));
            foreach ($items as $k => $item): ?>
            @include('catalog.oneItem')
            <?php endforeach;  ?>
        </div>
    @endif
    <div class="zoomImg" id="zoomImgParent">
        <img id="imageForZoom" class="zoomOut" src=""/>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="checkoutModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 class="text-center mt-3 mb-3">СПАСИБО!</h3>
                    <p>Товар успешно добавлен в корзину!</p>
                    <div> <a href="/cart" class="btn btn-so">Оформить заказ</a></div>
                    <p class="close btn btn-default" data-dismiss="modal" aria-label="Close">продолжить покупки</p>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/catalog.js?v=<?=rand(1, 239329)?>"></script>
@endsection