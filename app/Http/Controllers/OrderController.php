<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Order;
use App\Domain;
use JavaScript;
use App\Lib\Data\TaskQuery;
use App\Jobs\ProcessRegisterDomainTask;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller {
	
	private $taskService;
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$customer = session('customer');
		
		if(!$customer) {
			abort(Response::HTTP_EXPECTATION_FAILED);
		}
		
		$selectedDomains = Domain::where([
			['customer_id', $customer->id],
			['status', 'selected']
		])->get();
		
		
		JavaScript::put([
			'domainsSelected' => $selectedDomains
		]);
		
		return view('order.index');
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function show(Order $order) {
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Order $order) {
		//
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Order $order) {
		//
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Order $order
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Order $order) {
		//
	}
	
	/**
	 * add a domain
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function addDomain(Request $request) {
		$this->validate($request, [
			'domainId' => 'required|integer|min:1',
		]);
		
		$customer = session('customer');
		
		$domain = Domain::where([
			['customer_id', $customer->id],
			['id', $request->input('domainId')]
		])->first();
		
		$domain->status = 'selected';
		$domain->save();
		
		$result = [
			'msg' => 'Domain added successfully',
			'success' => true
		];
		
		return response()->json($result);
	}
	
	
	/**
	 * remove a domain
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function removeDomain(Request $request) {
		$this->validate($request, [
			'domainId' => 'required|integer|min:1',
		]);
		
		$customer = session('customer');
		
		$domain = Domain::where([
			['customer_id', $customer->id],
			['id', $request->input('domainId')]
		])->first();
		
		$domain->status = 'open';
		$domain->save();
		
		$result = [
			'msg' => 'Domain removed successfully',
			'success' => true
		];
		
		return response()->json($result);
	}
	
	
	/**
	 * perform a login
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request) {
		$this->validate($request, [
			'pwd' => 'required|min:3',  // trim???
		]);
		
		// TODO: 2FA
//		$is2FA = session('customer.2FA', false);
		
		$this->taskService = app(TaskQuery::class, array(
			'user' => session('customer.username', false),
			'password' => $request->input('pwd'),
			'context' => session('customer.context', false)
		));
		
		$authResult = $this->taskService->authSessionCreate();
		$authResult['success'] = true;
		
		// save session-hash & pwd
		session(['user.session_hash' => $this->taskService->getSessionHash()]);
		session(['user.password' => $request->input('pwd')]);
		
		return response()->json($authResult);
	}
	
	/**
	 * order the domain by setting domain_status to 'pending'
	 *
	 * @param Request $request
	 */
	public function order(Request $request) {
		$customer = session('customer');
		
		// TODO: REQUEST-class outsourcen?!?!?
		
		if(!isset($customer)) {
			abort(Response::HTTP_EXPECTATION_FAILED);
		}
		
		// update domain-status to 'PENDING'
		Domain::where([
			['customer_id', $customer->id],
			['status', 'selected']
		])->update(['status' => 'pending']);
		
		// get pending domains
		$pendingDomains = Domain::where([ ['customer_id', $customer->id], ['status', 'pending'] ])->get();
		
		// make pending-domains availbale in JS
		JavaScript::put([
			'pendingDomains' => $pendingDomains
		]);
		
		// add tasks to queue
		foreach($pendingDomains as $domain) {
			Log::info("################ DISPATCH JOB");
			
			ProcessRegisterDomainTask::dispatch(
				$domain->original,
				$domain->name,  // TODO: domain-name or xnn???
				session('customer.username', false),
				session('user.password', false),
				session('customer.context', false),
				$customer->email
//			)->delay(now()->addSeconds(5));
			);
		}
		
		return view('order.order');
	}
	
	
	/**
	 * check status of domain for polling
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkStatus(Request $request) {
		
		$customer = session('customer');
		if(!isset($customer)) {
			abort(Response::HTTP_EXPECTATION_FAILED);
		}
		
		$pendingDomains = Domain::where([
			['customer_id', session('customer')->id],
			['status', '!=', 'selected'],
			['status', '!=', 'open']
		]);
		
		$domains = $pendingDomains->get()->toArray();
		
		return response()->json($domains);
		
	}
	
	/**
	 * @param Request $request
	 */
	public function notify(Request $request) {
		$request = $request->xml();
		
		Log::debug("######################## NOTIFY--> ###############################");
		Log::notice($request);
		Log::info("STATUS:");
		Log::notice($request['ctid']);
		Log::debug("######################## <--NOTIFY ###############################");
		
		
		// get ctid
		$ctid = isset($request['ctid']) ? $request['ctid'] : false;
		if(!isset($ctid)) {
			return response()->json([]);
		}
		
		// TODO: request rename to ctid
		$domain = Domain::where('request', $ctid)->first();
		if(!$domain) {
			return response()->json([]);
		}
		
		// check success
		if(isset($request['status']['type']) && $request['status']['type'] == 'success') {
			$domain->status = 'success';
		} else {
			$domain->status = 'error';
		}
		
		$domain->save();
		
		// TODO: return?
		return response()->json([]);
	}
}
