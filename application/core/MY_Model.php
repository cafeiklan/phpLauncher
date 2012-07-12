<?php
/**
 * @name		CodeIgniter Base Model
 * @author		Jens Segers
 * @contributor	Jamie Rumbelow <http://jamierumbelow.net>
 * @link		http://www.jenssegers.be
 * @license		MIT License Copyright (c) 2011 Jens Segers
 *
 * This model is based on Jamie Rumbelow's model with some personal modifications
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/*
 CodeIgniter My Model

 This model extension provides easy database access function for your models. It contains CRUD methods as well as before/after callbacks.
 Installation

 Place MYModel.php into the application/core folder. Make sure your models extend MYModel and you are ready to go!
 Usage

 Create a new model class with an appropriate name, that extends MY_Model. You are advised to fill in the following attributes:

 class Book_model extends MY_Model {

 protected $table = "books";
 protected $primary_key = "id";
 protected $fields = array("id", "author", "title", "published", "created_at");

 }

 $table: the name of the database table, if not set it will try to guess the table from the model's name: Book_model -> *books*
 $primary_key: the name of the primary key of your database, set to 'id' by default
 $fields: you table's fields, if not set 1 extra query will be performed to get these automatically. These are used to filter arrays before inserting and updating

 Methods

 get($id): get the record matching this id (or other primary key)
 get($key, $value): get the record matching these where parameters
 get_all(): get all records
 get_many($key, $value): get the records matching these where parameters
 count_all_results($key, $value): count all records matching these where parameters
 insert($data): insert a new record
 update($id, $data): update a record matching this id (or other primary key)
 delete($id): delete the record matching this id (or other primary key)
 dropdown($key, $value): creates a dropdown-friendly array based on the key/value
 skip_validation(TRUE): skip validation

 Some active record methods are also available, these can be used without the database table parameter:

 count_all(): count all records
 list_fields(): returns an array containing all database table fields

 All other active records are also available, these are immediately passed to the database class. This allows you to use chaining:

 $books = $this->book_model->order_by("author", "desc")->limit(50, 0)->get_many();

 Callbacks

 Callbacks are functions that are activated on specific occasions that allows you to hook custom logic into the CRUD process. This is a list of the available callback points:

 $before_create
 $after_create
 $before_update
 $after_update
 $before_get
 $after_get
 $before_delete

 $after_delete

 Example usage, add a timestamp whenever a book is created:

 class Bookmodel extends MYModel { public $before_create = array('timestamps');

 function timestamps($book) {
 $book['created_at'] = date('Y-m-d H:i:s');
 return $book;
 }

 }

 Validation

 This models provides a wrapper for CodeIgniter's form validation, it will check all declared rules before inserting or updating. To add rules, add them to the $this->validate array, like this:

 $this->validate[] = array(
 'field'   => 'username',
 'label'   => 'Username',
 'rules'   => 'required'
 );

 You can find more information about these rules here: http://codeigniter.com/userguide/libraries/formvalidation.html

 You can bypass the validation by calling skip_validation() before an insert or update.
 Contributors

 This model is based on Jamie Rumbelow's base model: https://github.com/jamierumbelow/codeigniter-base-model

 */

if (!defined("BASEPATH"))
	exit("No direct script access allowed");

class MY_Model extends CI_Model {

	/*
	 * Your database table, if not set the name will be guessed
	*/
	protected $table = NULL;

	/*
	 * The primary key name, by default set to 'id'
	*/
	protected $primary_key = 'id';

	/*
	 * The database table fields, used for filtering data arrays before inserting and updating
	* If not set, an additional query will be made to fetch these fields
	*/
	protected $fields = array();

	/*
	 * Callbacks, should contain an array of methods
	*/
	protected $before_create = array();
	protected $after_create = array();
	protected $before_update = array();
	protected $after_update = array();
	protected $before_get = array();
	protected $after_get = array();
	protected $before_delete = array();
	protected $after_delete = array();

	/*
	 * Validation, should contain validation arrays like the form validation
	*/
	protected $validate = array();

