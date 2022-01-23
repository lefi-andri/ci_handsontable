<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars extends CI_Controller {

	public function index()
	{
		$this->data = [
			'title' => 'Handsonetable'
		];

		$this->load->view('handsontable/index', $this->data, FALSE);
	}

	public function test_connection()
	{
		/*$dbh = new PDO('mysql:host=127.0.0.1:3309;dbname=ci_handsontable', 'root', '12345');

		try {
		    $dbh = new PDO('mysql:host=127.0.0.1:3309;dbname=ci_handsontable', 'root', '12345');
		    foreach($dbh->query('SELECT * from cars') as $row) {
		        print_r($row);
		    }
		    $dbh = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}*/
	}

	/*public function load()
	{
		try {
		  //open the database
		  $db = $this->getConnection();

		  // if(!$this->carsTableExists($db)){
		  //     $this->resetCarsTable($db);
		  // }

		  //select all data from the table
		  $result = $this->loadCars($db);

		  $out = array(
		    'cars' => $result->fetchAll(PDO::FETCH_ASSOC)
		  );

		  echo json_encode($out);

		  // close the database connection
		  $this->closeConnection($db);
		}
		catch (PDOException $e) {
		  print 'Exception : ' . $e->getMessage();
		}
	}*/

	public function load()
	{
		$result = $this->loadCars();

		$out = $result->result_array();

		$test = ['cars' => $out];

		echo json_encode($test);

		// echo '<pre>';
		// print_r($test);
		// echo '</pre>';
	}

	function getConnection(){
	    $db = new PDO('mysql:host=127.0.0.1:3309;dbname=ci_handsontable', 'root', '12345');
	    return $db;
	}

	function closeConnection ($db){
	    $db = NULL;
	}

	//create the database if does not exist
	// function createCarsTable($db){
	//     $db->exec("CREATE TABLE IF NOT EXISTS cars (id INTEGER PRIMARY KEY, manufacturer TEXT, year INTEGER, price INTEGER)");
	// }

	function createCarsTable(){

		$this->load->dbforge();

		$fields = array(
		        'id' => array(
		                'type' => 'INT',
		                'constraint' => 11,
		                'unsigned' => TRUE,
		                'auto_increment' => TRUE
		        ),
		        'manufacturer' => array(
		                'type' => 'TEXT',
		                'null' => TRUE,
		        ),
		        'year' => array(
		                'type' =>'INT',
		                'constraint' => '11',
		                'null' => TRUE,
		        ),
		        'price' => array(
		                'type' =>'INT',
		                'constraint' => '11',
		                'null' => TRUE,
		        ),
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('cars');

	}

	function resetCarsTable($db){
	    // $this->dropCarsTable($db);
	    $this->dropCarsTable();
	    // $this->createCarsTable($db);
	    $this->createCarsTable();
	    // $this->loadDefaultCars($db);
	    $this->loadDefaultCars();
	}

	/*function dropCarsTable($db){
	    $db->exec("DROP TABLE IF EXISTS cars");
	}*/

	function dropCarsTable(){
		
		$this->load->dbforge();

	    $this->dbforge->drop_table('cars');
	}

	/*function loadDefaultCars($db){
	    $query = $db->prepare('INSERT INTO cars (id, manufacturer, year, price) VALUES(:id, :manufacturer, :year, :price)');
	    
	    $data = array(
	        array(
	            'id' => 1,
	            'manufacturer' => 'Honda',
	            'year' => 2010,
	            'price' => 200000
	        ),
	        array(
	            'id' => 2,
	            'manufacturer' => 'Jaguar',
	            'year' => 2012,
	            'price' => 400000
	        ),
	        array(
	            'id' => 3,
	            'manufacturer' => 'BMW',
	            'year' => 2000,
	            'price' => 75000
	        ),
	        array(
	            'id' => 4,
	            'manufacturer' => 'Mercedes',
	            'year' => 1980,
	            'price' => 1000
	        )
	    );

	    foreach($data as $index => $value){
	        $query->bindValue(':id', $value['id'], PDO::PARAM_INT);
	        $query->bindValue(':manufacturer', $value['manufacturer'], PDO::PARAM_STR);
	        $query->bindValue(':year', $value['year'], PDO::PARAM_INT);
	        $query->bindValue(':price', $value['price'], PDO::PARAM_INT);
	        $query->execute();
	    }
	}*/

	function loadDefaultCars(){

		$data = array(
	        array(
	            'id' => 1,
	            'manufacturer' => 'Honda',
	            'year' => 2010,
	            'price' => 200000
	        ),
	        array(
	            'id' => 2,
	            'manufacturer' => 'Jaguar',
	            'year' => 2012,
	            'price' => 400000
	        ),
	        array(
	            'id' => 3,
	            'manufacturer' => 'BMW',
	            'year' => 2000,
	            'price' => 75000
	        ),
	        array(
	            'id' => 4,
	            'manufacturer' => 'Mercedes',
	            'year' => 1980,
	            'price' => 1000
	        )
	    );

		$this->db->insert_batch('cars', $data);

	}

	/*function loadCars($db){
	    $select = $db->prepare('SELECT * FROM cars ORDER BY id ASC LIMIT 100');
	    $select->execute();

	    return $select;
	}*/

	function loadCars(){

	    $this->db->select('*');
	    $this->db->from('cars');
	    $this->db->order_by('id', 'asc');
	    $this->db->limit(100);
	    return $this->db->get();
	}

	// function carsTableExists($db){
	//     $result = $db->query("SELECT COUNT(*) FROM ci_handsontable WHERE type='table' AND name='cars'");

	//     $row = $result->fetch(PDO::FETCH_NUM);

	//     return $row[0] > 0;
	// }


	/*public function save()
	{
		try {
		  //open the database
		  $db =  $this->getConnection();
		  // $this->createCarsTable($db);

		  $colMap = array(
		    0 => 'manufacturer',
		    1 => 'year',
		    2 => 'price'
		  );

		  if (isset($_POST['changes']) && $_POST['changes']) {
		    foreach ($_POST['changes'] as $change) {
		      $rowId  = $change[0] + 1;
		      $colId  = $change[1];
		      $newVal = $change[3];

		      if (!isset($colMap[$colId])) {
		        echo "\n spadam";
		        continue;
		      }

		      $select = $db->prepare('SELECT id FROM cars WHERE id=? LIMIT 1');
		      $select->execute(array(
		        $rowId
		      ));

		      if ($row = $select->fetch()) {
		        $query = $db->prepare('UPDATE cars SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');
		      } else {
		        $query = $db->prepare('INSERT INTO cars (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
		      }
		      $query->bindValue(':id', $rowId, PDO::PARAM_INT);
		      $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
		      $query->execute();
		    }
		  } elseif (isset($_POST['data']) && $_POST['data']) {
		    $select = $db->prepare('DELETE FROM cars');
		    $select->execute();

		    for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
		      $rowId = $r + 1;
		      for ($c = 0, $clen = count($_POST['data'][$r]); $c < $clen; $c++) {
		        if (!isset($colMap[$c])) {
		          continue;
		        }

		        $newVal = $_POST['data'][$r][$c];

		        $select = $db->prepare('SELECT id FROM cars WHERE id=? LIMIT 1');
		        $select->execute(array(
		          $rowId
		        ));

		        if ($row = $select->fetch()) {
		          $query = $db->prepare('UPDATE cars SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');
		        } else {
		          $query = $db->prepare('INSERT INTO cars (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');
		        }
		        $query->bindValue(':id', $rowId, PDO::PARAM_INT);
		        $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
		        $query->execute();
		      }
		    }
		  }

		  $out = array(
		    'result' => 'ok'
		  );
		  echo json_encode($out);

		  $this->closeConnection($db);
		}
		catch (PDOException $e) {
		  print 'Exception : ' . $e->getMessage();
		}
	}*/

	public function save()
	{
		try {
		  //open the database
		  $db =  $this->getConnection();
		  // $this->createCarsTable($db);

		  $colMap = array(
		    0 => 'manufacturer',
		    1 => 'year',
		    2 => 'price'
		  );

		  if (isset($_POST['changes']) && $_POST['changes']) {

		    foreach ($_POST['changes'] as $change) {
		      $rowId  = $change[0] + 1;
		      $colId  = $change[1];
		      $newVal = $change[3];

		      if (!isset($colMap[$colId])) {
		        echo "\n spadam";
		        continue;
		      }

		      $select = $db->prepare('SELECT id FROM cars WHERE id=? LIMIT 1');

		      $select->execute(array(
		        $rowId
		      ));

		      // $this->db->limit(1);
		      // $select = $this->db->get_where('cars', ['id' => $rowId]);

		      if ($row = $select->fetch()) {
		      // if ($select->num_rows() > 0) {
		      	

		        $query = $db->prepare('UPDATE cars SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');

		        // $object = [
		        // 	$colMap[$colId] => $newVal
		        // ];

		        // $this->db->where('id', $rowId);
		        // $query = $this->db->update('cars', $object);

		      } else {

		        $query = $db->prepare('INSERT INTO cars (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
		      
		      	// $object = [
		      	// 	'id' => $rowId,
		       //  	$colMap[$colId] => $newVal
		       //  ];

		       //  $query = $this->db->insert('cars', $object);
		      }

		      $query->bindValue(':id', $rowId, PDO::PARAM_INT);
		      $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
		      $query->execute();
		    }


		  } elseif (isset($_POST['data']) && $_POST['data']) {

		    $select = $db->prepare('DELETE FROM cars');
		    $select->execute();

		    for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
		      $rowId = $r + 1;
		      for ($c = 0, $clen = count($_POST['data'][$r]); $c < $clen; $c++) {
		        if (!isset($colMap[$c])) {
		          continue;
		        }

		        $newVal = $_POST['data'][$r][$c];

		        $select = $db->prepare('SELECT id FROM cars WHERE id=? LIMIT 1');

		        $select->execute(array(
		          $rowId
		        ));

		       //  $this->db->limit(1);
		      	// $select = $this->db->get_where('cars', ['id' => $rowId]);

		        if ($row = $select->fetch()) {
		      	// if ($select->num_rows() > 0) {

		        	// $object = [
			        // 	$colMap[$c] => $newVal
			        // ];

			        // $this->db->where('id', $rowId);
			        // $query = $this->db->update('cars', $object);

		          $query = $db->prepare('UPDATE cars SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');

		        } else {

		        	// $object = [
			      		// 'id' => $rowId,
			        // 	$colMap[$c] => $newVal
			        // ];

			        // $query = $this->db->insert('cars', $object);

		          $query = $db->prepare('INSERT INTO cars (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');

		        }

		        $query->bindValue(':id', $rowId, PDO::PARAM_INT);
		        $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
		        $query->execute();

		      }
		    }
		  }

		  $out = array(
		    'result' => 'ok'
		  );
		  echo json_encode($out);

		  $this->closeConnection($db);

		}

		catch (PDOException $e) {
		  print 'Exception : ' . $e->getMessage();
		}
	}

	/*public function reset()
	{
		try {
		    $db = $this->getConnection();
		    $this->resetCarsTable($db);
		    $this->closeConnection($db);
		}
		catch (PDOException $e) {
		    print 'Exception : ' . $e->getMessage();
		}
	}*/

	public function reset()
	{
		$this->resetCarsTable();
		$this->closeConnection();
	}

}

/* End of file Cars.php */
/* Location: ./application/controllers/Cars.php */