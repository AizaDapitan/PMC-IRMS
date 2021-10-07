<?php

namespace App\Http\Controllers;

use App\ItemCategory;
use Illuminate\Http\Request;
use App\Services\RoleRightService;

class ItemCategoryController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("PPE Items");

        $view = $rolesPermissions['view'];
        if (!$view) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];

        $pagename = 'PPE Items';
        $pagination = 10;

        $categories = ItemCategory::whereNotNull('id');

        if (isset($_GET['orderBy']) || isset($_GET['search'])) {
            if (isset($_GET['orderBy'])) {
                $categories->orderBy($_GET['orderBy'], $_GET['sortBy']);
            }

            if (isset($_GET['search'])) {
                $categories->where('category', 'like', '%' . $_GET['search'] . '%');
            }
        } else {
            $categories->orderBy('updated_at', 'desc');
        }

        $categories = $categories->paginate($pagination);

        return view('maintenance.ppe-category.index', compact(
            'pagename',
            'categories',
            'create',
            'edit',
            'delete'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (ItemCategory::where('category', $request->name)->exists()) {

            return back()->with('duplicate', 'Category is already in the list.');
        } else {
            ItemCategory::create([
                'category' => $request->name,
                'addedBy' => auth()->user()->username,
            ]);

            return back()->with('success', 'Category has been added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemCategory $itemCategory)
    {
        //
    }

    public function category_update(Request $request)
    {
        ItemCategory::find($request->catid)->update(['category' => $request->name,'addedBy' => auth()->user()->username]);

        return back()->with('success', 'Category details has been updated.');
    }

    public function category_delete(Request $request)
    {
        ItemCategory::find($request->catid)->delete();

        return back()->with('success', 'Category has been deleted.');
    }

    public function category_multiple_delete(Request $request)
    {
        $ids = explode("|", rtrim($request->id, '|'));

        foreach ($ids as $id) {
            ItemCategory::find($id)->delete();
        }

        return back()->with('success', 'Selected categories has been deleted.');
    }
}
