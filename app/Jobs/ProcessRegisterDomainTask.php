<?php

namespace App\Jobs;

use App\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Lib\Data\TaskQuery;
use App\Exceptions\TaskException;
use Illuminate\Support\Facades\Log;

class ProcessRegisterDomainTask implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	private $taskService;
	private $originalDomain;
	private $domain;
	private $username;
	private $password;
	private $context;
	private $email;
	private $domainModel;
	
	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 1;
	
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($originalDomain, $domain, $username, $password, $context, $email) {
		$this->originalDomain = $originalDomain;
		$this->domain = $domain;
		$this->username = $username;
		$this->password = $password;
		$this->context = $context;
		$this->email = $email;
		
		$this->taskService = app(TaskQuery::class, array(
			'user' => $this->username,
			'password' => $this->password,
			'context' => $this->context,
		));
	}
	
	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		
		Log::info("################ HANDLE JOB: ".$this->domain);
		
		$this->domainModel = Domain::where([
			['original', $this->originalDomain],
			['name', $this->domain]
		])->first();
		
		$this->domainModel->status = "running";
		$this->domainModel->save();
		
		$domainInfo = $this->taskService->domainInfo($this->originalDomain);
		
		try {
			$ownerc = $domainInfo['result']['data']['domain']['ownerc'];
			$adminc = $domainInfo['result']['data']['domain']['adminc'];
			$techc = $domainInfo['result']['data']['domain']['techc'];
			$zonec = $domainInfo['result']['data']['domain']['zonec'];
			$nserver = $domainInfo['result']['data']['domain']['nserver'];
			$ctid = "domain-promo-id-" . $this->domainModel->id;
			
			// save ctid
			$this->domainModel->request = $ctid;
			$this->domainModel->save();
			
			$result = $this->taskService->domainCreate($this->domain, $ownerc, $adminc, $techc, $zonec, $nserver, $this->email, $ctid);
			$this->domainModel->response = 1;//serialize($result);
			$this->domainModel->save();
			
		} catch(TaskException $exception) {
			$this->domainModel->status = 'error';
			$this->domainModel->response = $exception->getMessage();
			$this->domainModel->save();
		}
	}
}
