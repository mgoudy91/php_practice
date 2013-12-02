<h1>PHP war demo</h1>

<link rel="stylesheet" type="text/css" href="cardstyle.css">

<?php

	class Card{
		public $value_num;
		public $suit_num;

		public static $suits = array("spades", "hearts", "clubs", "diamonds");
		public static $values = array( "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "jack", "queen", "king", "ace");

		function __construct($value_num, $suit_num){
			$this->value_num = $value_num;
			$this->suit_num = $suit_num;
	    }

	    // Compare cards
	    // return 1 if this card is greater, -1 if other_card is greater, 0 if same
	    function compare($other_card){

	    	// This greater
	    	if (($this->value_num) > ($other_card->value_num)) {
	    		return 1;
	    	}

	    	// Other greater
	    	else if (($this->value_num) < ($other_card->value_num)) {
	    		return -1;
	    	}

	    	// Equal
	    	else{
	    		return 0;
	    	}
	    }

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

		public $points;

		function __construct(){
			$this->cards = array();
			$this->points = 0;

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

	    function add_point(){
	    	$this->points = $this->points + 1;
	    }

	    // Shuffle deck
	    function shuffle(){
	    	shuffle($this->cards);
	    }

	    // Draw a card
	    function draw(){
	    	return array_pop($this->cards);
	    }

	    // Count cards in deck
	    function card_count(){
	    	return count($this->cards);
	    }
	}

	// create Decks and shuffle
	$left_deck = new Deck();
	$left_deck->shuffle();

	$right_deck = new Deck();
	$right_deck->shuffle();


	// Play war
	$i = 0;
	while ($left_deck->card_count() > 0) {
		$i++;
		echo "<div class='score'> Score is <span class='left'>Left Deck: " . $left_deck->points . "</span>, <span class='right'>Right Deck: " . $right_deck->points . "</span></div>";
		$left_card = $left_deck->draw();
		$right_card = $right_deck->draw();
		echo "<div class ='match'> Match " . $i . ": " . $left_card->to_str() . " vs. " . $right_card->to_str() . "<br/>";

		if ($left_card->compare($right_card) == 1) {
			echo "<span class='left'>Left Deck wins</span></div>";
			$left_deck->add_point();
		}
		else if ($left_card->compare($right_card) == -1){
			echo "<span class='right'>Right Deck wins</span></div>";
			$right_deck->add_point();
		}
		else{
			echo "It's a <span class='tie'>Tie</span>!</div>";
		}
	}

	if ($left_deck->points > $right_deck->points) {
		echo "<h2><span class='left'>Left Deck wins!</span></h2>";
	}elseif ($left_deck->points < $right_deck->points) {
		echo "<h2><span class='right'>Right Deck wins!</span></h2>";
	}else{
		echo "<h2><span class='tie'>It was a Tie!</span></h2>";
	}

?>