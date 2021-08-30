<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SubCategoryController extends Controller
{
    // Sub category methods
    
    public function SubCategoryView()
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.category.subcategory_view',compact('subcategory','categories'));
    }

    public function SubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ],[            
            'category_id.required' => 'Select category',
            'subcategory_name.required' => 'Input Subcategory name',
        ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),
        ]);        

        $notification = array(
            'message' => 'SubCategory inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.category.subcategory_edit',compact('subcategory','categories'));
    }

    public function SubCategoryUpdate(Request $request)
    {
         $subcat_id = $request->id;

         SubCategory::findOrFail($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),
        ]);        

        $notification = array(
            'message' => 'SubCategory updated successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'SubCategory deleted successfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }

    //Sub sub category methods

    public function SubSubCategoryView()
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name','ASC')->get();
        $subsubcategory = SubSubCategory::latest()->get();
        return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories','subcategories'));
    }

    public function GetSubCategory($category_id)
    {
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
     	return json_encode($subcat);
    }

    public function GetSubSubCategory($subcategory_id)
    {
        $subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name','ASC')->get();
     	return json_encode($subsubcat);
    }

    public function SubSubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name' => 'required',
        ],[            
            'category_id.required' => 'Select category',
            'subcategory_id.required' => 'Select subcategory',
            'subsubcategory_name.required' => 'Input SubSubcategory name',
        ]);

        SubSubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->subsubcategory_name,
            'subsubcategory_slug' => strtolower(str_replace(' ','-',$request->subsubcategory_name)),
        ]);        

        $notification = array(
            'message' => 'Sub-SubCategory inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SubSubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name','ASC')->get();
        $subsubcategory = SubSubCategory::findOrFail($id);
        return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategory'));
    }

    public function SubSubCategoryUpdate(Request $request)
    {
         $subsubcat_id = $request->id;

         SubSubCategory::findOrFail($subsubcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->subsubcategory_name,
            'subsubcategory_slug' => strtolower(str_replace(' ','-',$request->subsubcategory_name)),
        ]);

        $notification = array(
            'message' => 'Sub-SubCategory updated successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.subsubcategory')->with($notification);
    }

    public function SubSubCategoryDelete($id)
    {
        SubSubCategory::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Sub-SubCategory deleted successfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }
}
