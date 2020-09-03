<?php

namespace App\Http\Controllers\Accountant;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
   public function index(Request $request)
    {
        $skey = ($request->skey == '') ? null : $request->skey;

        if(!is_null($skey))
        {
            $categories = Category::where('categoryname', 'like', '%'.$skey.'%')->orderby('categoryname', 'asc')->orderby('category_id', 'asc')->paginate(15);
        }
        else
        {
            $categories = Category::orderby('categoryname', 'asc')->orderby('category_id', 'asc')->paginate(15);
        }

        #$categories = Category::orderby('category_id', 'desc')->paginate(10);
        return view('accountant.category.index', compact('categories', 'skey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('accountant.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->create($request->all());

        return redirect()->route('accountantCategoryIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('accountant.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());

        return redirect()->route('accountantCategoryIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
