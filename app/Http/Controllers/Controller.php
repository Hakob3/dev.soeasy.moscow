<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\CartItems;
use App\Models\Lookbook;
use App\Models\Rubrics;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $menuItems = [];

    public $csrfSessionKey = '';
    public $sessionFingerPrint = '';

    public function rubricsWithoutParents()
    {
        $parents = Rubrics::where('cmsDeleted', '0')
            ->where('vis', '1')
            ->where('parentId', 0)
            ->orderBy('ordr', 'ASC')
            ->get();
        $r = [];

        foreach ($parents as $key => $parent) {
            $r[] = $parent->id;
        }
        return $r;
    }
    public function megaValidate($f, $string)
    {

        if ($f === 'pop_device_id') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9\-]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

        if ($f === 'c_group') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9а-яА-Я\ё\_\-\=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

        if ($f === 'n_s_blist') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9\-\$\,\.\_\{\}\(\)\+\%\-\s\=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

        if ($f === 'n_s_sender_id') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9\ё\Ё\-\.\_\s=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

        if ($f == 'sms_phones') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9\ё\!\@\#\$\%\&\*\(\)\+\/\-\s\;\:\.\_\=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

        if ($f == 'n_s') {
            if (gettype($string) === "string" && !preg_match('/[^A-Za-z0-9а-яА-Я\ё\Ё\_]/u', $string)) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'n_s_d') {
            if (gettype($string) === "string" && !preg_match('/[^A-Za-z0-9а-яА-Я\Ё\ё\-\ \_]/u', $string)) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'fx1') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9а-яА-Я\@\(\)\+\ \.\/\&\_\[\]\{\}\-\=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'c_name') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z0-9а-яА-Я\ \-\_\=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 's_space') {
            if (gettype($string) === "string" && !preg_match("/[^A-Za-z\ \=]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'fx2') {
            if (gettype($string) === "string" && !preg_match("/[^0-9\-\_]/u", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 's') { //string
            if (gettype($string) === "string" && !preg_match('/[^A-Za-z_]/', trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'ps') { //passwordChecker
            if (gettype($string) === "string" && !preg_match('/[^A-Za-z0-9а-яА-Я\@\(\)\+\.\/\_\[\]\{\}\*\^\%\$\#\!\(\?\-]/u', trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'ipRange') { //ipRange
            if (gettype($string) === "string" && !preg_match('/[^0-9\/\\r\\n\.]/', trim($string))) {
                $cidr = explode("\n", $string);
                $t = false;
                foreach ($cidr as $key => $val) {
                    $r1 = explode("/", $val);
                    if (isset($r1[1]) && intval($r1[1]) >= 0 && intval($r1[1]) <= 32) {
                        $f = explode(".", $val);
                        if (count($f) === 4
                            &&
                            (intval($f[0]) >= 0 && intval($f[0]) <= 255)
                            &&
                            (intval($f[1]) >= 0 && intval($f[1]) <= 255)
                            &&
                            (intval($f[2]) >= 0 && intval($f[2]) <= 255)
                        ) {
                            $t = true;
                        } else {
                            $t = false;
                            break;
                        }
                    }
                }
            } else {
                $t = false;
            }
            return $t;
        }
        if ($f == 'isDate') { //isDate
            if (!$string) {
                return false;
            }

            try {
                new \DateTime($string);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        if ($f == 'email') {
            if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
                return false;
            } else {
                return true;
            }
        }
        if ($f == 'n') { //onlyNumbers
            if (!preg_match("#[^0-9]#", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'ph') { //phoneFormat
            if (!preg_match("/[^0-9\+\-\ \(\)\.]/", trim($string))) {
                return true;
            } else {
                return false;
            }
        }
        if ($f == 'ad') { //address
            if (!preg_match("/[^A-Za-zа-яА-Я0-9\ \_\-]/", trim($string))) {
                return true;
            } else {
                return false;
            }
        }

    }
    public function requestSession($req)
    {
        if (!$req->session()->has('fingerprint')) {
            $req->session()->put('fingerprint', 'Hermine');
        }
    }

    function __construct()
    {
        $this->authUser();
        $this->menuItems = [
            'lookBook' => Lookbook::where('vis', '1')
                ->where('cmsDeleted', '0')
                ->get(),
            'rubrics' => Rubrics::whereIn('parentId', $this->rubricsWithoutParents())
                ->where('vis', 1)
                ->where('cmsDeleted', 0)
                ->orderBy('ordr')
                ->get(),
            'cartItemsCount' => $this->cartItemsCount(),
            'csrfSessionKey' => $this->csrfSessionKey
        ];
    }

    public function cartItemsCount()
    {
        $r = 0;
        $res = CartItems::selectRaw('sum(quantity) as quantity')
            ->where('status', 'waiting')
            ->where('user_fingerprint', $this->sessionFingerPrint)
            ->first();
        if (isset($res->quantity)) {
            $r = $res->quantity;
        }
        return $r;
    }

    public function authUser($sessionValue = false)
    {

        $session = new Session();


        if ($session->get('fingerprint', '-') === '-') {
            if (!$sessionValue) {
                $sessionValue = $this->generateRandomString(8);
            }
            $session->set('fingerprint', $sessionValue);
        }
        if ($session->get('fingerprint', '-') === '-') {
            die('Session is invalid');
        }
        $this->sessionFingerPrint = $session->get('fingerprint');
        return $session->get('fingerprint');
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function setSession($key, $value)
    {
        Session::put($key, $value);
    }
}
