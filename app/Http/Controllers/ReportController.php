<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IssuanceDetail;
use App\IssuanceHeader;
use \Carbon\Carbon;
use Response;

use DB;

class ReportController extends Controller
{
    public function issuance_summary(Request $request)
    {
    	$pagename = 'Issuance Request Summary';

    	$departments = IssuanceHeader::distinct()->where('isContractor',2)->orderBy('receiver','asc')->get(['receiver']);
    	$items = IssuanceDetail::distinct()->orderBy('itemDesc','asc')->get(['itemDesc']);


    	$rs = IssuanceDetail::join('is_header','is_header.id','=','is_detail.headerId')->select('is_detail.itemDesc','is_detail.itemColor','is_detail.itemSize','is_detail.qty','is_detail.qtyReleased','is_header.controlNum','is_header.receiver','is_header.location','is_header.docDate','is_header.status','is_header.dept')->where('is_header.status','P');

        if(isset($_GET['location']) && $_GET['location'] <> ''){
            $rs->where('is_header.location',$_GET['location']);
        }

        if(isset($_GET['department']) && $_GET['department'] <> ''){
            $rs->where('is_header.isContractor',2)->where('is_header.receiver',$_GET['department']);
        }

        if(isset($_GET['item']) && $_GET['item'] <> ''){
            $rs->where('is_detail.itemDesc',$_GET['item']);
        }

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
        	$rs->whereBetween('is_header.docDate',[$_GET['startdate'],$_GET['enddate']]);
        } else {
        	$rs->whereBetween('is_header.docDate',[Carbon::today()->startOfMonth(),Carbon::today()->endOfMonth()]);
        }

        if(isset($_GET['user-type']) && $_GET['user-type'] <> ''){
            $rs->where('isContractor',$_GET['user-type']);
        }

        $rs = $rs->orderBy('docDate','desc')->get();

