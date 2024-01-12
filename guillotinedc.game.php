<?php
 /**
  *------
  * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
  * guillotinedc implementation : © <Your name here> <Your email address here>
  * 
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  * 
  * guillotinedc.game.php
  *
  * This is the main file for your game logic.
  *
  * In this PHP file, you are going to defines the rules of the game.
  *
  */


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );
require_once('modules/constants.inc.php');
require_once('modules/GLTGuillotineScorer.class.php');
require_once('modules/GLTParliamentScorer.class.php');
require_once('modules/GLTQueensScorer.class.php');
require_once('modules/GLTRoyaltyScorer.class.php');
require_once('modules/GLTSpadesScorer.class.php');

class guillotinedc extends Table
{
	function __construct( )
	{
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();
        
        self::initGameStateLabels([
            DEALER => 10,
            SELECTED_GAME => 11,
            TRICK_SUIT => 12,
            SPINNER => 13,
            ACE_PLAYED => 14,
            OUT_FIRST => 15,
            OUT_SECOND => 16,
        ]);

        $this->cards = self::getNew("module.common.deck");
        $this->cards->init("card");
	}
	
    protected function getGameName( )
    {
		// Used for translations and stuff. Please do not modify.
        return "guillotinedc";
    }	

    /*
        setupNewGame:
        
        This method is called only once, when a new game is launched.
        In this method, you must setup the game according to the game rules, so that
        the game is ready to be played.
    */
    protected function setupNewGame( $players, $options = array() )
    {    
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = self::getGameinfos();
        $default_colors = $gameinfos['player_colors'];
 
        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
        $values = array();
        foreach( $players as $player_id => $player )
        {
            $color = array_shift( $default_colors );
            $values[] = "('".$player_id."','$color','".$player['player_canal']."','".addslashes( $player['player_name'] )."','".addslashes( $player['player_avatar'] )."')";
        }
        $sql .= implode( $values, ',' );
        self::DbQuery( $sql );
        self::reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
        self::reloadPlayersBasicInfos();

        $this->initPlayerGameState();
        
        /************ Start the game initialization *****/

        // Init global values with their initial values

        $cards = [];
        foreach ($this->suits as $suit_id => $suit) {
            for ($value=7; $value<=14; $value++) { // only cards 7 and up
                $cards[] = ['type' => $suit_id, 'type_arg' => $value, 'nbr' => 1];
            }
        }

        $this->cards->createCards($cards, 'deck');

        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)

        // TODO: setup the initial game situation here

        // To keep it at the player initially selected we'll go back twice, so when
        // the new hand is dealt and it advances one it'll be at the current player.
        self::setGameStateInitialValue(DEALER, self::getPlayerBefore(self::getPlayerBefore($this->activeNextPlayer())));

        /************ End of the game initialization *****/
    }

    /*
        getAllDatas: 
        
        Gather all informations about current game situation (visible by the current player).
        
        The method is called each time the game interface is displayed to a player, ie:
        _ when the game starts
        _ when a player refreshes the game page (F5)
    */
    protected function getAllDatas()
    {
        $result = array();
    
        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!

        $selected_game_id = self::getGameStateValue(SELECTED_GAME);
        $selected_game = null;
        $selected_game_type = null;
        if ($selected_game_id) {
            $selected_game = $this->games[$selected_game_id]['name'];
            $selected_game_type = $this->games[$selected_game_id]['type'];
        }

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb( $sql );

        $player_game_states = [];
        foreach ($result['players'] as $player) {
            $player_game_states[$player['id']] = $this->gameStates($player['id']);
        }

        $result['player_game_states'] = $player_game_states;
        $result[DEALER] = self::getGameStateValue(DEALER);
        $result[HAND] = $this->cards->getCardsInLocation(HAND, $current_player_id);
        $result[SELECTED_GAME] = $selected_game;
        $result[SELECTED_GAME_TYPE] = $selected_game_type;
        $result[CARDS_ON_TABLE] = $this->cards->getCardsInLocation(CARDS_ON_TABLE);
        $result[SPINNER] = self::getGameStateValue(SPINNER);
  
        return $result;
    }

    /*
        getGameProgression:
        
        Compute and return the current game progression.
        The number returned must be an integer beween 0 (=the game just started) and
        100 (= the game is finished or almost finished).
    
        This method is called each time we are in a game state with the "updateGameProgression" property set to true 
        (see states.inc.php)
    */
    function getGameProgression()
    {
        // TODO: compute and return the game progression

        return 0;
    }


