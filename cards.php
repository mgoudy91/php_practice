<h1>PHP war demo</h1>

<link rel="stylesheet" type="text/css" href="cardstyle.css">

<?php

	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

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

	    // Give spoils to winning deck
	    function give_spoils($spoils){
	    	while (count($spoils) > 0) {
	    		$card = array_pop($spoils);
	    		array_push($this->cards, $card);
	    	}
	    }

	    // Give cards to victor
	    function forfeit($victor){
	    	while (count($this->cards) > 0 ) {
	    		$card = $this->draw();
	    		$victor->add_card($card);
	    	}
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

		// Left wins basic fight
		if ($left_card->compare($right_card) == 1) {
			echo "<span class='left'>Left Deck wins</span></div>";
			$left_deck->add_card($left_card);
			$left_deck->add_card($right_card);
		}

		// Right wins basic fight
		else if ($left_card->compare($right_card) == -1){
			echo "<span class='right'>Right Deck wins</span></div>";
			$right_deck->add_card($right_card);
			$right_deck->add_card($left_card);
		}

		// War
		else{
			echo "It's <span class='war'>WAR</span>!</div>";
			$spoils = array();

			// Add initial cards to the pile
			array_push($spoils, $left_card);
			array_push($spoils, $right_card);

			// Make sure each side can fight
			if ($left_deck->card_count() > 3 && $right_deck->card_count() > 3) {

				// Throw three extras into the pile
				for ($j=0; $j < 3; $j++) { 
					$left_tribute = $left_deck->draw();
					$right_tribute = $right_deck->draw();
					echo "<div><span class='left'>Left Deck</span> adds " . $left_tribute->to_str() . ", <span class='right'>Right Deck</span> adds " . $right_tribute->to_str() . "</div>";
					array_push($spoils, $left_tribute);
					array_push($spoils, $right_tribute);
				}

				// Cards to represent eeach deck in war
				$left_card = $left_deck->draw();
				$right_card = $right_deck->draw();
				echo "<div class ='match'> War: " . $left_card->to_str() . " vs. " . $right_card->to_str() . "<br/>";

				// Left wins the war
				if ($left_card->compare($right_card) == 1){
					echo "<span class='left'>Left Deck wins</span></div>";
					array_push($spoils, $left_card);
					array_push($spoils, $right_card);
					$left_deck->give_spoils($spoils);

				// Right wins the war
				}else{
					echo "<span class='right'>Right Deck wins</span></div>";
					array_push($spoils, $left_card);
					array_push($spoils, $right_card);
					$right_deck->give_spoils($spoils);
				}
			}

			// Someone can't fight
			else if ($left_deck->card_count() <= 3){
				echo "but left deck can't fight!";
				$right_deck->give_spoils($spoils);
				$left_deck->forfeit($right_deck);
			}
			else{
				echo "but right deck can't fight!";
				$left_deck->give_spoils($spoils);
				$right_deck->forfeit($left_deck);
			}

		}

		echo "<div class='score'> Standings: <span class='left'>Left Deck " . $left_deck->card_count() . " cards</span>, <span class='right'>Right Deck " . $right_deck->card_count() . " cards</span></div>";
	}

	if ($left_deck->card_count()) {
		echo "<h2><span class='left'>Left Deck wins!</span></h2>";
	}elseif ($right_deck->card_count()) {
		echo "<h2><span class='right'>Right Deck wins!</span></h2>";
	}else{
		echo "<h2><span class='tie'>It was a Tie!</span></h2>";
	}

?>