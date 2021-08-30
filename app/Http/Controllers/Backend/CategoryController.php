<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function CategoryView()
    {
        $category = Category::latest()->get();
        return view('backend.category.category_view',compact('category'));
    }

    public function CategoryStore(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_icon' => 'required',
        ],[
            'category_name.required' => 'Input category name',
        ]);


        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_icon' => $request->category_icon,
        ]);

        $notification = array(
            'message' => 'Category inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function CategoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit',compact('category'));
    }

    public function categoryUpdate(Request $request)
    {   
        $category_id = $request->id;

        category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace('', '-', $request->category_name)),
            'category_icon' => $request->category_icon,
        ]);

        $notification = array(
            'message' => 'category updated successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.category')->with($notification);
        
    }

    public function CategoryDelete($id)
    {
        Category::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Category deleted successfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }

}
