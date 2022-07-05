<?php


namespace App\Http\Controllers;


use App\Models\CartItems;
use App\Models\Catalog;
use App\Models\CatalogSizes;
use App\Models\Rubrics;
use App\Models\Structure;
use App\Models\CatalogMeasurements;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use function Tinify\validate;

class CatalogController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function catalogItem($id)
    {
        $catalog_item = Catalog::find($id);
        return $this->catItem($catalog_item);
    }

    public function addToCart(Request $request)
    {
        $fng = $this->authUser();
        $resp = [];
        if ($request->input('size') !== '' && $request->input('catId') !== '') {

            $t = CartItems::where('user_fingerprint', $fng)
                ->where('size_id', $request->input('sizes'))
                ->where('catalog_id', $request->input('catId'))
                ->where('status','waiting')
                ->first();

            if (!isset($t->id)) {
                $quantity = 1;
                $t = new CartItems();
            } else {
                $quantity = intval( $t->quantity ) + 1;
            }



            $t->user_fingerprint = $fng;
            $t->catalog_id = $request->input('catId');
            $t->size_id = $request->input('sizes');
            $t->quantity = $quantity;
            $t->cart_code = '';
            $t->ref_from = '';
            $t->status = 'waiting';
            $t->created_date = date('Y-m-d H:i:s');

            if ($t->save()) {
                $resp['success'] = 'Successfully added';
            } else {
                $resp['error'] = 'Something went wrong #98';
            }

        } else {
            $resp['error'] = 'Incorrect request #47';
        }

        return response()->json($resp)->header('Content-Type', 'application/json');
    }


    public function catalogItemByUri($uri)
    {
        $catalog_item = Catalog::where('uri', $uri)->first();
        return $this->catItem($catalog_item);
    }

    function catItem($catalog_item)
    {
        $menuItems = $this->menuItems;
        $structure = Structure::where('uri', 'sizes')->first();
        $mTable = $this->measurementsTable($catalog_item);

        return view('catalog.catalogItem', compact(
            'catalog_item',
            'mTable',
            'structure',
            'menuItems'));
    }


    public function measurementsTable($catItem)
    {
        $table = '';
        $issetSizes = CatalogMeasurements::where('catalog_id', $catItem->id)->get();


        $sizesArr = [];
        $sizesIds = explode(',', $catItem->sizesIds);
        $allSizes = CatalogSizes::where('vis', '1')
            ->where('cmsDeleted', '0')
            ->whereIn('id', $sizesIds)
            ->orderBy('ordr')
            ->get();

//        foreach ($issetSizes as $l => $issetSize) {
//            $sizesArr[] = strtoupper(->name);
//        }

        if (!empty($catItem->sizesIds) && !empty($issetSizes)) {
            $table = '<div class="table2"><table class="sizeInfo table"  id="moreMeasure">';
            $thead = '';


            foreach ($allSizes as $key => $value) {
                $thead .= '<td><strong>' . strtoupper($value->name) . '</strong></td>';
            }
            $table .= '<tr><td>Мерка</td>' . $thead . '</tr>';

            foreach ($issetSizes as $key => $value) {
                $values = explode('/', $value->size_value);
                sort($values);
                $valuesTd = '';
                foreach ($values as $k => $v) {
                    $valuesTd .= '<td>' . $v . '</td>';
                }
                $table .= '<tr><td>' . $value->name . '</td>' . $valuesTd . '</tr>';
            }

            $table .= '</table></div>';
        }

        return $table;
    }

    public function index()
    {
        $rubrics2 = $this->rubricsWithoutParents();


        $rubrics = Rubrics::where('cmsDeleted', '0')
            ->where('vis', '1')
            ->whereIn('parentId', $rubrics2)
            ->orderBy('ordr', 'ASC')
            ->get();

        $catalogItems = [];

        foreach ($rubrics as $key => $rubric) {
            $catalogRItem = Catalog::with(['rubrics' => function ($query) use ($rubrics2) {
                $query->whereIn('parentId', $rubrics2);
            }])
                ->where('vis', '1')
                ->where('cmsDeleted', '0')
                ->where('price', '>', '0')
                ->where('rubricId', '=', $rubric->id)
                ->orderBy('ordr', 'ASC')
                ->get();
            $catalogItems[] = [
                'rubric' => $rubric,
                'items' => $catalogRItem
            ];
        }


        $menuItems = $this->menuItems;
        return view('catalog.index',
            compact('catalogItems',
                'menuItems'));

    }

}