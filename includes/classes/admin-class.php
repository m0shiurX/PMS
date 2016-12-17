<?php
	/**
	* The admins class
	* It contains all action and behaviours admins may have
	*/
	class Admins
	{

		private $dbh = null;

		public function __construct($db)
		{
			$this->dbh = $db->dbh;
		}

		public function loginAdmin($user_name, $user_pwd)
		{
			//Un-comment this to see a cryptogram of a user_pwd 
			// echo session::hashuser_pwd($user_pwd);
			// die;
			$request = $this->dbh->prepare("SELECT user_name, user_pwd FROM kp_user WHERE user_name = ?");
	        if($request->execute( array($user_name) ))
	        {
	        	// This is an array of objects.
	        	// Remember we setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); in config/dbconnection.php
	        	$data = $request->fetchAll();
	        	
	        	// But if things are right, the array should contain only one object, the corresponding user
	        	// so, we can do this
	        	$data = $data[0];

	        	return session::passwordMatch($user_pwd, $data->user_pwd) ? true : false;

	        }else{
	        	return false;
	        }

		}

		/**
		 * Check if the admin user_name is unique
		 * If though we've set this criteria in our database,
		 * It's good to make sure the user is not try that
		 * @param   $user_name The user_name
		 * @return Boolean If the user_name is already usedor not
		 * 
		 */
		public function adminExists( $user_name )
		{
			$request = $this->dbh->prepare("SELECT user_name FROM kp_dist WHERE user_name = ?");
			$request->execute([$user_name]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Compare two user_pwds
		 * @param String $user_pwd1, $user_pwd2 The two user_pwds
		 * @return  Boolean Either true or false
		 */

		public function ArepasswordSame( $user_pwd1, $user_pwd2 )
		{
			return strcmp( $user_pwd1, $user_pwd2 ) == 0;
		}

		
		/**
		 * Create a new row of admin
		 * @param String $user_name New admin user_name
		 * @param String $user_pwd New Admin user_pwd
		 * @return Boolean The final state of the action
		 * 
		 */
		
		public function addNewAdmin($user_name, $user_pwd, $email, $full_name, $address, $contact)
		{
			$request = $this->dbh->prepare("INSERT INTO kp_user (user_name, user_pwd, email, full_name, address, contact) VALUES(?,?,?,?,?,?) ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$user_name, session::hashPassword($user_pwd), $email, $full_name, $address, $contact]);
		}
		/**
		 * Fetch admins
		 */
		
		public function fetchAdmin($limit = 10)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_user  ORDER BY user_id DESC  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}



		/**
		 * Create a new row of product
		 * 
		 */
		public function addNewProduct($name, $unit, $details, $color, $length, $radious, $max, $min)
		{
			$request = $this->dbh->prepare("INSERT INTO kp_products (pro_name, pro_unit, pro_details, pro_color, pro_length, pro_radious, pro_max, pro_min) VALUES(?,?,?,?,?,?,?,?) ");

			return $request->execute([$name, $unit, $details, $color, $length, $radious, $max, $min]);
		}

		/**
		 * Check if a raw product exist
		 */
		public function productExists( $pro_name )
		{
			$request = $this->dbh->prepare("SELECT pro_name FROM kp_products WHERE pro_name = ?");
			$request->execute([$pro_name]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Raw Products
		 */
		public function addRawProduct($name, $unit, $details)
		{
			$request = $this->dbh->prepare("INSERT INTO kp_raw (raw_name, raw_unit, raw_details) VALUES(?,?,?) ");

			return $request->execute([$name, $unit, $details]);
		}

		/**
		 * Check if a raw product exist
		 */
		public function rawproductExists( $raw_name )
		{
			$request = $this->dbh->prepare("SELECT raw_name FROM kp_raw WHERE raw_name = ?");
			$request->execute([$raw_name]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Edit a product
		 */

		public function updateRawProduct($id, $name, $unit, $details)
		{
			$request = $this->dbh->prepare("UPDATE kp_raw SET raw_name = ?, raw_unit = ?, raw_details = ? WHERE raw_id = ? ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$name, $unit, $details, $id]);
		}

		/*UPDATE Products*/
		public function updateProduct($id, $name, $unit, $details, $color, $length, $radious, $max, $min)
		{
			$request = $this->dbh->prepare("UPDATE kp_products SET pro_name = ?, pro_unit = ?, pro_details = ?, pro_color = ?, pro_length = ?, pro_radious = ?, pro_max = ?, pro_min = ? WHERE pro_id = ? ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$name, $unit, $details, $color, $length, $radious, $max, $min, $id]);
		}
		/**
		 * Fetch products
		 */
		
		public function fetchProducts($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_products  ORDER BY pro_id  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}

		/**
		 * Fetch raw products
		 */
		public function fetchrawProducts($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_raw  ORDER BY raw_id  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}


		/**
		 *  Fetch one product
		 */
		
		public function getAProduct($id)
		{
			if (is_int($id)) 
			{
				$request = $this->dbh->prepare("SELECT * FROM kp_products WHERE pro_id = ?");
				if ($request->execute([$id])) {
					return $request->fetchAll(PDO::FETCH_ASSOC);
				}
				return false;
			}
			return false;
		}

		/**
		 *	Fetch a raw product
		 */

		public function getArawProduct($id)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_raw WHERE raw_id = ?");
			if ($request->execute([$id])) {
				return $request->fetchAll();
			}
			return false;
		}

		/**
		 * Delete a product
		 */
		public function deleteProduct($id)
		{
			$request = $this->dbh->prepare("DELETE FROM kp_products WHERE pro_id = ?");
			return $request->execute([$id]);
		}


		/*jjd*/
		public function deleterawProduct($id)
		{
			$request = $this->dbh->prepare("DELETE FROM kp_raw WHERE raw_id = ?");
			return $request->execute([$id]);
		}
	}