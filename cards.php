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

		function __construct($full_deck){
			$this->cards = array();
			$this->points = 0;

			// Create each card in a deck if needed
			if($full_deck){
				for ($i=0; $i < count(Card::$suits); $i++) { 
					for ($j=0; $j < count(Card::$values); $j++) { 
						$new_card = new Card($j, $i);
						array_push($this->cards, $new_card);
					}
				}
			}
	    }

	    // Deal cards in each deck
	    function deal($left_deck, $right_deck){
	    	while (count($this->cards) > 1) {
	    		$card1 = array_pop($this->cards);
	    		$card2 = array_pop($this->cards);
	    		array_push($left_deck->cards, $card1);
	    		array_push($right_deck->cards, $card2);
	    	}

	    }

	    // Print deck info for dev purposes 
	    function deck_dump(){
	    	echo "Card count: " . count($this->cards) . "<br/>";
	    	foreach ($this->cards as $card) {
	    		echo $card->to_str();
	    	}
	    }

	    // Add a point to the deck's score
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

	    // Add card to deck
	    function add_card($card){
	    	array_unshift($this->cards, $card);
	    }

	    // Count cards in deck
	    function card_count(){
	    	return count($this->cards);
	    }
	}

	// source deck
	$source_deck = new Deck(true);
	// player decks
	$left_deck = new Deck(false);
	$right_deck = new Deck(false);

	$source_deck->shuffle();
	$source_deck->deal($left_deck, $right_deck);


	// Play war
	$i = 0;
	while ($left_deck->card_count() > 0 && $right_deck->card_count()) {
		$i++;
		$left_card = $left_deck->draw();
		$right_card = $right_deck->draw();
		echo "<div class ='match'> Match " . $i . ": " . $left_card->to_str() . " vs. " . $right_card->to_str() . "<br/>";

		if ($left_card->compare($right_card) == 1) {
			echo "<span class='left'>Left Deck wins</span></div>";
			$left_deck->add_card($left_card);
			$left_deck->add_card($right_card);
		}
		else if ($left_card->compare($right_card) == -1){
			echo "<span class='right'>Right Deck wins</span></div>";
			$right_deck->add_card($right_card);
			$right_deck->add_card($left_card);
		}
		else{
			echo "It's a <span class='tie'>Tie</span>!</div>";
		}

		echo "<div class='score'> Score is <span class='left'>Left Deck: " . $left_deck->card_count() . " cards</span>, <span class='right'>Right Deck: " . $right_deck->card_count() . " cards</span></div>";
	}

	if ($left_deck->card_count()) {
		echo "<h2><span class='left'>Left Deck wins!</span></h2>";
	}elseif ($right_deck->card_count()) {
		echo "<h2><span class='right'>Right Deck wins!</span></h2>";
	}else{
		echo "<h2><span class='tie'>It was a Tie!</span></h2>";
	}

?>