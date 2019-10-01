<?php

namespace eSMS\Api;

class Sms {

	protected $client;
	protected $api;
	protected $fromName;
	protected $recipients = [];
	protected $message;

	public function __construct(Client $client, \eSMS\SmsClient $api) {
		$this->client = $client;
		$this->api = $api;
	}

	/**
	 * Set sender name
	 * @param string $name
	 * @return $this
	 */
	public function setFrom($name) {
		$this->fromName = $name;
		return $this;
	}

	/**
	 * Add recipient
	 * @param string $number
	 * @return $this
	 */
	public function addRecipient($number) {
		$this->recipients[] = $number;
		return $this;
	}

	/**
	 * Set message
	 * @param string $message
	 * @return $this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * Send simple textual message
	 * @return object response
	 */
	public function sendSimpleSMS() {
		if ($this->validateSms()) {
			$response = $this->client->request('post', '/sms/1/text/single', array('from' => $this->fromName, 'to' => $this->recipients, 'text' => $this->message));
			
			return json_decode($response->body);
		}
	}

	/**
	 * Validate SMS fields
	 * @return boolean
	 * @throws \Exception
	 */
	protected function validateSms() {
		if (!$this->fromName) {
			throw new \Exception('Not set "from". Use setFrom method.');
		}

		if (empty($this->recipients)) {
			throw new \Exception('Not set "recipients". Use addRecipient method.');
		}

		if (!$this->message || empty($this->message)) {
			throw new \Exception('Not set "message". Use setMessage method.');
		}

		return true;
	}

	/**
	 * Destroy SMS object
	 */
	public function destroy() {
		$this->fromName = null;
		$this->message = null;
		$this->recipients = [];
	}

}