//////////////////////////////////////////////////////////////////////////////
//////////// Utility functions
////////////    

    /*
        In this space, you can put any utility methods useful for your game logic
    */
    function checkPlayableCard($player_id, $current_card) {
        $current_trick_suit = self::getGameStateValue(TRICK_SUIT);
        $hand = $this->cards->getPlayerHand($player_id);

        if ($current_card['type'] != $current_trick_suit) {
            if (array_column($hand, null, 'type')[$current_trick_suit] ?? false) {
                throw new BgaUserException(self::_("You must follow suit if you are able to"));
            }
        }
    }

    function checkPlayableCardForDominoes($current_card) {
        $cards_on_table = $this->cards->getCardsInLocation(CARDS_ON_TABLE);

        // This will be the first card on the table, so we're good
        if (count($cards_on_table) == 0) return;
        // The card is a spinner, so it's good to play
        if (self::getGameStateValue(SPINNER) == $current_card['type_arg']) return;
        
        $cards_of_played_suit = array_filter($cards_on_table, function($card) use (&$current_card) {
            return $card['type'] == $current_card['type'];
        });

        if (count($cards_of_played_suit) == 0) {
            throw new BgaUserException(self::_("Your card cannot be played because the spinner for the suit hasn't been played yet"));
        }

        $played_card_values = array_column($cards_of_played_suit, null, 'type_arg');
        if (!($played_card_values[$current_card['type_arg'] - 1] ?? false) &&
            !($played_card_values[$current_card['type_arg'] + 1] ?? false))
        {
            throw new BgaUserException(self::_("Your card must be a spinner or one higher or lower in value than a card already played"));
        }
    }

    function gameStates($player_id, $available_only = false) {
        $game_sql = "SELECT player_game_id, player_id, game_id, played FROM player_game WHERE player_id=$player_id";

        if ($available_only) {
            $game_sql .= " AND played=0";
        }

        $available_games = self::getCollectionFromDb($game_sql);
        $game_states = [];
        foreach ($available_games as &$player_game) {
            $current_game = $this->games[$player_game['game_id']];
            $game_states[] = [
                'player_id' => $player_id,
                'game_id' => $player_game['game_id'],
                'game_type' => $current_game['type'],
                'game_name' => $current_game['name'],
                'played' => $player_game['played']
            ];
        }

        return $game_states;
    }

    function getScorer() {
        $scorer = null;

        $selected_game_id = self::getGameStateValue(SELECTED_GAME);
        switch ($selected_game_id) {
            case 1:
                $scorer = new GLTParliamentScorer();
                break;
            case 2:
                $scorer = new GLTSpadesScorer();
                break;
            case 3:
                $scorer = new GLTQueensScorer();
                break;
            case 4:
                $scorer = new GLTRoyaltyScorer();
                break;
            
            default:
                throw new BgaUserException(sprintf(self::_("The selected game id, %s, does not have a scorer"), $selected_game_id));
                break;
        }

        return $scorer;
    }

    function higherCard($higher_card, $new_card) {
        if ($higher_card === null) return $new_card;
        if ($new_card === null) return $higher_card;

        if ($higher_card['type_arg'] == 10) {
            if ($new_card['type_arg'] == 14) return $new_card;
            else return $higher_card;
        } else if ($new_card['type_arg'] == 10) {
            if ($higher_card['type_arg'] == 14) return $higher_card;
            else return $new_card;
        } else if ($new_card['type_arg'] > $higher_card['type_arg']) {
            return $new_card;
        } else return $higher_card;
    }

    function initPlayerGameState() {
        // Populate games to play for player
        $players = $this->loadPlayersBasicInfos();

        $game_sql = "INSERT INTO player_game (player_id, game_id) VALUES ";
        $game_values = [];
        foreach ($players as $player_id => $player) {
            foreach ($this->games as $game_id => $game) {
                $game_values[] = "('$player_id', '$game_id')";
            }
        }

        $game_sql .= implode($game_values, ',');
        self::DbQuery($game_sql);
    }

    function recordSelectedGame($player_id, $game_id) {
        self::DbQuery("UPDATE player_game SET played=1 WHERE player_id='$player_id' AND game_id='$game_id'");
    }

    function resetTrackingValues() {
        self::setGameStateValue(SELECTED_GAME, 0);

        // Dominoes
        self::setGameStateValue(OUT_FIRST, 0);
        self::setGameStateValue(OUT_SECOND, 0);
        self::setGameStateValue(SPINNER, 0);
    }

    function sortCards ($a, $b): int {
        return $a['type'] * 100 + $a['type_arg'] <=> $b['type'] * 100 + $b['type_arg'];
    }

    function updateScores($players, $player_to_points) {
        foreach ($player_to_points as $player_id => $points) {
            $sql = "UPDATE player SET player_score=player_score+$points WHERE player_id='$player_id'";
            self::DbQuery($sql);
            self::notifyAllPlayers("points", clienttranslate('${player_name} gained ${points} points'), [
                'player_name' => $players[$player_id]['player_name'],
                'points' => $points,
                'player_id' => $player_id,
            ]);
        }

        $new_scores = self::getCollectionFromDb("SELECT player_id, player_score FROM player", true);
        self::notifyAllPlayers("newScores", '', ['newScores' => $new_scores]);

        $this->gamestate->nextState("nextHand");
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
//////////// 

    /*
        Each time a player is doing some game action, one of the methods below is called.
        (note: each method below must match an input method in guillotinedc.action.php)
    */

    function gameSelection($selected_game) {
        self::checkAction("gameSelection");

        $player_id = self::getActivePlayerId();

        $game_id = null;
        $game_name = null;
        foreach ($this->games as $id => $game) {
            if ($game['type'] == $selected_game) {
                $game_id = $id;
                $game_name = $game['name'];
                break;
            }
        }

        self::setGameStateValue(SELECTED_GAME, $game_id);
        $this->recordSelectedGame($player_id, $game_id);

        self::notifyAllPlayers('gameSelection', clienttranslate('${player_name} selects ${game_name} as the game to play'), [
            'i18n' => ['game_name'],
            'player_name' => self::getActivePlayerName(),
            'dealer_id' => $player_id,
            'game_name' => $game_name,
            'game_type' => $selected_game,
        ]);

        if ($selected_game == 'dominoes') {
            $this->gamestate->nextState("dominoesSelectSpinner");
        } else {
            $this->gamestate->nextState("startHand");
        }
    }

    function pass() {
        self::checkAction("pass");

        // TODO: Need to ensure the user didn't have a card they could have played.

        self::setGameStateValue(ACE_PLAYED, 0);

        self::notifyAllPlayers('pass', clienttranslate('${player_name} passed'), [
            'player_name' => self::getActivePlayerName()
        ]);

        $this->gamestate->nextState("turnTaken");
    }

    function playCard($card_id) {
        self::checkAction("playCard");

        $player_id = self::getActivePlayerId();
        $current_card = $this->cards->getCard($card_id);

        $selected_game_id = self::getGameStateValue(SELECTED_GAME);
        if ($this->games[$selected_game_id]['type'] == "dominoes") {
            $this->checkPlayableCardForDominoes($current_card);

            $this->cards->moveCard($card_id, CARDS_ON_TABLE, $player_id);

            if (!self::getGameStateValue(SPINNER)) self::setGameStateValue(SPINNER, $current_card['type_arg']);

            if (($current_card['type_arg'] == ACE) && (self::getGameStateValue(SPINNER) != ACE)) {
                self::setGameStateValue(ACE_PLAYED, 1);
            }

            self::notifyAllPlayers('playCardForDominoes', clienttranslate('${player_name} plays ${suit_displayed}${value_displayed}'), [
                'player_name' => self::getActivePlayerName(),
                'suit_displayed' => $this->suits[$current_card['type']]['name'],
                'value_displayed' => $this->values_label[$current_card['type_arg']],
                'suit' => $current_card['type'],
                'value' => $current_card['type_arg'],
                'card_id' => $card_id,
                'player_id' => $player_id,
                'spinner' => self::getGameStateValue(SPINNER)
            ]);

            $this->gamestate->nextState("turnTaken");
        } else {
            $this->checkPlayableCard($player_id, $current_card);

            $this->cards->moveCard($card_id, CARDS_ON_TABLE, $player_id);
    
            if (!self::getGameStateValue(TRICK_SUIT)) self::setGameStateValue(TRICK_SUIT, $current_card['type']);
    
            self::notifyAllPlayers('playCard', clienttranslate('${player_name} plays ${suit_displayed}${value_displayed}'), [
                'player_name' => self::getActivePlayerName(),
                'suit_displayed' => $this->suits[$current_card['type']]['name'],
                'value_displayed' => $this->values_label[$current_card['type_arg']],
                'suit' => $current_card['type'],
                'value' => $current_card['type_arg'],
                'card_id' => $card_id,
                'player_id' => $player_id
            ]);

            $this->gamestate->nextState("cardPlayed");
        }
    }

    
//////////////////////////////////////////////////////////////////////////////
//////////// Game state arguments
////////////

    /*
        Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
        These methods function is to return some additional information that is specific to the current
        game state.
    */
    function argDominoesPlayerTurn() {
        $cards_in_hands = $this->cards->getCardsInLocation(HAND);
        if (count($cards_in_hands) == 32) {
            return [
                'play_message' => clienttranslate('the spinner'),
                'passable' => false,
            ];
        }

        $play_message = clienttranslate('a card or pass');
        if (self::getGameStateValue(ACE_PLAYED)) {
            $play_message = $play_message . clienttranslate(' (using Ace)');
        }
        return [
            'play_message' => $play_message,
            'passable' => true,
        ];
    }

    function argPlayerTurn() {
        // Determine cards that are eligble to play, for now just pass through
        return [];
    }

    function argSelectGame() {
        $player_id = self::getActivePlayerId();

        return [
            "available_games" => $this->gameStates($player_id, true)
        ];
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Game state actions
////////////

    /*
        Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
        The action method of state X is called everytime the current game state is set to X.
    */
    function stDominoesEndHand() {
        $players = self::loadPlayersBasicInfos();
        $player_to_points = [];
        foreach (array_keys($players) as $player_id) {
          $player_to_points[$player_id] = 0;
        }

        $player_to_points[self::getGameStateValue(OUT_FIRST)] = -30;
        $player_to_points[self::getGameStateValue(OUT_SECOND)] = -10;

        self::notifyAllPlayers('cleanUp', '', []);

        $this->updateScores($players, $player_to_points);
    }
    
    function stDominoesNextPlayer() {
        $end_hand = false;

        $players = self::loadPlayersBasicInfos();
        $player_id = self::getActivePlayerId();

        // Being the first person out while using an Ace causes some issues.
        // - It doesn't auto pass the player.
        // - It also ends the game early and gives that player second place scoring...
        // - Bonus should notify players when a person goes out of cards and show in UI some where
        $hand = $this->cards->getCardsInLocation(HAND, $player_id);
        if (count($hand) === 0) {
            $order = '';
            if (self::getGameStateValue(OUT_FIRST)) {
                self::setGameStateValue(OUT_SECOND, $player_id);
                $end_hand = true;
                $order = clienttranslate('second');
            } else {
                self::setGameStateValue(OUT_FIRST, $player_id);
                $order = clienttranslate('first');
            }

            self::setGameStateValue(ACE_PLAYED, 0);

            self::notifyAllPlayers('playerOutDominioes', clienttranslate('${player_name} went out ${order}'), [
                'player_id' => $player_id,
                'player_name' => $players[$player_id]['player_name'],
                'order' => $order,
            ]);
        }

        if ($end_hand) {
            $this->gamestate->nextState("endHand");
        } else {
            if (!self::getGameStateValue(ACE_PLAYED)) {
                $player_id = self::activeNextPlayer();
                self::giveExtraTime($player_id);
            }

            $this->gamestate->nextState("nextPlayer");
        }
    }

    function stEndHand() {
        $players = self::loadPlayersBasicInfos();
        $cards = $this->cards->getCardsInLocation(CARDS_WON);
        $scorer = $this->getScorer();

        $player_to_points = $scorer->score(array_keys($players), $cards);

        $this->updateScores($players, $player_to_points);
    }

    function stNewHand() {
        // TODO: increament hand count stat

        $new_dealer_id = self::getPlayerAfter(self::getGameStateValue(DEALER));
        self::setGameStateValue(DEALER, $new_dealer_id);
        $this->gamestate->changeActivePlayer($new_dealer_id);

        $this->cards->moveAllCardsInLocation(null, DECK);
        $this->cards->shuffle(DECK);
        // Deal 8 cards to each player
        $players = self::loadPlayersBasicInfos();
        foreach ($players as $player_id => $player) {
            $cards = $this->cards->pickCards(8, DECK, $player_id);
            // Notify player about their cards
            self::notifyPlayer($player_id, 'newHand', '', ['cards' => $cards]);
        }

        self::notifyAllPlayers('newRound', '', [
            'dealer_id' => $new_dealer_id
        ]);

        $this->resetTrackingValues();

        $this->gamestate->nextState("selectGame");
    }

    function stNewTrick() {
        self::setGameStateValue(TRICK_SUIT, 0);

        $this->gamestate->nextState("playerTurn");
    }

    function stNextPlayer() {
        if ($this->cards->countCardInLocation(CARDS_ON_TABLE) == 4) {
            $cards_on_table = $this->cards->getCardsInLocation(CARDS_ON_TABLE);
            $trick_suit = self::getGameStateValue(TRICK_SUIT);
            $winning_card = null;

            foreach ($cards_on_table as $card) {
                if ($card['type'] == $trick_suit) {
                    $winning_card = $this->higherCard($winning_card, $card);
                }
            }

            $winning_player_id = $winning_card['location_arg'];

            $this->gamestate->changeActivePlayer($winning_player_id);
            $this->cards->moveAllCardsInLocation(CARDS_ON_TABLE, CARDS_WON, null, $winning_player_id);

            $players = self::loadPlayersBasicInfos();
            self::notifyAllPlayers('trickWin', clienttranslate('${player_name} wins the trick'), [
                'player_id' => $winning_player_id,
                'player_name' => $players[ $winning_player_id ]['player_name']
            ]);
            self::notifyAllPlayers('giveAllCardsToPlayer','', [
                'player_id' => $winning_player_id
            ]);

            if ($this->cards->countCardInLocation(HAND) == 0) {
                $this->gamestate->nextState("endHand");
            } else {
                $scorer = $this->getScorer();
                $cards_in_hands = $this->cards->getCardsInLocation(HAND);
                if (!$scorer->remainingPoints($cards_in_hands)) {
                    $cards_left = [];
                    $players = $this->loadPlayersBasicInfos();
                    foreach ($players as $player_id => $player) {
                        $cards_left_list = [];
                        $hand = $this->cards->getCardsInLocation(HAND, $player_id);
                        usort($hand, [$this, "sortCards"]);
                        foreach ($hand as $card) {
                            $cards_left_list[] = $this->suits[$card['type']]['name'].''.$this->values_label[$card['type_arg']];
                        }
                        $cards_left[] = self::getPlayerNameById($player_id).' - '.implode(', ', $cards_left_list);
                    }
                    $cards_left_final = implode('<br>', $cards_left);

                    self::notifyAllPlayers('earlyEnd', clienttranslate('Ending the hand early as all scoring cards are out<br><br>Cards left:<br>${cards_left}'), [
                        'cards_left' => $cards_left_final,
                        'remaining_cards' => $cards_in_hands,
                    ]);
                    $this->gamestate->nextState("endHand");
                } else {
                    $this->gamestate->nextState("nextTrick");
                }
            }
        } else {
            // Not end of trick or hand, so move to the next player
            $player_id = self::activeNextPlayer();
            self::giveExtraTime($player_id);
            $this->gamestate->nextState("nextPlayer");
        }
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Zombie
////////////

    /*
        zombieTurn:
        
        This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
        You can do whatever you want in order to make sure the turn of this player ends appropriately
        (ex: pass).
        
        Important: your zombie code will be called when the player leaves the game. This action is triggered
        from the main site and propagated to the gameserver from a server, not from a browser.
        As a consequence, there is no current player associated to this action. In your zombieTurn function,
        you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message. 
    */

    function zombieTurn( $state, $active_player )
    {
    	$statename = $state['name'];
    	
        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState( "zombiePass" );
                	break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive( $active_player, '' );
            
            return;
        }

        throw new feException( "Zombie mode not supported at this game state: ".$statename );
    }
    
///////////////////////////////////////////////////////////////////////////////////:
////////// DB upgrade
//////////

    /*
        upgradeTableDb:
        
        You don't have to care about this until your game has been published on BGA.
        Once your game is on BGA, this method is called everytime the system detects a game running with your old
        Database scheme.
        In this case, if you change your Database scheme, you just have to apply the needed changes in order to
        update the game database and allow the game to continue to run with your new version.
    
    */
    
    function upgradeTableDb( $from_version )
    {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345
        
        // Example:
//        if( $from_version <= 1404301345 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        if( $from_version <= 1405061421 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        // Please add your future database scheme changes here
//
//


    }    
}
