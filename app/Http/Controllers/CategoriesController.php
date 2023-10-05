<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function showNewCategoryForm(): View
    {
        return view('dashboard-new-category');
    }

    public function createNewCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category;
 
        $category->name = $request->name;
        $category->save();
 
        return redirect('/dashboard');
    }
}
