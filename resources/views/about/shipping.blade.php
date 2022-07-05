@extends('welcome')
@section('content')
<div class="container">
    <div class="shipping-returns">
        <ul class="ul-shipping-returns">
            <li class="active">
                <a href="/shipping"> ДОСТАВКА </a>
            </li>
            <li>
                <a href="/returns"> ВОЗВРАТ </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="shipping-content">
                <h3>Мы стараемся доставить ваш заказ в кротчайшие сроки.</h3>
                <p> Получить свой заказ, вы можете следующим образом:</p>
                <ul class="types-del">
                    <li class="tab-toggle" data-content="t1">Доставка по Москве с примеркой</li>
                    <li class="tab-toggle" data-content="t2">Доставка по России и МО</li>
                    <li class="tab-toggle" data-content="t3">Самовывоз из шоу-рума</li>
                </ul>
                <div class="tabs">
                    <div class="type-item" data-content="t1">
                        <h5>Доставка по Москве</h5>
                        <ul class="ul-c">
                            <li> Доставку с примеркой осуществляется на территории Москвы, в пределах МКАД</li>
                            <li> Стоимость услуги — 350 рублей, если вы выкупаете заказ на сумму до 5 000 рублей. При
                                сумме выкупа от 5 000 рублей доставка с примеркой БЕСПЛАТНА.
                            </li>
                            <li> Возможна доставка с примеркой за Мкад (в зависимости от удаленности и транспортной
                                доступности) Стоимость доставки от 500 рублей.
                                <br><br></li>

                            <li>Курьеры привезут ваш заказ в течении 1 - 3-х дней</li>
                            <li>Время на примерку одного заказа — 15 минут</li>
                            <li>Максимальное количество вещей в одном заказе: 5 (но не более 2 пальто)</li>
                            <li>При полном отказе доставка оплачивается Покупателем</li>
                            <li>Оплата курьеру производится наличными</li>
                        </ul>


                    </div>
                    <div class="type-item" data-content="t2">
                        <h5> Московская область и другие регионы России </h5>
                        <ul class="ul-c">
                            <li> Заказ доставляется без возможности примерки.</li>
                            <li> Доставка осуществляется транспортной компанией СДЭК после 100% предоплаты, путем
                                оформления заказа на сайте.
                            </li>
                            <li> Сроки и стоимость доставки рассчитываются индивидуально в зависимости от удаленности
                                города.
                                Расчет
                                осуществляет менеджер интернет-магазина при подтверждении заказа посредством звонка или
                                сообщения.
                            </li>
                        </ul>
                    </div>
                    <div class="type-item" data-content="t3">
                        <h5> Самовывоз </h5>
                        <ul class="ul-c">
                            <li>Самовывоз осуществляется в шоу-руме М. Китай-город, Хохловский переулок 7-9, стр. 5.
                            </li>
                            <li>Режим работы: ежедневно 12.00 - 22.00.</li>
                            <li>Возможные способы оплаты: наличными/банковской картой</li>
                            <li>Неоплаченные заказы резервируются на сутки</li>
                        </ul>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.tab-toggle').on('click', function () {
                let data_content = $(this).data('content');
                $('.type-item').removeClass('show');
                $('.type-item[data-content="' + data_content + '"]').addClass('show');
            })
        })
    </script>
@endsection