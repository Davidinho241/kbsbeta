<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::orderBy('label', 'DESC')->with('products')->paginate(10);
        return view('tenant.category.index', compact('categories'));
    }

    public function save($data)
    {
        return Category::create($data);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'label' => 'required | string',
                'description' => 'string | min:5 | max:1000 ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            };

            // store user information
            if ($this->save($request->only((new Category())->getFillable()))) {
                return redirect()->back()->with('success', 'Category created successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to create new category! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function destroy($id)
    {
        $category = Category::withTrashed()->where('id', $id)->first();
        if ($category) {
            $category->forceDelete();
            return redirect()->back()->with('success', 'Category removed!');
        } else {
            return redirect()->back()->with('error', 'Category not found');
        }
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return redirect()->back()->with('success', 'Category removed!');
        } else {
            return redirect()->back()->with('error', 'Category not found');
        }
    }

    public function update(Request $request)
    {
        // update tenant info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'label' => 'required',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            $category = Category::find($request->id);

            $data = $request->only((new Category())->getFillable());

            $update = $category->update($data);

            if ($update) {
                return redirect()->back()->with('success', 'Category information updated successfully !');
            } else {
                return redirect('tenants')->with('error', 'Failed to update the category! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

}
