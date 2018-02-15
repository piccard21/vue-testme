<?php

namespace App\Http\Controllers;

use App\Customer;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JavaScript;

class CustomerController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $hash) {
		$customer = Customer::where([
			['hash', $hash],
			['end_date', '>', new Carbon()],
		])->first();

		if (!$customer) {
			abort(Response::HTTP_EXPECTATION_FAILED);
		}

		session(['customer' => $customer]);

		$domainList = $customer->domains()
			->whereIn('status', ['open', 'selected'])
			->offset(10)
			->limit(env('DOMAIN_MAX_LIST', 10))
			->get();

		JavaScript::put([
			'domainList' => $domainList,
			'tldOptions' => $this->getTlds($domainList),
		]);

		return view('customer.index');
	}

	public function getFilteredDomainList(Request $request) {

		$this->validate($request, [
			'tlds' => 'array',
			'search' => 'string',
		]);

		$tlds = $request->input('tlds');
		$search = $request->input('search');

		if (empty($tlds)) {
			$result = [
				'msg' => 'No tld selected',
				'success' => true,
				'data' => [],
			];
			return response()->json($result);
		}

		$customer = session('customer');

		// TODO throw new / anständiges result
		if (!isset($customer)) {
			abort(Response::HTTP_EXPECTATION_FAILED);
		}

		$domainList = $customer->domains();

		if (!empty($search)) {
			$domainList->where('name', 'like', '%' . $search . '%');
		}

		$domainList->where(function ($query) use ($tlds) {
			foreach ($tlds as $tld) {
				$query->from('domains')
					->orWhere('name', 'like', '%' . $tld);
			}
		})->limit(env('DOMAIN_MAX_LIST', 10));

		$result = [
			'msg' => 'Domains filtered successfully',
			'success' => true,
			'data' => $domainList->get(),
		];

		return response()->json($result);
	}

	/**
	 * get tlds from passed domainList
	 */
	private function getTlds($domains) {
		$faker = Faker::create();
		$tlds = [];
		foreach (range(1, 21) as $index) {
			$domain = $faker->domainName;
			$a = preg_split('/\./', $domain);
			array_push($tlds, $a[1]);
		}

		return array_values(array_unique($tlds));
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
	 * @param  \App\Customer $customer
	 * @return \Illuminate\Http\Response
	 */
	public function show(Customer $customer) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Customer $customer
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Customer $customer) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Customer $customer
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Customer $customer) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Customer $customer
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Customer $customer) {
		//
	}
}
