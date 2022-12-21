<?php

namespace eSMS\Api;

class Logs {

	protected $client;
	protected $limit = 50;
	protected $messageId = null;
	protected $bulkId = null;
	protected $to = null;
	protected $from = null;
	protected $sentSince = null;
	protected $sentUntil = null;
	protected $generalStatus = null;

	CONST STATUS_PENDING = 'PENDING';
	CONST STATUS_UNDELIVERABLE = 'UNDELIVERABLE';
	CONST STATUS_DELIVERED = 'DELIVERED';
	CONST STATUS_EXPIRED = 'EXPIRED';
	CONST STATUS_REJECTED = 'REJECTED';

	public function __construct(Client $client) {
		$this->client = $client;
	}

	/**
	 * Get SMS logs. SMS logs are available for the last 48 hours!
	 * @return object response
	 */
	public function get() {
		$response = $this->client->request('GET', "/sms/1/logs?limit={$this->limit}&messageId={$this->messageId}&bulkId={$this->bulkId}&to={$this->to}&from={$this->from}&sentSince={$this->sentSince}&sentUntil={$this->sentUntil}&generalStatus={$this->generalStatus}");

		return json_decode($response->body);
	}

	/**
	 * Maximal number of messages in returned logs. Default value is 50. Maximum value is 1000.
	 * @param integer $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}

	/**
	 * The ID that uniquely identifies the message sent.
	 * @param string $id
	 */
	public function setMessageId($id) {
		$this->messageId = $id;
	}

	/**
	 * The ID that uniquely identifies the request. Bulk ID will be received only when you send a message to more than one destination address
	 * @param string $id
	 */
	public function setBulkId($id) {
		$this->bulkId = $id;
	}

	/**
	 * The message destination address.
	 * @param string $number
	 */
	public function setTo($number) {
		$this->to = $number;
	}

	/**
	 * Sender ID that can be alphanumeric or numeric.
	 * @param string $number
	 */
	public function setFrom($number) {
		$this->from = $number;
	}

	/**
	 * Lower limit on date and time of sending SMS.
	 * @param string $date Format: YYYY-mm-dd
	 */
	public function setSentSince($date) {
		$this->sentSince = $date;
	}

	/**
	 * Upper limit on date and time of sending SMS.
	 * @param string $date Format: YYYY-mm-dd
	 */
	public function setSentUntil($date) {
		$this->sentUntil = $date;
	}

	/**
	 * Sent SMS status groupIndicates whether the message is successfully sent, not sent, delivered, not delivered, waiting for delivery or any other possible status.
	 * @param string $status Use Log handler const STATUS_*
	 */
	public function setGeneralStatus($status) {
		$this->generalStatus = $status;
	}

}
