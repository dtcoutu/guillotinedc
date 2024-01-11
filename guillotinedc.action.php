<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * guillotinedc implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 * 
 * guillotinedc.action.php
 *
 * guillotinedc main action entry point
 *
 *
 * In this file, you are describing all the methods that can be called from your
 * user interface logic (javascript).
 *       
 * If you define a method "myAction" here, then you can call it from your javascript code with:
 * this.ajaxcall( "/guillotinedc/guillotinedc/myAction.html", ...)
 *
 */
  
  
  class action_guillotinedc extends APP_GameAction
  { 
    // Constructor: please do not modify
   	public function __default()
  	{
  	    if( self::isArg( 'notifwindow') )
  	    {
            $this->view = "common_notifwindow";
  	        $this->viewArgs['table'] = self::getArg( "table", AT_posint, true );
  	    }
  	    else
  	    {
            $this->view = "guillotinedc_guillotinedc";
            self::trace( "Complete reinitialization of board game" );
      }
  	} 
  	
  	// TODO: defines your action entry points there

    public function gameSelection() {
      self::setAjaxMode();

      $selected_game = self::getArg("selected_game", AT_alphanum, true);

      $this->game->gameSelection($selected_game);

      self::ajaxResponse();
    }

    public function pass() {
      self::setAjaxMode();

      $this->game->pass();

      self::ajaxResponse();
    }

    public function playCard() {
      self::setAjaxMode();

      $card_id = self::getArg("card_id", AT_posint, true);

      $this->game->playCard($card_id);

      self::ajaxResponse();
    }

  }
  

