<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
       $categories = Category::whereNull('parent_id')->orderBy('order')->with('children')->get();
       return view('categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->back()->with('success', 'Category created.');
    }

    public function edit(Category $category): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('categories.edit', compact('category'));
    }
    public function update(UpdateCategoryRequest $request, Category $category): \Illuminate\Http\RedirectResponse
    {
       $category->update($request->validated());

       return redirect()->back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();

        return redirect()->back();
    }

    public function sort(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->input('tree');
        if (!is_array($data)) {
            return response()->json(['error' => 'Invalid data format.'], 422);
        }

        $this->updateOrder($data);
        return response()->json(['status' => 'success']);
    }

    private function updateOrder($items, $parentId = null): void
    {
        foreach ($items as $index => $item) {
            Category::where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'order' => $index
            ]);
            if (!empty($item['children'])) {
                $this->updateOrder($item['children'], $item['id']);
            }
        }
    }
}
