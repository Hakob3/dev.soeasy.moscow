<?php

namespace App\Http\Controllers;

use App\Models\IndexBanners;
use App\Models\IndexBannersMobile;
use App\Models\Lookbook;
use App\Models\LookbookPhotos;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testtest(Request $request)
    {
        $tt = $request->input('testXX');
        return view('resp', compact('tt'));
    }
    public function testview(Request $request)
    {
        $tt = $request->input('testXX');
        return view('test', compact('tt'));
    }

    public function index()
    {
        $slider = IndexBanners::where('cmsDeleted', '0')
            ->where('vis', '1')
            ->get();
        $sliderMobile = IndexBannersMobile::where('cmsDeleted', '0')
            ->where('vis', '1')
            ->get();
        $menuItems = $this->menuItems;
        return view('index', compact('slider', 'menuItems', 'sliderMobile'));
    }

    public function shipping()
    {
        $menuItems = $this->menuItems;
        return view('about.shipping', compact('menuItems'));
    }

    public function privacyPolicy()
    {
        $menuItems = $this->menuItems;
        return view('about.privacyPolicy', compact('menuItems'));
    }

    public function address()
    {
        $menuItems = $this->menuItems;
        return view('address.index', compact('menuItems'));
    }

    public function returns()
    {
        $menuItems = $this->menuItems;
        return view('about.returns', compact('menuItems'));
    }

    public function lookBook()
    {
        $lookBooks = Lookbook::with('lookPhotos')
            ->get();

        $menuItems = $this->menuItems;

        return view('lookbook.lookbook',
            compact('lookBooks', 'menuItems'));
    }

    public function contacts()
    {
        $contacts = [];
        $menuItems = $this->menuItems;
        return view('contacts.contacts', compact('contacts', 'menuItems'));
    }
}
