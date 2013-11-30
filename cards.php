<h1>PHP cards demo</h1>

<?php

	class Card{
		public $value;
		public $figure;

		function __construct($value, $figure){
			$this->value = $value;
			$this->figure = $figure;
	    }

		function to_str(){
			return "The " . $this->value . " of " . $this->figure . "<br/>";
		}
	}

	class Deck{
		private $cards;

		private $suits = array("spades", "hearts", "clubs", "diamonds");
		private $values = array("ace", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "jack", "queen", "king");


		function __construct(){
			$this->cards = array();

			foreach ($this->suits as $suit) {
				foreach ($this->values as $value) {
					$new_card = new Card($value, $suit);
					array_push($this->cards, $new_card);
				}
			}

	    }

	    function deck_dump(){
	    	echo "Card count: " . count($this->cards) . "<br/>";
	    	foreach ($this->cards as $card) {
	    		echo $card->to_str();
	    	}
	    }

	    function shuffle(){
	    	shuffle($this->cards);
	    }

	    function draw(){
	    	return array_pop($this->cards);
	    }
	}

	$my_deck = new Deck();
	$my_deck->shuffle();
	echo $my_deck->draw()->to_str();

?>