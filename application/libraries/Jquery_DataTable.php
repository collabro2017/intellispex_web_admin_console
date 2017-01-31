<?php

class Jquery_DataTable {

	private $dtRequest;

	public function __construct($dtRequest) {
		$this->parseDtRequest($dtRequest);
	}

	private function parseDtRequest($dtRequest) {
		$resultColumns = array();
		foreach ($dtRequest['columns'] as $column) {
			$resultColumns[] = new JqdtColumn($column['data'], $column['name'], $column['orderable'], $column['searchable'], new JqdtSearch($column['search']['regex'], $column['search']['value']));
		}

		$resultOrderArray = array();
		foreach($dtRequest['order'] as $order) {
			$resultOrderArray[] = new JqdtOrder($order['dir'], $order['column']);
		}
		$this->dtRequest = new JqdtRequest($resultColumns, $dtRequest['draw'], $dtRequest['length'], $dtRequest['start'], $resultOrderArray, new JqdtSearch($dtRequest['search']['regex'], $dtRequest['search']['value']));
	}

	public function getDraw() {
		return $this->dtRequest->draw;
	}

	public function getLength() {
		return $this->dtRequest->length;
	}

	public function getStart() {
		return $this->dtRequest->start;
	}

	public function hasSearchValue() {
		return $this->dtRequest->search->hasSearchValue();
	}

	public function setSearchValue($newSearchValue) {
		$this->dtRequest->search->value = $newSearchValue;
	}

	public function getOrderName($index) {
		return $this->dtRequest->columns[$this->dtRequest->order[$index]->column]->data;
	}

	public function getOrderDir($index) {
		return $this->dtRequest->order[$index]->dir;
	}

	public function getSearchValue() {
		return $this->dtRequest->search->value;
	}

	public function getSearchableColumnDefs() {
		$searchables = array();
		foreach($this->dtRequest->columns as $column) {
			/**
			 * @var JqdtColumn
			 */
			$column;
			if ($column->searchable === 'true') {
				$searchables[] = $column->data;
			}
		}
		return $searchables;
	}

	/**
	 * @deprecated
	 * @param $recordsTotal
	 * @param $recordsFiltered
	 * @param $arrayData
	 * @return string
	 */
	public function getJsonResponse($recordsTotal, $recordsFiltered, $arrayData) {
		$json = '{';
		$json .= '"draw":'. $this->dtRequest->draw. ',';
		$json .= '"recordsTotal":'. $recordsTotal. ',';
		$json .= '"recordsFiltered":'. $recordsFiltered. ',';
		$json .= '"data":'. $this->arrayToDtJson($arrayData). '';
		$json .= '}';
		return $json;
	}

	/**
	 * @deprecated
	 * @param $recordsTotal
	 * @param $recordsFiltered
	 * @param $jsonData
	 * @return string
	 */
	public function getJsonResponseJsonData($recordsTotal, $recordsFiltered, $jsonData) {
		$json = '{';
		$json .= '"draw":'. $this->dtRequest->draw. ',';
		$json .= '"recordsTotal":'. $recordsTotal. ',';
		$json .= '"recordsFiltered":'. $recordsFiltered. ',';
		$json .= '"data":'. $jsonData. '';
		$json .= '}';
		return $json;
	}

	public function arrayToDtJson($array) {
		$str = '[';
		$count = 0;
		$total = count($array);
		foreach ($array as $object) {
			$count++;
			$str .= '{';
			$str .= $object;
			$str .= '}';

			if ($count < $total)
				$str .= ',';
		}
		$str .= ']';
		return $str;
	}

	/**
	 * Generate an array with the format data defined by DataTable Documentation.
	 *
	 * @param integer $recordsTotal
	 * @param integer $recordsFiltered
	 * @param array $arrayData
	 * @return array
	 */
	public function generateArrayData ( $recordsTotal, $recordsFiltered, $arrayData )
	{
		$generatedArray = [];
		$generatedArray[ 'draw' ] = (int) $this->dtRequest->draw;
		$generatedArray[ 'recordsTotal' ] = (int) $recordsTotal;
		$generatedArray[ 'recordsFiltered' ] = (int) $recordsFiltered;
		$generatedArray[ 'data' ] = $arrayData;

		return $generatedArray;
	}
}

class JqdtRequest {
	public $columns = array();
	public $draw;
	public $length;
	public $start;
	public $order = array();
	/**
	 * @var JqdtSearch
	 */
	public $search;

	public function __construct($columns, $draw, $length, $start, $order, JqdtSearch $search) {
		$this->columns = $columns;
		$this->draw = $draw;
		$this->length = $length;
		$this->start = $start;
		$this->order = $order;
		$this->search = $search;
	}
}

class JqdtColumn {
	public $data;
	public $name;
	public $orderable;
	public $searchable;
	/**
	 * JqdtSearch
	 */
	public $search;

	public function __construct($data, $name, $orderable, $searchable, JqdtSearch $search) {
		$this->data = $data;
		$this->name = $name;
		$this->orderable = $orderable;
		$this->searchable = $searchable;
		$this->search = $search;
	}
}

class JqdtSearch {
	public $regex;
	public $value;

	public function __construct($regex, $value) {
		$this->regex = $regex;
		$this->value = $value;
	}

	public function hasSearchValue() {
		if ($this->value === null || $this->value === '') {
			return false;
		} else {
			return true;
		}
	}
}

class JqdtOrder {
	public $dir;
	public $column;

	public function __construct($dir, $column) {
		$this->dir = $dir;
		$this->column = $column;
	}
}
