<?php

namespace App\Http\Controllers;

use App\Models\CatalogModifications;
use App\Models\CatalogSizes;
use App\Models\Orders;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{

    public $errors = [];

    public function makeOrder(Request $request)
    {
        $newOrder = new Orders();
        $this->orderValidation($request);

    }

    public function orderValidation($request)
    {
        $validItems = [];
        $validSizes = [];
        $validSizesNames = [];
        $items = [];
        $ms_codes = [];
        $client = [];
        $personalPromoCode = '';
        $personalPromoPercent = 0;
        $ctgIds = [];
        $catSizes = [];
        $validCounts = [];
        $sizeCat = [];
        $priceCat = [];
        $orderSum = 0;
        $tmpCartCatIds = explode(',', $request->input('tmpCartCatIds'));
        $tmpCartSizes = explode(',', $request->input('tmpCartSizes'));
        $tmpCartQuantities = explode(',', $request->input('tmpCartQuantities'));


        if (!empty($tmpCartSizes) && is_array($tmpCartSizes)) {

            $sizesNames2 = CatalogSizes::selectRaw('lower(name) as name, id')
                ->get();

            $sizesNames = [];
            foreach ($sizesNames2 as $k => $t) {
                $sizesNames[$t->id] = $t;
            }


            foreach ($tmpCartSizes as $key => $val) {
                if (!empty($val)) {
                    $validSizes[$val] = $sizesNames[$val];
                }
            }
            if (empty($validSizes)) {
                $this->errors['error'] = 'Size is empty.';
            }
        }

        if (is_array($tmpCartCatIds) && !empty($tmpCartCatIds)) {
            foreach ($tmpCartCatIds as $key => $val) {


                if (!empty(intval($val))) {
                    $validItems[] = intval($val);
                }
            }

            if (!empty($validItems)) {
                if (count($validSizes) === count($validItems)) {

                    if (!empty($tmpCartQuantities)) {
                        foreach ($validItems as $key => $value) {

                            $validSizesName = $validSizes[$tmpCartSizes[$key]]->name;


//                            DB::enableQueryLog();

                            $q = CatalogModifications::selectRaw('catalog_modifications_new.id as id , 
                                   catalog_modifications_new.stockAvi as stockAvi,  
                                   catalog_modifications_new.stockXox as stockXox,  
                                   catalog_modifications_new.modification_id as modification_id,  
                                   catalog_modifications_new.stockOsSkl as stockOsSkl,  
                                   catalog.price as price,  
                                   catalog.rubricId, catalog.oldPrice, 
                            catalog.name as catalog_name')
                                ->leftJoin('catalog', 'catalog.id', '=', 'catalog_modifications_new.catalog_id')
                                ->where('catalog_id', $value)
                                ->where(function ($query) use ($validSizesName) {
                                    $query->orWhereRaw("lower(code) like '%-$validSizesName %'");
                                    $query->orWhereRaw("lower(code) like '%-$validSizesName' ");
                                    $query->orWhereRaw("lower(modification_name) like '%($validSizesName %)' ");
                                })
                                ->first();

//                            dd(DB::getQueryLog());
//                            die;

                            $sizeCat1 = $val;
                            $sizeCat[] = $sizeCat1;
                            $k = array_search($val, $validItems);
                            $leftCount = 0;

                            if (isset($q->modification_id, $q->catalog_name)
                                && !empty($q->modification_id)
                                && !empty($q->catalog_name)) {

                                $leftCount = intval($q->stockAvi) + intval($q->stockXox) + intval($q->stockOsSkl);



                                if ($leftCount === 0) {
                                    $this->errors['error'] = 'Ой, похоже товар:' . $val['catalog_name'] . ' нет в наличии';
                                }
                            }

                            var_dump($this->errors); die;
                            if (isset($tmpCartQuantities[$k])) {
                                $ctgIds[] = $q->catalog_id;
                                $priceCat[] = $q->price;

                                $catSizes0 = CatalogSizes::where('name', strtolower($validSizesName))
                                    ->first();
                                if (isset($catSizes0->id)) {
                                    $catSizes[] = $catSizes0->id;


                                    $orderSum += intval($q->price) * intval($request->input('tmpCartQuantities')[$key]);
                                    $ms_codes[] = $q->modification_id;
                                    $items[] = [
                                        'modification_id' => $q->modification_id,
                                        'size' => strtolower($validSizesName),
                                        'rubricId' => $q->rubricId,
                                        'price' => $q->price,
                                        'oldPrice' => $q->oldPrice,
                                        'catalogId' => $q->catalog_id,
                                        'itemId' => strtolower($validSizesName),
                                        'tmpCartQuantities' => $request->input('tmpCartQuantities')[$k],
                                        'leftCount' => $leftCount
                                    ];
                                }


                            }
                        }
                    } else {
                        $this->errors['error'] = 'Quantities error.';
                    }
                } else {
                    $this->errors['error'] = 'Oops looks like sizes and items are mismatch';
                }
            } else {
                $this->errors['error'] = 'Oops looks like there is not valid items.';
            }

            if (count($tmpCartCatIds) !== count($validItems)) {
                $this->errors['error'] = 'Пожалуйста, удалите недопустимый товар из корзины.';
            }
            $tmpCartQuantities = $request->input('tmpCartQuantities');

            if (is_array($tmpCartQuantities)) {
                foreach ($request->input('tmpCartQuantities') as $key => $q) {
                    if (is_numeric($q)) {
                        $validCounts[] = $q;
                    }
                }
                if (count($validCounts) !== count($request->input('tmpCartQuantities'))) {
                    $this->errors['error'] = 'oops problem with counts.';
                }
            } else {
                $this->errors['error'] = 'There is problems with counts.';
            }

        } else {
            $this->errors['error'] = 'Invalid Card items';
        }


        if (empty($items)) {
            $this->errors['error'] = 'Ой, похоже товары нет в наличии';
        } else {
            if (!empty($request->input('name'))) {
                $client['first_name'] = trim($request->input('name'));
            } else {
                $this->errors['error'] = 'Пожалуйста, введите ваше имя.';
            }


            if (!empty($request->input('name2'))) {
                $client['last_name'] = trim($request->input('name2'));
            } else {
                $this->errors['error'] = 'Пожалуйста, введите свою фамилию.';
            }


            if (!empty($request->input('email'))) {
                if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->errors['error'] = "Неверный формат электронной почты";
                } else {
                    $client['email'] = trim($request->input('email'));
                }
            } else {
                $this->errors['error'] = 'Пожалуйста, электронной почты';
            }


            if (!empty($request->input('phone'))) {
                if (!$this->megaValidate('ph', $request->input('phone'))) {
                    $this->errors['error'] = "Неверный формат номера телефона";
                } else {
                    $client['phone'] = trim($request->input('phone'));
                }
            } else {
                $this->errors['error'] = 'Пожалуйста, введите номера телефона.';
            }


            $delivery_types = [
                'deliveryMoscow1',
                'deliveryRussia2',
                'pickupFromShowroom',
                'saleDelivery',
            ];
            if (!empty($request->input('delivery_type'))) {
                if (!in_array($request->input('delivery_type'), $delivery_types)) {
                    $this->errors['error'] = "Пожалуйста, выберите правильный тип доставки.";
                } else {
                    $client['delivery_type'] = trim($request->input('delivery_type'));

                    if ($client['delivery_type'] === 'deliveryMoscow1') {
                        if (isset($_POST['addressMoscow']) && !empty($_POST['addressMoscow'])) {
                            $client['address'] = trim($_POST['addressMoscow']);
                        } else {
                            $this->errors['error'] = 'Пожалуйста, заполните ваш адрес.';
                        }
                    } else if ($client['delivery_type'] === 'deliveryRussia2') {
                        if (isset($_POST['addressRussia']) && !empty($_POST['addressRussia'])) {
                            $client['address'] = trim($_POST['addressRussia']);
                        } else {
                            $this->errors['error'] = 'Пожалуйста, заполните ваш адрес.';
                        }
                    } else if ($client['delivery_type'] === 'saleDelivery') {
                        if (isset($_POST['addressSaleDelivery']) && !empty($_POST['addressSaleDelivery'])) {
                            $client['address'] = trim($_POST['addressSaleDelivery']);
                        } else {
                            $this->errors['error'] = 'Пожалуйста, заполните ваш адрес. 9';
                        }
                    }
                }
            } else {
                $this->errors['error'] = 'Пожалуйста, выберите тип доставки.';
            }

            $validPaymentTypes = ['card', 'cash'];


            if ($client['delivery_type'] === 'saleDelivery') {
                $client['payType'] = 'cash';
            } else {
                if (isset($_POST['payType']) && !empty($_POST['payType'])) {
                    if (in_array($_POST['payType'], $validPaymentTypes)) {
                        $client['payType'] = trim($_POST['payType']);
                    } else {
                        $this->errors['error'] = 'Пожалуйста, выберите допустимый тип оплаты.';
                    }
                } else {
                    $this->errors['error'] = 'Пожалуйста, выберите способ оплаты.';
                }
            }
        }


        $orderSumAfterPromo = $orderSum;

        $personalPromoCode = $request->input('personalPromoCode');
        $personalPromoCodePercent = $request->input('personalPromoCodePercent');

        if (intval($personalPromoCodePercent) > 0) {
            if (!empty($personalPromoCode)) {
                $email = isset($client['email']) ? $client['email'] : '';
                $pr = Subscribers::where('email', $email)
                    ->where('promocode', $personalPromoCode)
                    ->where('promo_used', 0)
                    ->get();

                if (!empty($pr)) {
                    if (trim(strtolower($email)) === trim(strtolower($pr->email))) {
                        $orderSumAfterPromo = $orderSum - ($orderSum * 10 / 100);
                        $personalPromoCode = $pr->promocode;
                        $personalPromoPercent = 10;
                    }
                }
            }
        }
        var_dump($this->errors);
        die;
        if (empty($this->errors)) {
            $this->data = [
                'client' => $client,
                'items' => $items,
                'ctgIds' => $ctgIds,
                'catSizes' => $catSizes,
                'validCounts' => $validCounts,
                'priceCat' => $priceCat,
                'ms_codes' => $ms_codes,
                'orderSum' => $orderSum,
                'orderSumAfterPromo' => $orderSumAfterPromo,
                'personalPromoCode' => $personalPromoCode,
                'personalPromoPercent' => $personalPromoPercent,
            ];

            var_dump($this->data);
            die;
        }
    }


}
