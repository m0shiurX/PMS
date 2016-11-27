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

		public function loginAdmin($username, $password)
		{
			//Un-comment this to see a cryptogram of a password 
			// echo session::hashPassword($password);
			// die;
			$request = $this->dbh->prepare("SELECT user_name, user_pwd FROM kp_user WHERE user_name = ?");
	        if($request->execute( array($username) ))
	        {
	        	// This is an array of objects.
	        	// Remember we setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); in config/dbconnection.php
	        	$data = $request->fetchAll();
	        	
	        	// But if things are right, the array should contain only one object, the corresponding user
	        	// so, we can do this
	        	$data = $data[0];

	        	return session::passwordMatch($password, $data->password) ? true : false;

	        }else{
	        	return false;
	        }

		}

		/**
		 * Check if the admin username is unique
		 * If though we've set this criteria in our database,
		 * It's good to make sure the user is not try that
		 * @param   $username The username
		 * @return Boolean If the username is already usedor not
		 * 
		 */
		public function adminExists( $username )
		{
			$request = $this->dbh->prepare("SELECT user_name FROM kp_dist WHERE user_name = ?");
			$request->execute([$username]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Compare two passwords
		 * @param String $password1, $password2 The two passwords
		 * @return  Boolean Either true or false
		 */

		public function ArePasswordsSame( $password1, $password2 )
		{
			return strcmp( $password1, $password2 ) == 0;
		}

		
		/**
		 * Create a new row of admin
		 * @param String $username New admin username
		 * @param String $password New Admin password
		 * @return Boolean The final state of the action
		 * 
		 */
		
		public function addNewAdmin($username, $password)
		{
			$request = $this->dbh->prepare("INSERT INTO kp_user (user_name, user_pwd) VALUES(?,?) ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$username, session::hashPassword($password)]);
		}


		/**
		 * Create a new row of product
		 * 
		 */
		public function addNewProduct($name, $price, $expiry, $description)
		{
			$request = $this->dbh->prepare("INSERT INTO products (product_name, product_price, product_expires_on, product_description, created_on) VALUES(?,?,?,?,?) ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$name, $price, $expiry, $description, time()]);
		}


		/**
		 * Edit a product
		 */

		public function updateProduct($id, $name, $price, $expiry, $description)
		{
			$request = $this->dbh->prepare("UPDATE products SET product_name = ?, product_price = ?, product_expires_on = ?, product_description = ? WHERE id = ? ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$name, $price, $expiry, $description, $id]);
		}

		/**
		 * Fetch products
		 */
		
		public function fetchProducts($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM products  ORDER BY product_name  LIMIT $limit");
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
				$request = $this->dbh->prepare("SELECT * FROM products WHERE id = ?");
				if ($request->execute([$id])) {
					return $request->fetchAll();
				}
				return false;
			}
			return false;
		}

		/**
		 * Delete a product
		 */
		public function deleteProduct($id)
		{
			$request = $this->dbh->prepare("DELETE FROM products WHERE id = ?");
			return $request->execute([$id]);
		}

	}
