<h1>PHP cards demo</h1>

<?php

	class Card{
		public $value_num;
		public $suit_num;

		public static $suits = array(0=>"spades", 1=>"hearts", 2=>"clubs", 3=>"diamonds");
		public static $values = array("ace", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "jack", "queen", "king");

		function __construct($value_num, $suit_num){
			$this->value_num = $value_num;
			$this->suit_num = $suit_num;
	    }

	    // Greater than
	    // function greater_than($other_card){
	    // 	if ($this->) {
	    // 		# code...
	    // 	}
	    // }

	    //Print Card info
		function to_str(){
			return "The " . $this->card_number() . " of " . $this->card_suit();
		}

		// Get string of number
		function card_number(){
			return Card::$values[$this->value_num];
		}

		// Get string of name
		function card_suit(){
			return Card::$suits[$this->suit_num];
		}
	}

	class Deck{
		private $cards;

		function __construct(){
			$this->cards = array();

			// Create each card in a deck
			for ($i=0; $i < count(Card::$suits); $i++) { 
				for ($j=0; $j < count(Card::$values); $j++) { 
					$new_card = new Card($j, $i);
					array_push($this->cards, $new_card);
				}
			}
	    }

	    // Print deck info for dev purposes 
	    function deck_dump(){
	    	echo "Card count: " . count($this->cards) . "<br/>";
	    	foreach ($this->cards as $card) {
	    		echo $card->to_str();
	    	}
	    }

	    // Shuffle deck
	    function shuffle(){
	    	shuffle($this->cards);
	    }

	    // Draw a card
	    function draw(){
	    	return array_pop($this->cards);
	    }
	}

	// create Decks and shuffle
	$left_deck = new Deck();
	$left_deck->shuffle();

	$right_deck = new Deck();
	$right_deck->shuffle();


	// Play war
	while (count($left_deck) > 0) {
		$left_card = $left_deck->draw();
		$right_card = $right_deck->draw();
		echo $left_card->to_str() . " vs. " . $right_card->to_str() . " <br/>";
	}
	

?>