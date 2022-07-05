<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>soeasy.moscow</title>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <meta name="csrf-session-key" content="<?= $menuItems['csrfSessionKey']; ?>">
    <link rel="shortcut icon" href="https://soeasy.moscow/images-new/logo_s_2.png" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/animate.css"/>
    <link rel="stylesheet" href="/css/swiper-bundle.min.css"/>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <script src="/js/lazyload.js"></script>
    <script src="/js/swiper-bundle.min.js"></script>

    <link href="/jQueryFormStyler-master/dist/jquery.formstyler.css" rel="stylesheet"/>
    <link href="/jQueryFormStyler-master/dist/jquery.formstyler.theme.css" rel="stylesheet"/>
    <script src="/jQueryFormStyler-master/dist/jquery.formstyler.min.js"></script>
    <link rel="stylesheet" href="/css/styles.css?sv=<?= rand(1, 8888)?>"/>
@yield('secondaryCss')
@stack('stylesheets')
<!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '477343275997490');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=477343275997490&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143056817-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-143056817-1');
    </script>
</head>


<body>
<div class="wrapper">
    <header class="sticky-top bg-white">
        <div class="mob-header menu-logo">
            <a class="nav-link active logo-a" href="/">
                <img src="https://soeasy.moscow/images-new/logo.svg" alt="logo"/>
            </a>
            <div class="mob-menu-burger" id="mob-menu-burger" >
            </div>
        </div>
        <div class="d-flex align-center justify-content-between align-center nav-h">
            <nav class="menu-nav-m">
                <ul class="nav">
                    <li class="nav-item logo-desktop">
                        <a class="nav-link active logo-a" href="/">
                            <img src="https://soeasy.moscow/images-new/logo.svg" alt="logo"/>
                        </a>
                        <div class="mob-menu-burger">
                            <img src="/images/free-icon-menu-633647.svg" class="mn-b-icon"/>
                        </div>
                    </li>
                    <li class="nav-item m-li has-children">
                        <a class="nav-link " >
                            Каталог
                        </a>
                        <ul class="child-ul">
                            @foreach ($menuItems['rubrics']  as $k => $rubric)
                                <li>
                                    <a href="/catalog#{{$rubric->uri}}"> {{$rubric->name}} </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item m-li">
                        <a class="nav-link b-bottom " href="/#about">
                            О бренде
                        </a>
                    </li>
                    <li class="nav-item  has-children m-li">
                        <a class="nav-link">
                            LookBook
                        </a>
                        @if(!empty($menuItems) && isset($menuItems['lookBook']))
                            <ul class="child-ul">
                                @foreach($menuItems['lookBook'] as $k => $lookbook)
                                    <li>
                                        <a href="/lookBook#{{$lookbook->uri}}"> <?=$lookbook->name?> </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>

                    <li class="nav-item m-li">
                        <a class="nav-link  b-bottom" href="/address">
                            Места продаж
                        </a>
                    </li>
                    <li class="nav-item b-bottom m-li">
                        <a class="nav-link b-bottom" href="/contacts">
                            Контакты
                        </a>
                    </li>
                </ul>
            </nav>
            <nav class="b-3">
                <ul class="r-ul nav">
                    <li>
                        <div class="search-bar">
                            <input class="s-input" id="search-item" placeholder="Поиск товар..."/>
                            <img class="s-icon" src="/images/search.svg"/>
                        </div>
                    </li>
                    <li>
                        <div class="like-bar heart-ic">
                            <img class="l-icon" src="/images/heart.svg"/>
                            <span class="p-ic">
                                <span class="p-val" id="likedCount">0</span>
                            </span>
                        </div>
                    </li>
                    <li>
                        <a href="/cart">
                            <div class="like-bar bag-ic">
                                <img class="l-icon" src="/images/shopping-bag.svg"/>
                                <span class="p-ic">
                                <span class="p-val" id="cartCount"><?= $menuItems['cartItemsCount'] ?></span>
                            </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    @yield('content')


</div>
<footer id="footer">

    <div class="container">
        <div class="footer-bottom d-flex mb-5">

            <div class="col-xs-12 col-sm-12 col-md-3">
                <img src="https://soeasy.moscow/images/logo.png" alt="f-logo" class="f-logo">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <ul id="footerMenu" class="u-dis w-100 mt-5 p-0 d-flex list-style-none text-white">
                    <li><a class=" h-underline d-block text-white" href="/#about">О бренде</a></li>
                    <li><a class=" h-underline d-block text-white" href="/privacyPolicy">Пол. конфиденциальности </a>
                    </li>
                    <li><a class=" h-underline d-block text-white" href="/address"> Места продаж</a></li>
                    <li><a class=" h-underline d-block text-white" href="/shipping">Доставка и возврат</a></li>
                    <li><a class=" h-underline d-block text-white" href="/contacts">Контакты</a></li>
                </ul>
            </div>

        </div>
        <div class="footer-top d-flex w-100 mb-5">
            <form id="subscribe" class="w-75">
                <div class="form">
                    <p class="hdr text-so">Подписаться на закрытые распродажи</p>
                    <div class="subscribe-bar input-group">
                        <input type="text" class="email-field form-control" name="email"
                               rel="введите адрес электронной почты">
                        <input type="submit" class="submit-btn btn btn-so" name="submit" value="Подписаться">
                    </div>

                </div>

                <p class="success d-none">

                    Спасибо за подписку!<br>
                    Пожалуйста, проверьте свой почтовый ящик, мы&nbsp;отправили туда письмо с&nbsp;промокодом на&nbsp;скидку.
                </p>
                <div id="errorMessage1238423984"></div>
            </form>
            <div class="pl-3">
                <p class="text-white">Присоединяйтесь к нам</p>
                <ul id="footerSocialMenu" class="p-0 w-25 d-flex list-style-none">
                    <li class="pr-2">
                        <a href="https://www.facebook.com/soeasy.moscow/" class="so-social" target="_blank">
                            <img
                                    src="https://soeasy.moscow/images-new/icon-facebook.svg"
                                    alt="facebook"></a>
                    </li>
                    <li class="pr-2">
                        <a href="https://instagram.com/soeasy_moscow/"
                           class="so-social"
                           target="_blank">
                            <img
                                    src="https://soeasy.moscow/images-new/icon-instagram.svg"
                                    alt="instagram"></a>
                    </li>
                </ul>

            </div>

        </div>
        <p id="legal" class="text-white text-center">© <?=date('Y')?>. Все права защищены.</p>

    </div>

</footer>
</body>


<script src="/js/main.js?c=<?=rand(1, 6855)?>"></script>
@yield('scripts')

<div class="alert alert-danger alertMessage" role="alert" id="alertDanger" style="display:none;">
</div>
</html>
