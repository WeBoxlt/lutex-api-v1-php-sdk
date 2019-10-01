<?php

namespace eSMS\Api;

class Client {

	const API_ENDPOINT = "http://107.20.199.106/";
	const RETRY_COUNT = 1;
	const RETRY_DELAY = 600;

	private $options;
	private $username;
	private $password;

	function __construct($username, $password) {
		$this->options = array(
			CURLOPT_POST => 1,
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		);
		$this->username = $username;
		$this->password = $password;
	}

	function request($method, $url, $body = NULL, $additional = array()) {

		$headers = array(
			'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password),
		);
		array_push($headers, "Content-Type: application/json");

		for ($retry = self::RETRY_COUNT; $retry >= 0; $retry--) {

			if ($retry < self::RETRY_COUNT) {
				usleep(self::RETRY_DELAY * 1000);
			}

			$curl = curl_init();
			curl_setopt_array($curl, $this->options);

			$url = strtolower(substr($url, 0, 6)) == "https:" ? $url : self::API_ENDPOINT . $url;
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_URL, $url);

			if (is_array($body)) {
				if (!empty($body)) {
					$body = json_encode($body);
				}
			}

			if ($body) {
				curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
			}
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));

			$response = curl_exec($curl);

			if (is_string($response)) {
				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
				curl_close($curl);

				$headers = self::parseHeaders($response, $headerSize);

				$body = substr($response, $headerSize);

				if ($status >= 200 && $status <= 299) {
					return (object) array("body" => $body, "headers" => $headers);
				}

				$parsedResponse = json_decode($body);
				if (!$parsedResponse) {
					$parsedResponse = (object) array(
								'error' => (object) array(
									'message' => 'Error while parsing response',
									'code' => '1',
								),
					);
				}

				throw new \Exception($parsedResponse->requestError->serviceException->messageId);
			} else {
				$message = sprintf("%s (#%d)", curl_error($curl), curl_errno($curl));
				curl_close($curl);
				throw new \Exception($message);
			}
		}
	}

	function parseHeaders($response, $headerSize) {

		$headers = array();
		$header_text = \substr($response, 0, $headerSize);

		foreach (explode("\r\n", $header_text) as $i => $line)
			if ($i === 0)
				$headers['http_code'] = $line;
			else {
				$list = explode(': ', $line);
				if (count($list) == 2) {
					$headers[$list[0]] = $list[1];
				}
			}
		return $headers;
	}

}
