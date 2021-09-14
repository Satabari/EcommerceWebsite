<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

use App\Models\BlogPost;
use App\Models\BlogPostCategory;

class BlogController extends Controller
{

	public function BlogCategory()
	{
		$blogcategory = BlogPostCategory::latest()->get();
		return view('backend.blog.category.category_view', compact('blogcategory'));
	}

	public function BlogCategoryStore(Request $request)
	{
		$request->validate([
			'blog_category_name' => 'required',
		], [
			'blog_category_name.required' => 'Input Blog Category English Name',
		]);

		BlogPostCategory::insert([
			'blog_category_name' => $request->blog_category_name,
			'blog_category_slug' => strtolower(str_replace(' ', '-', $request->blog_category_name)),
			'created_at' => Carbon::now(),
		]);

		$notification = array(
			'message' => 'Blog Category Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
	}

	public function BlogCategoryEdit($id)
	{
		$blogcategory = BlogPostCategory::findOrFail($id);
		return view('backend.blog.category.category_edit', compact('blogcategory'));
	}

	public function BlogCategoryUpdate(Request $request)
	{
		$blogcar_id = $request->id;
		BlogPostCategory::findOrFail($blogcar_id)->update([
			'blog_category_name' => $request->blog_category_name,
			'blog_category_slug' => strtolower(str_replace(' ', '-', $request->blog_category_name)),
			'created_at' => Carbon::now(),
		]);

		$notification = array(
			'message' => 'Blog Category Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('blog.category')->with($notification);
	}

	public function BlogCategoryDelete($id)
	{
		$blog_category = BlogPostCategory::find($id);

		BlogPostCategory::find($id)->delete();
		$notification = array(
			'message' => 'Blog category deleted successfully',
			'alert-type' => 'danger'
		);
		return redirect()->back()->with($notification);
	}

	public function ListBlogPost()
	{
		$blogpost = BlogPost::with('category')->latest()->get();
		return view('backend.blog.post.post_list', compact('blogpost'));
	}

	public function AddBlogPost()
	{
		$blogcategory = BlogPostCategory::latest()->get();
		$blogpost = BlogPost::latest()->get();
		return view('backend.blog.post.post_view', compact('blogpost', 'blogcategory'));
	}

	public function BlogPostStore(Request $request)
	{
		$request->validate([
			'post_title' => 'required',
			'post_image' => 'required',
		], [
			'post_title.required' => 'Input Post Title English Name',
		]);

		$image = $request->file('post_image');
		$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
		Image::make($image)->resize(780, 433)->save('upload/post/' . $name_gen);
		$save_url = 'upload/post/' . $name_gen;

		BlogPost::insert([
			'category_id' => $request->category_id,
			'post_title' => $request->post_title,
			'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
			'post_image' => $save_url,
			'post_details' => $request->post_details,
		]);
		$notification = array(
			'message' => 'Blog Post Inserted Successfully',
			'alert-type' => 'success'
		);
		return redirect()->route('list.post')->with($notification);
	}

	public function BlogPostEdit($id)
	{
		$blogcategory = BlogPostCategory::orderBy('blog_category_name','ASC')->get();
    $blog_post = BlogPost::findOrFail($id);
		return view('backend.blog.post.post_edit', compact('blog_post','blogcategory'));
	}

	public function BlogPostUpdate(Request $request)
	{
		$blog_post_id = $request->id;
		$old_img = $request->old_image;

		if ($request->file('post_image')) {
			unlink($old_img);
			$image = $request->file('post_image');
			$name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
			Image::make($image)->resize(300, 300)->save('upload/post/'.$name_gen);
			$save_url = 'upload/post/' . $name_gen;

			BlogPost::findOrFail($blog_post_id)->update([
				'category_id' => $request->category_id,
				'post_title' => $request->post_title,
				'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
				'post_image' => $save_url,
			]);

			$notification = array(
				'message' => 'Blog post updated successfully',
				'alert-type' => 'info'
			);

			return redirect()->route('list.post')->with($notification);
		} else {

			BlogPost::findOrFail($blog_post_id)->update([
				'category_id' => $request->category_id,
				'post_title' => $request->post_title,
				'post_slug' => strtolower(str_replace('', '-', $request->post_title)),
			]);

			$notification = array(
				'message' => 'Blog post updated successfully',
				'alert-type' => 'info'
			);

			return redirect()->route('list.post')->with($notification);
		}
	}

	public function BlogPostDelete($id)
	{
		$post = BlogPost::find($id);
		$img = $post->post_image;
		unlink($img);

		BlogPost::find($id)->delete();
		$notification = array(
			'message' => 'Blog post deleted successfully',
			'alert-type' => 'danger'
		);
		return redirect()->back()->with($notification);
	}

}