        return view('reports.issuance-request-summary',compact('pagename','rs','departments','items'));
    }

     public function export_issuance_summary(Request $request)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=issuance_summary.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Control #', 'Receiver', 'Department','Location', 'Date', 'Item', 'Color', 'Size', 'Requested', 'Released');

        $issuances = IssuanceDetail::join('is_header','is_header.id','=','is_detail.headerId')
                    ->select('is_detail.itemDesc','is_detail.itemColor','is_detail.itemSize','is_detail.qty','is_detail.qtyReleased','is_header.controlNum','is_header.receiver','is_header.location','is_header.docDate','is_header.status','is_header.dept')
                    ->where('is_header.status','P')
                    ->whereBetween('is_header.docDate',[$request->startdate,$request->enddate]);

        if(isset($request->location)){
            $issuances->where('is_header.location',$request->location);
        }

        if(isset($request->department)){
            $issuances->where('is_header.isContractor',2)->where('is_header.receiver',$request->department);
        }

        if(isset($request->item)){
            $issuances->where('is_detail.itemDesc',$request->item);
        }

        if(isset($request->user_type)){
            $issuances->where('isContractor',$request->user_type);
        }

        $issuances = $issuances->orderBy('docDate','desc')->get();


        $callback = function() use ($issuances, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($issuances as $i) {
                fputcsv($file, array($i->controlNum, $i->receiver, $i->dept, $i->location, $i->docDate, $i->itemDesc, $i->itemColor, $i->itemSize, $i->qty, $i->qtyReleased));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function cancelled(Request $request)
    {	
    	$pagename = 'Cancelled Issuance Request';

    	$rs = IssuanceDetail::join('is_header','is_header.id','=','is_detail.headerId')->select('is_detail.itemDesc','is_detail.itemColor','is_detail.itemSize','is_detail.qty','is_detail.qtyReleased','is_header.controlNum','is_header.receiver','is_header.location','is_header.docDate','is_header.status')->where('is_header.status','C');

    	if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
        	$rs->whereBetween('is_header.docDate',[$_GET['startdate'],$_GET['enddate']]);
        } else {
        	$rs->whereBetween('is_header.docDate',[Carbon::today()->startOfMonth(),Carbon::today()->endOfMonth()]);
        }

        $rs = $rs->orderBy('docDate','desc')->get();

        return view('reports.cancelled',compact('pagename','rs'));
    }

    public function export_cancelled(Request $request)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=cancelled_issuance.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Control #', 'Receiver', 'Location', 'Date', 'Item', 'Color', 'Size', 'Requested', 'Released');

        $issuances = IssuanceDetail::join('is_header','is_header.id','=','is_detail.headerId')
                ->select('is_detail.itemDesc','is_detail.itemColor','is_detail.itemSize','is_detail.qty','is_detail.qtyReleased','is_header.controlNum','is_header.receiver','is_header.location','is_header.docDate','is_header.status')
                ->where('is_header.status','C')
                ->whereBetween('is_header.docDate',[$request->startdate,$request->enddate])
                ->orderBy('docDate','desc')->get();

        $callback = function() use ($issuances, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($issuances as $i) {
                fputcsv($file, array($i->controlNum, $i->receiver, $i->location, $i->docDate, $i->itemDesc, $i->itemColor, $i->itemSize, $i->qty, $i->qtyReleased));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function unserve(Request $request)
    {	
    	$pagename = 'Unserve Issuance Request';
        $departments = IssuanceHeader::distinct()->where('isContractor',2)->orderBy('receiver','asc')->get(['receiver']);

        $qry = "select d.itemDesc, d.itemColor, d.itemSize,d.qty, d.qtyReleased, h.controlNum, h.receiver, h.location, h.docDate, h.status, h.isContractor from is_detail d left join is_header h on h.id = d.headerId where h.status = 'P' and d.qty <> d.qtyReleased ";


        if(isset($_GET['receiver']) && strlen($_GET['receiver']) <> ''){
            $qry .= " and h.receiver like '%".$_GET['receiver']."%'";
        }

        if(isset($_GET['department']) && $_GET['department'] <> ''){
            $qry .= " and h.isContractor = 2 and h.receiver = '".$_GET['department']."' ";
        }

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry .= " and h.docDate >='".$_GET['startdate']."' and h.docDate <='".$_GET['enddate']."'";
        } else {
            $qry .= " and MONTH(h.docDate) = MONTH(GETDATE()) AND YEAR(h.docDate) = YEAR(GETDATE()) ";
        }

        $qry .= "order by h.docDate desc";

        $rs = DB::select($qry);

        return view('reports.unserve',compact('pagename','rs','departments'));
    }

    public function export_unserve(Request $request)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=unserve_issuance.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Control #', 'Receiver', 'Location', 'Date', 'Item', 'Color', 'Size', 'Requested', 'Released');

        $qry = "select d.itemDesc, d.itemColor, d.itemSize,d.qty, d.qtyReleased, h.controlNum, h.receiver, h.location, h.docDate, h.status from is_detail d left join is_header h on h.id = d.headerId where h.status = 'P' and d.qty <> d.qtyReleased and h.docDate >='".$request->startdate."' and h.docDate <='".$request->enddate."'";

        if(isset($request->receiver)){
            $qry .= " and h.receiver like '%".$request->receiver."%'";
        }

        if(isset($request->department)){
            $qry .= " and h.isContractor = 2 and h.receiver = '".$request->department."' ";
        }

        $qry .= "order by h.docDate desc";


        $issuances = DB::select($qry);
        // $issuances = IssuanceDetail::join('is_header','is_header.id','=','is_detail.headerId')
        //             ->select('is_detail.itemDesc','is_detail.itemColor','is_detail.itemSize','is_detail.qty','is_detail.qtyReleased','is_header.controlNum','is_header.receiver','is_header.location','is_header.docDate','is_header.status')
        //             ->where('is_header.status','P')
        //             ->where('is_detail.qty','<>','is_detail.qtyReleased')
        //             ->whereBetween('is_header.docDate',[$request->startdate,$request->enddate])
        //             ->orderBy('docDate','desc')->get();

        $callback = function() use ($issuances, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($issuances as $i) {
                fputcsv($file, array($i->controlNum, $i->receiver, $i->location, $i->docDate, $i->itemDesc, $i->itemColor, $i->itemSize, $i->qty, $i->qtyReleased));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}