<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function showCategories(): View
    {
        if(Auth::user()->role_id > 5) {
            abort(404);
        }
        $categories = Category::all();
        return view('admin.categories', [
            'categories' => $categories
        ]);
    }

    public function showNewCategoryForm(): View
    {
        if(Auth::user()->role_id > 5) {
            abort(404);
        }
        return view('admin.category-new');
    }

    public function createNewCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category;

        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.all')->withSuccess('Category name=' . $category->name . ' created.');
    }
}
