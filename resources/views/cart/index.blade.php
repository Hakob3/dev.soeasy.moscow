@extends('welcome')
@section('content')

    <script>
        let cartIds = [];
        let promoSale = 0;
    </script>

    <div class="container ">
        <div class="d-flex" style="margin-top: 120px">
            <div class=" pb-4" style="width: 750px;" id="contentItems">
                @include('cart.cartItemsList')
            </div>

            <div class="pl-5 pb-4 cartForm" style="width: calc(100% - 750px); margin: 0 0 0 150px" id="cartForm">
                <h5 class="text-center mb-5">ОФОРМЛЕНИЕ ЗАКАЗА</h5>
                <form action="/makeOrder" id="orderSubmitForm" class="row d-flex justify-content-center" method="POST">
                    <div class="leftCol">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="step2name">Имя получателя *</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="step2name"
                                           value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="step2name2">Фамилия получателя *</label>
                                    <input type="text" class="form-control form-control-sm" name="name2" id="step2name2"
                                           value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                <div class="form-group mb-2">
                                    <label for="step2email">Электронная почта *</label>
                                    <input type="text" class="form-control form-control-sm" name="email" id="step2email"
                                           value="">
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="step2phone">Телефон *</label>
                                    <input type="text" placeholder="+{7}(000)000-00-00"
                                           class="form-control-sm form-control bg-mask" name="phone"
                                           id="step2phone" value="+7">
                                </div>
                            </div>
                        </div>


                        <div class="form-group deliveryTypes">
                            <label>Варианты доставки *</label>
                            <ul class="cartText" id="deliveryTypes" style="  margin: 5px 0 0 0;">
                                <li>
                                    <div class="title-parent">
                                        <div class="rad-label">

                                            <div class="flex-parent w-100">
                                                <input type="radio" name="delivery_type" id="deliveryMoscow1"
                                                       value="deliveryMoscow1">
                                                <label class="flex-parent w-100 radio-label" for="deliveryMoscow1">
                                                    <span class="">Доставка по Москве (от 1 дня)</span>
                                                    <div class="title-bar-test" data-toggle="content1">
                                                        <img src="https://soeasy.moscow/images-new/btn-more.png"
                                                             style="height: 10px; margin: 0 0 0 5px;" class="inf-icon"
                                                             alt="info">
                                                    </div>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="checkedBar" id="checkedBar_deliveryMoscow1">
                                        <div>
                                            <div class="flex-warn-inf mb-2">
                                                <div>
                                                    <img src="https://soeasy.moscow/images-new/inf_warn.svg">
                                                </div>
                                                <div>
                                                    <p class="mb-0" style="margin: 0 0 0 10px">
                                                        Курьерская доставка с возможностью примерки и оплаты при
                                                        получении
                                                    </p></div>
                                            </div>
                                            <div class="pay_methods">
                                                <div style="display: block; margin: 0 0 3px; font-size: 13px">Оплата
                                                </div>
                                                <ul class="pay-ul">
                                                    <li><input type="radio" name="mskPayType" id="mskPayTypeCard1"
                                                               value="card" checked="checked">
                                                        <label class="forRadio" for="mskPayTypeCard1">
                                                            Банковской картой сейчас
                                                        </label>
                                                    </li>

                                                    <li>
                                                        <input type="radio" name="mskPayType" id="mskPayTypeCash1"
                                                               value="cash">
                                                        <label class="forRadio" for="mskPayTypeCash1">При получении
                                                            курьеру </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="txt-form">
                                                <label for="step3address">Адрес доставки *</label>
                                                <textarea class="q_text" name="addressMoscow"
                                                          id="step3address"></textarea>
                                            </div>
                                            <div>
                                                <div class="txt-form">
                                                    <label for="commentMoscow">Комментарии</label>
                                                    <textarea class="q_text" name="commentsMoscow" id="commentMoscow"
                                                              placeholder="Например: код домофона, подъезд"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="title-parent">
                                        <div class="rad-label">

                                            <div class="flex-parent w-100">
                                                <input type="radio" name="delivery_type" id="deliveryRussia2"
                                                       value="deliveryRussia2">
                                                <label class="flex-parent w-100 radio-label" for="deliveryRussia2">
                                                    <span class="">Доставка по России  (от 3 дней)</span>
                                                    <div class="title-bar-test" data-toggle="content2">
                                                        <img src="https://soeasy.moscow/images-new/btn-more.png"
                                                             style="height: 10px; margin: 0 0 0 5px;" class="inf-icon"
                                                             alt="info">
                                                    </div>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="checkedBar" id="checkedBar_deliveryRussia2">
                                        <div>
                                            <div class="flex-warn-inf">
                                                <div>
                                                    <img src="https://soeasy.moscow/images-new/inf_warn.svg">
                                                </div>
                                                <div style="margin: 0 0 0 10px">

                                                    Возможность доставки с примеркой отсутствует.
                                                    <br> Отправка осуществляется после оплаты заказа.
                                                </div>
                                            </div>
                                            <div class="pay_methods">
                                                <div style="display: block; margin: 0 0 3px; font-size: 13px">Оплата
                                                </div>
                                                <ul class="pay-ul">
                                                    <li class="d-flex align-center">
                                                        <input type="radio" name="mskPayType" id="mskPayTypeCard2"
                                                               value="card">
                                                        <label class="forRadio" for="mskPayTypeCard2">
                                                            Банковской картой сейчас
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="txt-form">
                                                <label for="step2address">Адрес доставки *</label>
                                                <textarea class="q_text" name="addressRussia"
                                                          id="step2address"></textarea>
                                            </div>
                                            <div>
                                                <div class="txt-form">
                                                    <label for="commentsRussia">Комментарии</label>
                                                    <textarea class="q_text" name="commentsRussia" id="commentsRussia"
                                                              placeholder="Например: код домофона, подъезд"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="title-parent">
                                        <div class="rad-label">

                                            <div class="flex-parent w-100">
                                                <input type="radio" name="delivery_type" id="pickupFromShowroom"
                                                       value="pickupFromShowroom">
                                                <label class="flex-parent w-100 radio-label" for="pickupFromShowroom">
                                                    <span class="">Самовывоз из Шоурума</span>
                                                    <div class="title-bar-test" data-toggle="content3">
                                                        <img src="https://soeasy.moscow/images-new/btn-more.png"
                                                             style="height: 10px; margin: 0 0 0 5px;" class="inf-icon"
                                                             alt="info">
                                                    </div>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="checkedBar" id="checkedBar_pickupFromShowroom">
                                        <div class="flex-warn-inf">
                                            <div>
                                                <img src="https://soeasy.moscow/images-new/inf_warn.svg">
                                            </div>
                                            <div>
                                                <div style="margin: 0 0 0 10px">
                                                    Самовывоз доступен только при заказе новой коллекции.
                                                    <br>Возможность самовывоза для заказов из раздела outlet отсутствует
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pay_methods">
                                            <div style="display: block; margin: 0 0 3px; font-size: 13px">Оплата</div>
                                            <ul class="pay-ul">
                                                <li><input type="radio" name="mskPayType" id="mskPayTypeCard3"
                                                           value="card">
                                                    <label class="forRadio" for="mskPayTypeCard3">
                                                        Банковской картой сейчас
                                                    </label>
                                                </li>

                                                <li>
                                                    <input type="radio" name="mskPayType" id="mskPayTypeCash3"
                                                           value="cash">
                                                    <label class="forRadio" for="mskPayTypeCash3">Оплата в шоу-руме
                                                        наличными/банковской картой</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <div>Самовывоз осуществляется по адресу:</div>
                                            <div>Москва, м. китай город, Хохловский переулок 7-9 стр 5</div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="promocode">Промокод</label>
                                <input type="text"
                                       class="form-control-sm form-control"
                                       name="promocode"
                                       id="promocode"/>
                                <div id="promoMessage"></div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="submit" class="btn w-100 btn-so btn-small"
                                       style="margin-top: 24px" id="orderSubmit" name="submit" value="Оплатить"
                                       rel="Оплатить">
                                <small>Нажимая накнопку «оплатить», я принимаю условия публичной оферты
                                    иполитики конфиденциальности</small>
                            </div>
                        </div>

                    </div>
                </form>


            </div>
        </div>

        <div class="toSlide mt-4">
            <ul>
                <li><a href="javascript:" onclick="showPopup('/info/');">Условия доставки</a></li>
                <li><a href="javascript:" onclick="showPopup('/info/');">Условия обмена и
                        возврата</a></li>
                <li><a href="javascript:" onclick="showPopup('/info/');">Публичная оферта</a></li>
                <li><a href="javascript:" onclick="showPopup('/info/');">Политика
                        конфиденциальности</a></li>
            </ul>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('input[name="delivery_type"]').on('click', function () {
            $('.checkedBar').hide();
            let _elem = '#checkedBar_' + $('input[name="delivery_type"]:checked').val();
            $(_elem).slideDown()
        });
        $(document).on('change', '.change-quantity', function () {
            let dataSend = {
                catalogId: $(this).data('catalogid'),
                sizeId: $(this).data('sizeid'),
                count: $(this).val()
            }
            changeCounts(dataSend)
        })

        $('#promocode').on('change', function () {

            $('#promoMessage').html('')
            let _email = $('#step2email').val();
            if (_email.length > 0) {
                promoAccept()
            } else {
                $('#promoMessage').html('<p>Пожалуйста, заполните адрес электронной почты</p>')
            }

        }).on('input', function () {
            if ($(this).val().length > 5) {
                let _email = $('#step2email').val();
                if (_email.length > 0) {
                    promoAccept()
                } else {
                    $('#promoMessage').html('<p>Пожалуйста, заполните адрес электронной почты</p>')
                }
            }

            $('#promoMessage').html('')

        })
        var phoneMask = IMask(
            document.getElementById('step2phone'), {
                mask: '+{7}(000)000-00-00'
            });

        $($('#step2email')).on('change', function () {
            $('#promoMessage').html('')
            let _code = $('#promocode').val();
            if (_code.length > 0) {
                promoAccept()
            }
        })

        $('#orderSubmitForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            let form = $(this);
            let url = form.attr('action');
            formData.append('tmpCartSizes', tmpCartSizes);
            formData.append('tmpCartCatIds', tmpCartCatIds);
            formData.append('tmpCartQuantities', tmpCartQuantities);
            $.ajax({
                url: url,
                method: "POST",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === true) {
                        $('#subcategory-modal-form').modal('hide');
                        $(`.get-subcategories[data-id=${response.category_id}]`).trigger('click');
                    }
                }
            })

        })


        let usedPromoCode = '';

        function promoAccept() {
            $.ajax({
                type: "POST",
                data: {
                    code: $('#promocode').val(),
                    cardIds: cardIds,
                    // csrfSession: $('meta[name="csrf-session-key"]').attr('content'),
                    email: $('#step2email').val(),
                },
                url: '/promoCheck',
                success: function (resp) {
                    $('#promoCode').find('.btn-simple').addClass('btn-success');
                    setTimeout(function () {
                        $('#promoCode').find('.btn-simtotalSumple').removeClass('btn-success');
                    }, 200);

                    if (resp.error !== undefined) {
                        $('#promoMessage').html(`<div class="error-message">${resp.error}</div>`);
                    } else {
                        if (resp.promo !== undefined) {
                            if (resp.promo.isPersonal !== undefined) {
                                usedPromoCode = resp.promo.percent;
                                $('#promoMessage').html(`<div class="success-message">${resp.promo.success}</div>`);
                                $('#contentItems').html(resp.promo.templates);
                            } else {
                                $('#promoCode').find('input[name="code"]').attr('disabled', 'disabled').attr('readonly', 'true');
                                $('#promoCode').find('.btn-simple').attr('disabled', 'disabled').attr('readonly', 'true');
                            }
                        } else {
                            $.notify('Something went wrong')
                        }
                    }
                }
            })
        }

        $(document).on('click', '.cartRemoveCommerce', function () {
            let dataSend = {
                catalogId: $(this).data('catalogid'),
                sizeId: $(this).data('sizeid'),
                count: 0
            }
            changeCounts(dataSend)
        })


        $(document).on('click', '.min-count', function () {
            let y = $(this).data('count');
            let elem = $('.change-quantity[data-toggle="' + y + '"]');
            let cur_value = parseInt(elem.val());
            elem.val(cur_value - 1).trigger('change')
        })

        $(document).on('click', '.plus-count', function () {
            let y = $(this).data('count');
            let elem = $('.change-quantity[data-toggle="' + y + '"]');
            let cur_value = parseInt(elem.val());
            elem.val(cur_value + 1).trigger('change')
        })

        function changeCounts(dataSend) {
            $.ajax({
                url: '/changeQuantity',
                method: 'POST',
                type: 'POST',
                data: dataSend,
                success: function (data) {
                    if (data) {
                        $('#contentItems').html(data)
                    }
                }
            })
        }

    </script>
@endsection