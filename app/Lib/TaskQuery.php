<?php

namespace App\Lib\Data;

use App\Exceptions\TaskException;
use App\Exceptions\HttpException;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class TaskQuery {
	
	private $url;
	private $xmlData;
	private $ch;
	private $user;
	private $password;
	private $context;
	private $sessionHash;
	
	public function __construct($url, $user, $password, $context) {
		$this->url = $url;
		$this->user = $user;
		$this->password = $password;
		$this->context = $context;
		$this->init();
	}
	
	/**
	 * @return mixed
	 */
	public function getSessionHash() {
		return $this->sessionHash;
	}
	
	/**
	 * @param mixed $sessionHash
	 */
	public function setSessionHash($sessionHash) {
		$this->sessionHash = $sessionHash;
	}
	
	
	private function init() {
		$this->ch = curl_init();
		
		// fake user-agent for queue-worker needed
		$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'DomainPromo User Agnet Fake';
		
		curl_setopt($this->ch, CURLOPT_URL, env('TASK_URL'));
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, "$this->xmlData");
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($this->ch, CURLOPT_HEADER, 0);
		curl_setopt($this->ch, CURLOPT_HTTP_VERSION, 1.0);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $useragent);
	}
	
	/**
	 * @return mixed
	 */
	public function query() {
		$this->init();
		$errorMsg = false;
		$result = curl_exec($this->ch);
		
		if(curl_errno($this->ch)) {
			$errorMsg = 'ERROR -> ' . curl_errno($this->ch) . ': ' . curl_error($this->ch);
			throw new HttpException($errorMsg);
		} else {
			$returnCode = (int)curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
			switch($returnCode) {
				case 200:
					// transform the xml
					$xml = simplexml_load_string($result);
					$json = json_encode($xml);
					$result = json_decode($json, TRUE);
					
					// check if task was successful
					if($result['result']['status']['type'] === 'error') {
					
Log::debug("####################ERROR-->####################");
Log::debug($result);
Log::debug("####################<--ERROR####################");

						$errorMsg = "Something went wrong while querying task";
						if(isset($result['result']['msg']['text'])) {
							$errorMsg = $result['result']['msg']['text'];
						}
						elseif(isset($result['result']['msg']) && is_array($result['result']['msg'])) {
							$errorMsg = '';
							foreach($result['result']['msg'] as $msg) {
								$errorMsg .= "/".$msg['text'];
							}
						}
						throw new TaskException($errorMsg); 
					}
					
					break;
				default:
					$errorMsg = 'HTTP ERROR -> ' . $returnCode;
					throw new TaskException($errorMsg);
					break;
			}
		}
		
		curl_close($this->ch);
		
		return $result;
	}
	
	/**
	 * auth-session-create-task
	 *
	 * @return mixed
	 */
	public
	function authSessionCreate() {
		$this->xmlData = "<request>
	<auth>
		<user>$this->user</user>
		<context>$this->context</context>
		<password><![CDATA[$this->password]]></password>
	</auth>
	<task>
		<code>1321001</code>
		<auth_session>
			<timeout>21</timeout>
		</auth_session>
	</task>
</request>";
		
		$authResult = $this->query();
		
		// add session-hash to instance
		if(isset($authResult['result']['data']['auth_session']['hash'])) {
			$this->sessionHash = $authResult['result']['data']['auth_session']['hash'];
		}
		return $authResult;
	}
	
	
	/**
	 * domain-info-task
	 *
	 * @param $domain
	 * @return mixed
	 */
	public function domainInfo($domain) {
		$this->xmlData = "<request>
	<auth>
		<user>" . env("TASK_USER", false) . "</user>
		<context>" . env("TASK_CONTEXT", 1) . "</context>
		<password><![CDATA[" . env("TASK_PASSWORD", false) . "]]></password>
	</auth>
	<task>
		<code>0105</code>
		<domain>
			<name>$domain</name>
		</domain>
	</task>
</request>";
		return $this->query();
	}
	
	
	/**
	 * domain-create-task
	 *
	 * @param $domain
	 */
	public function domainCreate($domain, $ownerc, $adminc, $techc, $zonec, $nserver, $email, $ctid) {
		$nameservers = '';
		foreach($nserver as $ns) {
			$nameservers .= "<nserver><name>" . $ns['name'] . "</name></nserver>";
		}

		$this->xmlData = "<request>
	<auth>
		<user>" . env("TASK_USER", false) . "</user>
		<context>" . env("TASK_CONTEXT", false) . "</context>
		<password><![CDATA[" . env("TASK_PASSWORD", false) . "]]></password>
	</auth>
	<owner>
		<user>$this->user</user>
		<context>$this->context</context>
	</owner>
	<task>
		<code>0101</code>
		<domain>
			<name>$domain</name>
			<ownerc>$ownerc</ownerc>
			<adminc>$adminc</adminc>
			<techc>$techc</techc>
			<zonec>$zonec</zonec>
			$nameservers
			<confirm_order>1</confirm_order>
		</domain>
		<reply_to>$email</reply_to>
		<ctid>$ctid</ctid>
	</task>
</request>";
		
		Log::debug("###############DOMAIN-CREATE-REQUEST-->");
		Log::debug($this->xmlData);
		
		$result = $this->query();
		Log::debug("###############<--DOMAIN-CREATE-RESPONSE");
//		return $this->query();
		return $result;
	}
}
