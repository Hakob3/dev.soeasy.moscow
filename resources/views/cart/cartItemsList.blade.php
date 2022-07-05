<table class="cart_items_ul table">


    @if(empty($cartItems))
        <h5 class="text-center">ВАША КОРЗИНА ПУСТА</h5>
        <p>ДОБАВЬТЕ СВОЙ ПЕРВЫЙ ТОВАР</p>
    @else
        <h5 class="text-center mb-5">ВАША КОРЗИНА </h5>
        <script>
            cardIds = [];
            promoSale = 0;
            tmpCartSizes = [];
            tmpCartCatIds = [];
            tmpCartQuantities = [];
        </script>

        <?php
        $totalPrice = 0;
        $promo_percent = 0;


        if (isset($csrfSession, $csrf_session_promo_value)) {
            $promo_percent = intval($csrf_session_promo_value);
        }

        ?>
        @foreach($cartItems as $key => $val)
            <script>
                cardIds.push(<?=$val->catalogItem->id?>);
                tmpCartSizes.push(<?=$val->sizeValue->id?>);
                tmpCartCatIds.push(<?=$val->catalogItem->id?>);
                tmpCartQuantities.push(<?=$val->quantity?>);
            </script>
            <?php
            $itPriceFrom = intval($val->quantity) * intval($val->catalogItem->price);
            $itPriceTo = $itPriceFrom - ($promo_percent * $itPriceFrom / 100);
            $itPrice = $itPriceTo;
            $totalPrice += $itPrice;
            ?>
            <tr class="cart_item_li">
                <td class="pic">

                    <img class="p-td-cart"
                         src="https://soeasy.moscow/images/content/<?=$val->catalogItem->previewNew?>"/>
                </td>
                <td class="name">
                    <div> <?=$val->catalogItem->name?></div>
                    <div>РАЗМЕР:<strong class="uppercase"> <?=$val->sizeValue->name?></strong></div>
                    <div>ART:<strong> <?=$val->catalogItem->name?></strong></div>

                    <div class="quantity" style="margin-top: 10px">
                        <div>количество</div>
                        <div class="q-block">
                            <div class="min-count" data-count="<?=$key?>">-</div>
                            <input type="number" class="change-quantity"
                                   data-catalogid="<?=$val->catalog_id?>"
                                   data-sizeid="<?=$val->sizeValue->id?>"
                                   data-toggle="<?=$key?>"
                                   value="<?=$val->quantity?>"/>
                            <div class="plus-count" data-count="<?=$key?>">+</div>
                        </div>
                    </div>
                </td>
                <td class="price-td">
                    <div>цена</div>
                    <?php
                    if($itPriceFrom !== $itPriceTo) {
                    ?>
                    <div class="old-price"> <small class="text-danger del"><del> <?= number_format($itPriceFrom, 0, ',', ' ')?>
                                <i class="rub_icon">₽</i> </del> </small></div>
                    <?php
                    }
                    ?>
                    <div class="price"> <?= number_format($itPrice, 0, ',', ' ')?> <i class="rub_icon">₽</i></div>
                </td>
                <td class="del">
                    <div data-id="1795" data-size="1" class="cartRemoveCommerce cursor-pointer"
                         data-catalogid="<?=$val->catalog_id?>"
                         data-sizeid="<?=$val->sizeValue->id?>">
                        <img style="width: 10px;" src="https://soeasy.moscow/images-new/btn-remove.svg" alt="x">
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="100%">
                <h4 class="text-center">
                    Итого: <?= number_format($totalPrice, 0, ',', ' ')?> <i class="rub_icon">₽</i>
                </h4>
            </td>
        </tr>
    @endif


</table>

