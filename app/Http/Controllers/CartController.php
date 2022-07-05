<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use App\Models\CartItems;
use App\Models\Catalog;
use App\Models\PromoCodes;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use DB;
use function Tinify\validate;

class CartController extends Controller
{
    public function index()
    {
//        DB::enableQueryLog();

        $cartItems = $this->getCartItems();

        $session = new Session();
        $this->csrfSessionKey = 'a_' . time() . rand(1, 5656);
        $session->set('csrf_session_promo_value', '0');
        $session->set('csrfSession', $this->csrfSessionKey);
        $s = new Session();

        $csrf_session_promo_value = $s->get('csrf_session_promo_value', '0');
        $csrfSession = $s->get('csrfSession', '0');

        $menuItems = $this->menuItems;
        return view('cart.index', compact('cartItems', 'menuItems', 'csrfSession', 'csrf_session_promo_value'));
    }

    public function promoCheck(Request $request)
    {
        $code = $request->input('code');
        $cardIds = $request->input('cardIds');
        $email = $request->input('email');


        $res = [];

        if (is_string($code) && !empty(trim($code))) {
            $catalogIds = [];
            if (!empty($cardIds)) {
                $catalogIds = Catalog::select('rubricId', 'id')
                    ->whereIn('id', $cardIds)
                    ->get();
            }


            if (count($catalogIds) > 0) {
                $promoItems = [];
                $prm = PromoCodes::whereRaw('LOWER(`code`) LIKE ? ', [trim(strtolower($code)) . '%'])
                    ->get();

                if (count($prm) === 0) {


                    $prm = Subscribers::whereRaw('LOWER(`promocode`) LIKE ? ', [trim(strtolower($code)) . '%'])
                        ->get();


                    if (count($prm) > 0) {
                        if (!empty($email)) {
                            if (strtolower(trim($email)) === strtolower(trim($email))) {
                                $csrf_session_promo_value = 10;
                                $res['promo']['isPersonal'] = 'true';
                                $res['promo']['success'] = "Поздравляем, вы успешно использовали свой персональный промокод с " . $csrf_session_promo_value . " процентами";

                                $session = new Session();


                                $session->set('csrf_session_promo_value', $csrf_session_promo_value);
                                $session->set('csrf_session_promo_value_personal', trim(strtolower($code)));
                                $csrfSession = $session->get('csrfSession', '-');

                                $cartItems = $this->getCartItems();

                                $res['promo']['templates'] = view('cart.cartItemsList', compact('cartItems',
                                    'csrf_session_promo_value',
                                    'csrfSession'
                                ))->render();


                            } else {
                                $res['error'] = '<div>Промокод не для ' . strtolower(trim($email)) . '. Проверьте адрес электронной почты.</div>';
                            }
                        } else {
                            $res['error'] = '<div>Пожалуйста, заполните адрес электронной почты, на который вы получили персональный промокод.                                    </div>';
                        }

                    } else {
                        $res['error'] = 'Промокод не найден';
                    }
                } else {
                    $forRubricIds = [];
                    $forItemsIds = [];
                    if (!empty($prm['forRubricIds'])) {
                        $forRubricIds = explode(',', $prm->forRubricIds);
                    }
                    if (!empty($prm['forItemsIds'])) {
                        $forItemsIds = explode(',', $prm->forItemsIds);
                    }
                    foreach ($catalogIds as $key => $catalogItem) {
                        if (in_array($catalogItem['rubricId'], $forRubricIds)) {
                            $promoItems[$catalogItem->id] = $prm;
                            $promoItems[$catalogItem->id]['by'] = 'rubricId';
                        }
                        if (in_array($catalogItem['id'], $forItemsIds)) {
                            $promoItems[$catalogItem->id] = $prm;
                            $promoItems[$catalogItem->id]['by'] = 'cat_id';
                        }
                    }
                    if (count($promoItems) > 0) {
                        $res['promo'] = $promoItems;
                    } else {
                        $res['error'] = 'Promo Code not allowed for your card items';
                    }
                }
            } else {
                $res['error'] = 'card products not found';
            }
        } else {
            $res['error'] = 'code is required';
        }
        return response()->json($res)->header('Content-Type', 'application/json');
    }

    function getCartItems()
    {
        $cartItems = CartItems::selectRaw('cart_items.catalog_id,	cart_items.size_id, sum(quantity) as quantity ')
            ->where('user_fingerprint', $this->sessionFingerPrint)
            ->where('status', 'waiting')
            ->groupBy('catalog_id')
            ->groupBy('size_id')
            ->get();

        return $cartItems;
    }

    function changeQuantity(Request $request)
    {
        $catalogId = $request->input('catalogId');
        $sizeId = $request->input('sizeId');
        $count = $request->input('count');

        $item = CartItems::where('status', 'waiting')
            ->where('user_fingerprint', $this->sessionFingerPrint)
            ->where('catalog_id', $catalogId)
            ->where('size_id', $sizeId);


        if (intval($count) === 0) {
            $res = $item->delete();
        } else {
            $res = $item->update([
                'quantity' => $count
            ]);
        }

        $cartItems = $this->getCartItems();
        $s = new Session();
        $csrf_session_promo_value = $s->get('csrf_session_promo_value', '0');
        $csrfSession = $s->get('csrfSession', '0');

        return view('cart.cartItemsList', compact('cartItems',
            'csrf_session_promo_value',
            'csrfSession'));


    }

}
