<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Mailing;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\If_;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateMailing;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Self_;

use function PHPUnit\Framework\isEmpty;

class MailingController extends Controller
{

    public function __construct()
    {   
        // protection - only logged user are allowed to do these actions
        $this->middleware('auth')
        ->only(['create', 'store', 'edit', 'update', 'destroy', 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mailings = Mailing::all();
        return view('mailing.index', ['mailings' => $mailings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            'mailing.create',
            ['themes' => Theme::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $theme = Theme::find($request->theme);
        //dd($theme);

        $mailing = new Mailing();
        $mailing->name = $request->name;
        $mailing->slogan = $request->slogan;
        $mailing->theme()->associate($theme);
        $mailing->user()->associate($user);

        $mailing->save();

        

        // load data from XML
        $productsCollection = Self::XmlToCollection();
        
        //____DO SOMETHING FOR EACH PRODUCT______
        $productsIds = $request->product_id;
        //dd($productsIds);
        foreach ($productsIds as $key => $productId){
            
            //new model of prodcut
            $product = new Product;

            // skip products that are not in XML feed OR are already in DB
            if ($found = Product::find($productId)) {
                $found->mailings()->attach($mailing);
                continue;
            }
            elseif (!$productsCollection->get($productId)){
                $product->id = $productId;
                $product->save();
                $product->mailings()->attach($mailing);
                continue;
            }
            
        
            $productFromXml = $productsCollection->get($productId);
            //dd($productFromXml);
            $product->id = $productId;
            $product->name = $productFromXml['PRODUCTNAME'];
            $product->category = $productFromXml['CATEGORYTEXT'];
            $product->description = is_array($productFromXml['DESCRIPTION']) ? null : $productFromXml['DESCRIPTION'];
            $product->price = $productFromXml['PRICE_VAT'];
            $product->url = $productFromXml['URL'];
            $product->img_url = isset($productFromXml['IMGURL']) ? $productFromXml['IMGURL'] : null;

            // if doesnt exist manufacturer with given name, create it
            if(!Manufacturer::where('name', $productFromXml['MANUFACTURER'])->exists()){
                $manufacturer = new Manufacturer;
                $manufacturer->name = $productFromXml['MANUFACTURER'];
                $manufacturer->save();
            }
            else{
                // foreing key (existing manufacturer)
                $manufacturer = Manufacturer::where('name', $productFromXml['MANUFACTURER'])->first();
            }
            // foreign key
            $product->manufacturer()->associate($manufacturer);
            $product->save();

            // fill many to many table
            $product->mailings()->attach($mailing);
        }


        return redirect()->route('mailing.edit', ['mailing' => $mailing->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // SHOW MAILING - AFTER UPDATING .... OR AFTER CLICKING ON SHOW BUTTON IN MAILINGS OVERVIEW

        // $productsInMailing = Product::whereHas('mailings', function (Builder $query) use($id) {
        //     $query->where('mailing_id', $id);
        // })->get();

        return Self::createHtml($id, null);

        //return view('mailing.show', ['mailing' => Mailing::findOrFail($id), 'products' => $productsInMailing, 'html' => $html]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // query for mailing products
        $productsInMailing = Product::whereHas('mailings', function (Builder $query) use($id) {
            $query->where('mailing_id', $id);
        })->get();

        $manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        return view('mailing.edit', ['mailing' => Mailing::findOrFail($id),'products' => $productsInMailing, 'manufacturers' => $manufacturers, 'themes' => Theme::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
                    // 'title' => 'min:5|max:100|string|required',
                    // 'content' => 'min:10|max:100|required'
                    'products.*.price' => 'numeric',
                    'products.*.oldPrice' => 'nullable|numeric'
        ]);

        $mailingModel = Mailing::findOrFail($id);

        $mailingModel->name = $request->name;
        $mailingModel->slogan = $request->slogan;
        $mailingModel->theme()->associate($request->theme);
        $mailingModel->save();

        // edit products in mailing
        foreach ($request->products as $key => $product) {
            
            $productModel = Product::findOrFail($key);

            $productModel->name = $product['name'];
            $productModel->price = $product['price'];
            $productModel->old_price = $product['oldPrice'];
            $productModel->description = $product['description'];
            $productModel->url = $product['url'];
            // $productModel->img_url = $product['name'];
            // if is inserted new image, update product model with it
            if(!empty($product['newImage'])){

                $newProductImg = $product['newImage'];
                $imgName = time().'-'.$newProductImg->getClientOriginalName();

                $path = $newProductImg->storeAs(
                    'images/products',
                    $imgName,
                    'public'
                );
                $path = Storage::disk("public")->url($path);
                // $url = Storage::url($imgName);
                // $publicPath = public_path('images/products/'.$imgName);
                // $pulicPath2 = public_path($imgName);
                // $url2 = url($imgName);
                
                $productModel->img_url = $path;
                //dd('/images/products/'.$imgName, $url, $publicPath, $pulicPath2, $url2, 'NEXT: '.$next);
            }
            
            $productModel->manufacturer_id = $product['manufacturer'];
            $productModel->save();
        }

        return redirect()->route('mailing.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mailing = Mailing::findOrFail($id);
        DB::table('mailing_product')->where('mailing_id', '=', $id)->delete();
        $mailing->delete();
        
        session()->flash('status', 'Mailing byl smazán!');

        return redirect()->route('mailing.index'); 
    }
    /**
     * Convert downloaded XMl file to Collection
     * 
     */
    public function XmlToCollection()
    {
        
        // load xml
        $xmlFile = Storage::disk('local')->get('feed.xml');
        dd($xmlFile);
        $xml = simplexml_load_string($xmlFile);

        // xml to array process
        $json = json_encode($xml);
        $productsArray = json_decode($json, true);
        $productsArray = Arr::first($productsArray);

        //array to collection
        $productsCollection = collect($productsArray);
       
        // key mapping
        $productsCollection = $productsCollection->mapWithKeys(function($product, $key){
            return [$product['ITEM_ID'] => $product];
        });

        return $productsCollection;
    }


    public function createHtml($id, $showRaw)
    {
        $productsInMailing = Product::whereHas('mailings', function (Builder $query) use($id) {
            $query->where('mailing_id', $id);
        })->get();

        // no special custom theme (different themes just changing background) - for customizing mailing look, create different view
        $html = view('mailing.html', ['mailing' => Mailing::findOrFail($id), 'products' => $productsInMailing,])->render();
        //dd($html);

        return view('mailing.show', ['mailing' => Mailing::findOrFail($id), 'products' => $productsInMailing, 'html' => $html, 'raw' => $showRaw]);
    }
}
