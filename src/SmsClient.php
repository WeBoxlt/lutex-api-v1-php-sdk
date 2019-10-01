<?php

namespace eSMS;

use eSMS\Api\Client;

class SmsClient {

	/**
	 * @var username
	 */
	protected $username;

	/**
	 * @var password
	 */
	protected $password;

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @param string|null $username
	 * @param string|null $password
	 */
	public function __construct($username = null, $password = null) {
		if (is_null($username)) {
			throw new \Exception("Username is not provided");
		}
		if (is_null($password)) {
			throw new \Exception("Password is not provided");
		}
		$this->setUsername($username);
		$this->setPassword($password);

		$this->client = new Client($username, $password);
	}

	/**
	 * Destroy session
	 */
	public function destroy() {
		$this->setUsername(null);
		$this->setPassword(null);
	}

	/**
	 * Set username
	 * @param string $username
	 */
	protected function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * Set password
	 * @param string $password
	 */
	protected function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return \Api\Sms
	 */
	public function sms() {
		return new Api\Sms($this->client, $this);
	}

}
