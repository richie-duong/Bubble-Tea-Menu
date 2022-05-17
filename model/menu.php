<?php
	class Menu{		

		private $id;
		private $name;
		private $price;
		public $image;
		private $dateAdded;
				
		function __construct($id, $name, $price, $dateAdded, $image){
			$this->setId($id);
			$this->setName($name);
			$this->setPrice($price);
			$this->setImage($image);
			$this->setDateAdded($dateAdded);
			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getPrice(){
			return $this->price;
		}
		
		public function setPrice($price){
			$this->price = $price;
		}

		public function getDateAdded(){
			return $this->dateAdded;
		}

		public function setDateAdded($dateAdded){
			$this->dateAdded = $dateAdded;
		}

		public function getImage(){
			return $this->image;
		}

		public function setImage($image){
			$this->image = $image;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>