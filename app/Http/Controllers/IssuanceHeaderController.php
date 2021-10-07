<?php

namespace App\Http\Controllers;

use App\IssuanceHeader;
use App\IssuanceDetail;
use Illuminate\Http\Request;

use App\HRISAgusanEmployee;
use App\HRISDavaoEmployee;

use App\HRISDavaoDepartment;
use App\HRISAgusanDepartment;

use App\Contractors;
use App\ItemCategory;
use App\ItemType;
use App\PPEConfig;
use App\Services\RoleRightService;

use DB;

class IssuanceHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Issuance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];


        $pagename = 'Issuance Request List';
        $pagination = 10;

        $issuances = IssuanceHeader::whereNotNull('id');

        if (isset($_GET['orderBy']) || isset($_GET['search']) || isset($_GET['location']) || isset($_GET['type'])) {
            if (isset($_GET['orderBy'])) {
                $issuances->orderBy($_GET['orderBy'], $_GET['sortBy']);
            }

            if (isset($_GET['search'])) {
                $issuances->where('controlNum', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('receiver', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('receiverId', 'like', '%' . $_GET['search'] . '%');
            }

            if (isset($_GET['location'])) {
                $issuances->where('location', $_GET['location']);
            }

            if (isset($_GET['location'])) {
                $issuances->where('location', $_GET['location']);
            }

            if (isset($_GET['type'])) {
                if ($_GET['type'] == 1) {
                    $issuances->where('isContractor', 1);
                } else {
                    $issuances->where('isContractor', '<>', 1);
                }
            }
        } else {
            $issuances->orderBy('updated_at', 'desc');
        }

        $issuances = $issuances->paginate($pagination);

        return view('issuances.index', compact(
            'pagename',
            'issuances',
            'create',
            'edit',
            'delete',
            'print'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Issuance");

        if (!$rolesPermissions['create']) {
            abort(401);
        }
        $pagename = 'Create New Issuance';
        if (
            DB::connection('sqlsrv_agn_hris')->getDatabaseName() &&
            DB::connection('sqlsrv_dvo_hris')->getDatabaseName() &&
            DB::connection('sqlsrv_contractors')->getDatabaseName()
        ) {

            $agusanDept =  HRISAgusanDepartment::orderBy('DeptDesc', 'asc')->get();
            $davaoDept  = HRISDavaoDepartment::orderBy('DeptDesc', 'asc')->get();

            $departments = array_unique(array_merge($agusanDept->toArray(), $davaoDept->toArray()), SORT_REGULAR);
            $items       = ItemCategory::orderBy('category', 'asc')->get();

            return view('issuances.create', compact(
                'pagename',
                'departments',
                'items'
            ));
        } else {
            return view('issuances.connection-error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $items = $data['itemid'];
        $name  = $data['name'];
        $type  = $data['type'];
        $qty   = $data['qty'];
        $issuedate = $data['issuedate'];
        $remarks = $data['remarks'];


        if ($request->issuance_type == 'employee') {
            $employee = explode(' : ', $request->employee);
            if (HRISAgusanEmployee::where('EmpID', $employee[0])->exists()) {
                $employeeData = HRISAgusanEmployee::where('EmpID', $employee[0])->first();
            }

            if (HRISDavaoEmployee::where('EmpID', $employee[0])->exists()) {
                $employeeData = HRISDavaoEmployee::where('EmpID', $employee[0])->first();
            }

            $header = IssuanceHeader::create([
                'docDate' => $request->docdate,
                'receiverId' => $employee[0],
                'receiver' => $employee[1],
                'position' => $employeeData->positionDetails->PositionDesc,
                'dept' => $employeeData->deptDetails->DeptDesc,
                'status' => 'P',
                'postedDate' => now(),
                'isContractor' => 0,
                'isCompleted' => 0,
                'addedBy' => auth()->user()->username,
                'location' => auth()->user()->location
            ]);
        }

        if ($request->issuance_type == 'department') {
            $header = IssuanceHeader::create([
                'docDate' => $request->docdate,
                'receiver' => $request->department,
                'dept' => $request->department,
                'isContractor' => 2,
                'status' => 'P',
                'postedDate' => now(),
                'isCompleted' => 0,
                'addedBy' => auth()->user()->username,
                'location' => auth()->user()->location,
                'receiverId' => $request->receiver,
                'contractorId' => 0
            ]);
        }

        if ($request->issuance_type == 'contractor') {
            $header = IssuanceHeader::create([
                'docDate' => $request->docdate,
                'receiver' => $request->contractor,
                'isContractor' => 1,
                'status' => 'P',
                'postedDate' => now(),
                'isCompleted' => 0,
                'dept' => $request->contractorid,
                'addedBy' => auth()->user()->username,
                'location' => auth()->user()->location,
                'receiverId' => $request->receiver,
                'contractorId' => $request->contractorid
            ]);
        }

        if ($header) {
            IssuanceHeader::find($header->id)->update(['controlNum' => str_pad($header->id, 6, "0", STR_PAD_LEFT)]);

            foreach ($items as $key => $item) {

                IssuanceDetail::create([
                    'headerId' => $header->id,
                    'itemDesc' => $name[$key],
                    'itemColor' => $type[$key],
                    'qty' => $qty[$key],
                    'lastIssueDate' => $issuedate[$key],
                    'remarks' => $remarks[$key],
                ]);
            }
        }

        return redirect(route('issuances.index'))->with('success', 'Issuance request has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IssunceHeader  $issunceHeader
     * @return \Illuminate\Http\Response
     */
    public function show(IssuanceHeader $issunceHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IssunceHeader  $issunceHeader
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Issuance");

        if (!$rolesPermissions['edit']) {
            abort(401);
        }
        $pagename = 'Edit Issuance';

        $issuance = IssuanceHeader::find($id);

        $agusanDept =  HRISAgusanDepartment::orderBy('DeptDesc', 'asc')->get();
        $davaoDept  = HRISDavaoDepartment::orderBy('DeptDesc', 'asc')->get();

        $departments = array_merge($agusanDept->toArray(), $davaoDept->toArray());
        $items       = ItemCategory::orderBy('category', 'asc')->get();

        return view('issuances.edit', compact('pagename', 'departments', 'items', 'issuance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IssunceHeader  $issunceHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->issuance_type == 'employee') {
            $employee = explode(' : ', $request->employee);

            if (HRISAgusanEmployee::where('EmpID', $employee[0])->exists()) {
                $employeeData = HRISAgusanEmployee::where('EmpID', $employee[0])->first();
            }

            if (HRISDavaoEmployee::where('EmpID', $employee[0])->exists()) {
                $employeeData = HRISDavaoEmployee::where('EmpID', $employee[0])->first();
            }

            $header = IssuanceHeader::find($id)->update([
                'docDate' => $request->docdate,
                'receiver' => $employee[1],
                'isContractor' => 0,
                'dept' => $employeeData->deptDetails->DeptDesc,
                'receiverId' => $employee[0],
                'position' => $employeeData->positionDetails->PositionDesc,
            ]);
        }

        if ($request->issuance_type == 'department') {
            $header = IssuanceHeader::find($id)->update([
                'docDate' => $request->docdate,
                'receiver' => $request->department,
                'isContractor' => 2,
                'dept' => $request->department,
                'receiverId' => $request->receiver,
                'contractorId' => 0
            ]);
        }

        if ($request->issuance_type == 'contractor') {
            $header = IssuanceHeader::find($id)->update([
                'docDate' => $request->docdate,
                'receiver' => $request->contractor,
                'isContractor' => 1,
                'dept' => $request->contractorid,
                'receiverId' => $request->receiver,
                'contractorId' => $request->contractorid
            ]);
        }


        $data = $request->all();

        $detailid = $data['detailid'];
        $items = $data['itemid'];
        $name  = $data['name'];
        $type  = $data['type'];
        $qty   = $data['qty'];
        $issuedate = $data['issuedate'];
        $remarks = $data['remarks'];

        if ($header) {

            foreach ($items as $key => $item) {
                if ($detailid[$key] == 0) {
                    \Log::info($id);
                    IssuanceDetail::create([
                        'headerId' => $id,
                        'itemDesc' => $name[$key],
                        'itemColor' => $type[$key],
                        'qty' => $qty[$key],
                        'lastIssueDate' => $issuedate[$key],
                        'remarks' => $remarks[$key],
                    ]);
                } else {
                    IssuanceDetail::find($detailid[$key])->update([
                        'itemColor' => $type[$key],
                        'qty' => $qty[$key],
                        'lastIssueDate' => $issuedate[$key],
                        'remarks' => $remarks[$key],
                    ]);
                }
            }
        }

        return back()->with('success', 'Issuance request details has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IssunceHeader  $issunceHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssuanceHeader $issunceHeader)
    {
        //
    }
    public function remove_item(Request $request)
    {
        IssuanceDetail::find($request->issuanceid)->delete();

        return back()->with('success', 'PPE item has been removed.');
    }

    public function cancel(Request $request)
    {
        IssuanceHeader::find($request->issuanceid)->update(['status' => 'C']);

        return back()->with('success', 'Issuance request has been cancelled.');
    }

    public function print($id)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Issuance");

        if (!$rolesPermissions['print']) {
            abort(401);
        }
        $issuance = IssuanceHeader::find($id);
        $glCode   = PPEConfig::find(1);

        return view('issuances.print', compact('issuance', 'glCode'));
    }

    public function employees(Request $request)
    {

        $keyword = $request->q;

        $agusanEmployee = HRISAgusanEmployee::where('Active', 1)->where('EmpID', 'like', "%$keyword%")->orWhere('LName', 'like', "%$keyword%")->get();
        $davaoEmployee  = HRISDavaoEmployee::where('Active', 1)->where('EmpID', 'like', "%$keyword%")->orWhere('LName', 'like', "%$keyword%")->get();

        $employees = array_merge($agusanEmployee->toArray(), $davaoEmployee->toArray());

        $d = [];

        foreach ($employees as $employee) {
            array_push($d, [
                'EmpID' => $employee['EmpID'],
                'FName' => mb_convert_encoding($employee['FName'], 'UTF-8', 'ISO-8859-1'),
                'MName' => mb_convert_encoding($employee['MName'], 'UTF-8', 'ISO-8859-1'),
                'LName' => mb_convert_encoding($employee['LName'], 'UTF-8', 'ISO-8859-1')
            ]);
        }

        return response()->json($d, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function contractors(Request $request)
    {
        $keyword = $request->q;

        $contractors = Contractors::where('isActive', 1)->where('code', 'like', "%$keyword%")->orWhere('lname', 'like', "%$keyword%")->get();


        return response()->json(['contractors' => $contractors]);
    }

    public function ajax_get_item_details(Request $request)
    {
        $item = ItemCategory::where('category', $request->item)->first();
        $qry_type = ItemType::where('main', $request->item);

        $count = $qry_type->count();
        $types = $qry_type->get();

        return response()->json(['item' => $item, 'count' => $count, 'types' => $types]);
    }
}
