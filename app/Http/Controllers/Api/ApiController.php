<?php

namespace PowerMs\Http\Controllers\Api;

use Illuminate\Http\Request;
use PowerMs\Http\Controllers\Controller;

class ApiController extends Controller
{
	protected $statusCode=200;
	public function respondNotFound($message = 'Not Found!')
	{
		$this->statusCode=404;
		return $this->respondWithMessage($message);
	}

	public function respondError($message='Unknown Error! Please try again.',$data=[])
	{
		$this->statusCode=500;
		return $this->respondWithMessage($message,$data);
	}

	public function respondSuccess($message='Success',$data=[])
	{
		$this->statusCode=200;
		return $this->respondWithMessage($message,$data);
	}

	public function respondWithMessage($message, $data = [])
	{
		return $this->respond([
			'status' => [
				'message' => $message,
				'code' => $this->statusCode
			],
			'data' => $data
		]); 
	}

	public function respond($data, $headers = [])
	{
		return \Response::json($data, $this->statusCode, $headers);
	}

	
	
}