	/*
	 * Skip the validation
	*/
	protected $skip_validation = FALSE;
	
	protected $database = NULL;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		parent::__construct();
	}	
	
	/**
	 * Magic function that passes unrecognized method calls to the database class for chaining
	 *
	 * @param string $method
	 * @param array $params
	 * @return void
	 */
	public function __call($method, $params) {
		if (method_exists($this->_database(), $method)) {
			call_user_func_array(array($this->_database(), $method), $params);
			return $this;
		}		
	}

	/**
	 * Get a single record with matching WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 * @return object
	 */
	public function get() {
		$where = & func_get_args();
		$this->_set_where($where);

		$this->_callbacks('before_get', array($where));
		$row = $this->_database()->get($this->_table())->row_array();
		$row = $this->_callbacks('after_get', array($row));

		return $row;
	}

	/**
	 * Get a field value with matching WHERE parameters
	 *
	 * @param string $field_name
	 * @param array $where_array
	 * @return string
	 */
	public function get_field($field_name, $where_array) {
		$this->_database()->where($where_array);
	
		$this->_callbacks('before_get', array($where_array));
		$row = $this->_database()->get($this->_table())->row_array();
		$row = $this->_callbacks('after_get', array($row));
		return isset($row[$field_name]) ? $row[$field_name] : '';
	}	

	/**
	 * Get all records from the database
	 *
	 * @return array
	 */
	public function get_all() {
		$where = & func_get_args();
		$this->_set_where($where);

		$this->_callbacks('before_get', array($where));
		$result = $this->_database()->get($this->_table())->result_array();

		foreach ($result as &$row) {
			$row = $this->_callbacks('after_get', array($row));
		}

		return $result;
	}

	/**
	 * Get multiple records from the database with matching WHERE parameters
	 * Alias for get_all, created for when get_all does not sound good enough
	 *
	 * @param string $key
	 * @param string $val
	 * @return array
	 */
	public function get_many() {
		return $this->get_all();
	}

	/**
	 * Insert a new record into the database
	 * Returns the insert ID
	 *
	 * @param array $data
	 * @param bool $skip_validation
	 * @return integer
	 */
	public function insert($data, $skip_validation = FALSE) {
		$valid = TRUE;

		if ($skip_validation === FALSE) {
			$valid = $this->_run_validation($data);
		}

		if ($valid) {
			$data = $this->_callbacks('before_create', array($data));

			$data = array_intersect_key($data, array_flip($this->_fields()));
			$this->_database()->insert($this->_table(), $data);

			$this->_callbacks('after_create', array($data, $this->_database()->insert_id()));

			return $this->_database()->insert_id();
		} else {
			return FALSE;
		}
	}

	/**
	 * Update a record, specified by an ID.
	 *
	 * @param integer $id
	 * @param array $data
	 * @return integer
	 */
	public function update($primary_value, $data, $skip_validation = FALSE) {
		$valid = TRUE;

		$data = $this->_callbacks('before_update', array($data, $primary_value));

		if ($skip_validation === FALSE) {
			$valid = $this->_run_validation($data);
		}

		if ($valid) {
			$data = array_intersect_key($data, array_flip($this->_fields()));

			$result = $this->_database()->where($this->primary_key, $primary_value)->set($data)->update($this->_table());

			$this->_callbacks('after_update', array($data, $primary_value, $result));

			return $this->_database()->affected_rows();
		} else {
			return FALSE;
		}
	}

	/**
	 * Delete a row from the database based on a WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 * @return bool
	 */
	public function delete() {
		$where = & func_get_args();
		$this->_set_where($where);

		$this->_callbacks('before_delete', array($where));

		$result = $this->_database()->delete($this->_table());

		$this->_callbacks('after_delete', array($where, $result));

		return $this->_database()->affected_rows();
	}

	/**
	 * Count the number of rows based on a WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 * @return integer
	 */
	public function count_all_results() {
		$where = & func_get_args();
		$this->_set_where($where);

		return $this->_database()->count_all_results($this->_table());
	}

	/**
	 * Return a count of every row in the table
	 *
	 * @return integer
	 */
	public function count_all() {
		return $this->_database()->count_all($this->_table());
	}

	/**
	 * An easier limit function
	 *
	 * @param integer $limit
	 * @param integer $offset
	 */
	public function limit($limit = NULL, $offset = NULL) {
		if (is_numeric($limit) && is_numeric($offset)) {
			$this->_database()->limit($limit, $offset);
		} elseif (is_numeric($limit)) {
			$this->_database()->limit($limit);
		}
		return $this;
	}

	/**
	 * List all table fields
	 *
	 * @return array $fields
	 */
	public function list_fields() {
		return $this->_database()->list_fields($this->_table());
	}

	/**
	 * Retrieve and generate a dropdown-friendly array of the data
	 * in the table based on a key and a value.
	 *
	 * @param string $key
	 * @param string $value
	 * @return array $options
	 */
	public function dropdown() {
		$args = & func_get_args();

		if (count($args) == 2) {
			list($key, $value) = $args;
		} else {
			$key = $this->primary_key;
			$value = $args[0];
		}

		$this->_callbacks('before_get', array($key, $value));

		$result = $this->_database()->select(array($key, $value))->get($this->_table())->result_array();

		$options = array();
		foreach ($result as $row) {
			$row = $this->_callbacks('after_get', array($row));
			$options[$row->{$key}] = $row->{$value};
		}

		return $options;
	}

	/**
	 * Skip the insert validation for future calls
	 */
	public function skip_validation($bool = TRUE) {
		$this->skip_validation = $bool;
		return $this;
	}

	/**
	 * Run the specific callbacks, each callback taking a $data
	 * variable and returning it
	 */
	private function _callbacks($name, $params = array()) {
		$data = (isset($params[0])) ? $params[0] : FALSE;

		if (!empty($this->$name)) {
			foreach ($this->$name as $method) {
				$data = call_user_func_array(array($this, $method), $params);
			}
		}

		return $data;
	}

	/**
	 * Runs validation on the passed data.
	 *
	 * @return bool
	 */
	private function _run_validation($data) {
		if ($this->skip_validation) {
			return TRUE;
		}

		if (!empty($this->validate)) {
			foreach ($data as $key => $val) {
				$_POST[$key] = $val;
			}

			$this->load->library('form_validation');

			if (is_array($this->validate)) {
				$this->form_validation->set_rules($this->validate);

				return $this->form_validation->run();
			} else {
				return $this->form_validation->run($this->validate);
			}
		} else {
			return TRUE;
		}
	}

	/**
	 * Sets WHERE depending on the number of parameters, has 4 modes:
	 * 1. ($id) primary key value mode
	 * 2. (array("name"=>$name)) associative array mode
	 * 3. ("name", $name) custom key/value mode
	 * 4. ("id", array(1, 2, 3)) where in mode
	 */
	private function _set_where($params) {
		if (count($params) == 1) {
			if (!is_array($params[0] && !strstr($params[0], "'"))) {
				$this->_database()->where($this->primary_key, $params[0]);
			} else {
				$this->_database()->where($params[0]);
			}
		} elseif (count($params) == 2) {
			if (is_array($params[1])) {
				$this->_database()->where_in($params[0], $params[1]);
			} else {
				$this->_database()->where($params[0], $params[1]);
			}
		}
	}
	
	/**
	 * Return or fetch the database fields
	 */
	private function _fields() {
		if ($this->_table() && empty($this->fields)) {
			$this->fields = $this->_database()->list_fields($this->_table());
		}
		return $this->fields;
	}

	/**
	 * Return or guess the database table
	 */
	private function _table() {
		if ($this->table == NULL) {
			$this->load->helper('inflector');
			$class = preg_replace('#((_m|_model)$|$(m_))?#', '', strtolower(get_class($this)));
			$this->table = plural(strtolower($class));
		}
		return $this->table;
	}
	
	/**
	 * Return the set database
	 */
	private function _database() {
		if ($this->database == NULL) {
			$this->database = $this->db;
		}
		return $this->database;
	}	
}