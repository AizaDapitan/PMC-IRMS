<?php

namespace App\Http\Controllers;

use App\ItemCategory;
use App\ItemType;
use Illuminate\Http\Request;
use App\Services\RoleRightService;

class ItemTypeController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("PPE Type");

        $view = $rolesPermissions['view'];
        if (!$view) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $pagename = 'PPE Types';
        $pagination = 10;

        $items = ItemType::whereNotNull('id');

        if (isset($_GET['orderBy']) || isset($_GET['search'])) {
            if (isset($_GET['orderBy'])) {
                $items->orderBy($_GET['orderBy'], $_GET['sortBy']);
            }

            if (isset($_GET['search'])) {
                $items->where('main', 'like', '%' . $_GET['search'] . '%')->orWhere('type', 'like', '%' . $_GET['search'] . '%');
            }
        } else {
            $items->orderBy('updated_at', 'desc');
        }

        $items = $items->paginate($pagination);

        $categories = ItemCategory::orderBy('category', 'asc')->get();

        return view('maintenance.ppe-item.index', compact(
            'pagename',
            'items',
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
        if (ItemType::where('type', $request->name)->exists()) {
            return back()->with('duplicate', 'PPE Type is already in the list.');
        } else {
            ItemType::create([
                'main' => $request->category,
                'type' => $request->name,
                'addedBy' => auth()->user()->username,
            ]);

            return back()->with('success', 'PPE Type has been added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function show(ItemType $itemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemType $itemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemType $itemType)
    {
        //
    }

    public function item_update(Request $request)
    {
        ItemType::find($request->id)->update([
            'main' => $request->category,
            'type' => $request->name,
            'addedBy' => auth()->user()->username,

        ]);

        return back()->with('success', 'PPE Type details has been updated.');
    }

    public function item_delete(Request $request)
    {
        ItemType::find($request->itemid)->delete();

        return back()->with('success', 'PPE Type has been deleted.');
    }

    public function item_multiple_delete(Request $request)
    {
        $ids = explode("|", rtrim($request->id, '|'));

        foreach ($ids as $id) {
            ItemType::find($id)->delete();
        }

        return back()->with('success', 'Selected PPE Type has been deleted.');
    }
}
