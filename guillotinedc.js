/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * guillotinedc implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * guillotinedc.js
 *
 * guillotinedc user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo","dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",
    "ebg/stock"
],
function (dojo, declare) {
    return declare("bgagame.guillotinedc", ebg.core.gamegui, {
        constructor: function(){
            console.log('guillotinedc constructor');
            this.cardwidth = 72;
            this.cardheight = 96;
              
            // Here, you can init the global variables of your user interface
            // Example:
            // this.myGlobalValue = 0;

        },
        
        /*
            setup:
            
            This method must set up the game user interface according to current game situation specified
            in parameters.
            
            The method is called each time the game interface is displayed to a player, ie:
            _ when the game starts
            _ when a player refreshes the game page (F5)
            
            "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
        */
        
        setup: function( gamedatas )
        {
            console.log( "Starting game setup" );
            
            // Setting up player boards
            for( var player_id in gamedatas.players )
            {
                var player = gamedatas.players[player_id];
                         
                // TODO: Setting up players boards if needed
            }
            
            // TODO: Set up your game interface here, according to "gamedatas"

            this.playerHand = new ebg.stock();
            this.playerHand.create(this, $('myhand'), this.cardwidth, this.cardheight);
            this.playerHand.image_items_per_row = 13;
            this.playerHand.setSelectionMode(1);

            // Create card types
            for (var suit = 1; suit <= 4; suit++) {
                for (var value = 7; value <= 14; value++) {
                    const card_type_id = this.getCardUniqueId(suit, value);
                    const card_weight = this.getCardWeight(suit, value);
                    this.playerHand.addItemType(card_type_id, card_weight, g_gamethemeurl + 'img/cards.jpg', card_type_id);
                }
            }

            // Cards in player hand
            this.displayHand(this.gamedatas.hand);

            // Cards played on table
            for (let i in gamedatas.cardsontable) {
                const card = gamedatas.cardsontable[i];
                const suit = card.type;
                const value = card.type_arg;
                var player_id = card.location_arg;
                this.playCardOnTable(player_id, suit, value, card.id);
            }

            // Setup game notifications to handle (see "setupNotifications" method below)
            this.setupNotifications();

            console.log( "Ending game setup" );
        },
       

        ///////////////////////////////////////////////////
        //// Game & client states
        
        // onEnteringState: this method is called each time we are entering into a new game state.
        //                  You can use this method to perform some user interface changes at this moment.
        //
        onEnteringState: function( stateName, args )
        {
            console.log( 'Entering state: '+stateName );
            
            switch( stateName )
            {
            
            /* Example:
            
            case 'myGameState':
            
                // Show some HTML block at this game state
                dojo.style( 'my_html_block_id', 'display', 'block' );
                
                break;
           */
           
           
            case 'dummmy':
                break;
            }
        },

        // onLeavingState: this method is called each time we are leaving a game state.
        //                 You can use this method to perform some user interface changes at this moment.
        //
        onLeavingState: function( stateName )
        {
            console.log( 'Leaving state: '+stateName );
            
            switch( stateName )
            {
            
            /* Example:
            
            case 'myGameState':
            
                // Hide the HTML block we are displaying only during this game state
                dojo.style( 'my_html_block_id', 'display', 'none' );
                
                break;
           */
           
           
            case 'dummmy':
                break;
            }               
        }, 

        // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
        //                        action status bar (ie: the HTML links in the status bar).
        //        
        onUpdateActionButtons: function( stateName, args )
        {
            console.log( 'onUpdateActionButtons: '+stateName );
                      
            if( this.isCurrentPlayerActive() )
            {            
                switch( stateName )
                {
                    case 'playerTurn':
                        this.addActionButton('btnPlayCard', _('Play card'), 'onBtnPlayCard');
                        break;
                    case 'gameSelection':
                        args.available_games?.forEach(game => {
                            this.addActionButton(game.type, _(game.name), () => this.onBtnGameSelection(game.type))
                        });
                        break;
                }
            }
        },

        ///////////////////////////////////////////////////
        //// Utility methods
        
        /*
        
            Here, you can defines some utility methods that you can use everywhere in your javascript
            script.
        
        */
        getCardUniqueId: function(suit, value) {
            return (suit - 1) * 13 + (value - 2);
        },

        getCardWeight: function(suit, value) {
            var base_weight = this.getCardUniqueId(suit, value);

            if (value == 10) {
                return base_weight + 3;
            } else if (value == 14) {
                return base_weight + 1;
            } else {
                return base_weight;
            }
        },
    
        displayHand: function(cards) {
            for (var i in cards) {
                var card = cards[i];
                var suit = card.type;
                var value = card.type_arg;
                this.playerHand.addToStockWithId(this.getCardUniqueId(suit, value), card.id);
            }
        },

        playCardOnTable : function(player_id, suit, value, card_id) {
            // player_id => direction
            dojo.place(this.format_block('jstpl_card', {
                x : this.cardwidth * (value - 2),
                y : this.cardheight * (suit - 1),
                player_id : player_id
            }), 'playertablecard_' + player_id);

            if (player_id != this.player_id) {
                // Some opponent played a card
                // Move card from player panel
                this.placeOnObject('cardontable_' + player_id, 'overall_player_board_' + player_id);
            } else {
                // You played a card. If it exists in your hand, move card from there and remove
                // corresponding item

                if ($('myhand_item_' + card_id)) {
                    this.placeOnObject('cardontable_' + player_id, 'myhand_item_' + card_id);
                    this.playerHand.removeFromStockById(card_id);
                }
            }

            // In any case: move it to its final destination
            this.slideToObject('cardontable_' + player_id, 'playertablecard_' + player_id).play();
        },

        ///////////////////////////////////////////////////
        //// Player's action
        
        /*
        
            Here, you are defining methods to handle player's action (ex: results of mouse click on 
            game objects).
            
            Most of the time, these methods:
            _ check the action is possible at this game state.
            _ make a call to the game server
        
        */
        onBtnPlayCard: function() {
            const action = "playCard";
            if (!this.checkAction(action)) return;

            // TODO: Should do some validation around the card played, but for now just play it.
            const selected_cards = this.playerHand.getSelectedItems();
            const card_id = selected_cards[0].id;

            this.playerHand.unselectAll();
            this.ajaxcall(
                "/" + this.game_name + "/" + this.game_name + "/" + action + ".html",
                {lock: true, card_id: card_id}, this, function (result) {}, function (is_error) {}
            );
        },

        onBtnGameSelection: function(game_type) {
            const action = "gameSelection";
            if (!this.checkAction(action)) return;

            this.ajaxcall(
                "/" + this.game_name + "/" + this.game_name + "/" + action + ".html",
                {lock: true, selected_game: game_type}, this, function (result) {}, function (is_error) {}
            );
        },

        
        ///////////////////////////////////////////////////
        //// Reaction to cometD notifications

        /*
            setupNotifications:
            
            In this method, you associate each of your game notifications with your local method to handle it.
            
            Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
                  your guillotinedc.game.php file.
        
        */
        setupNotifications: function()
        {
            console.log( 'notifications subscriptions setup' );

            // dojo.subscribe('newHand', this, "notif_newHand");
            dojo.subscribe('playCard', this, "notif_playCard");
            dojo.subscribe('trickWin', this, "notif_trickWin");
            this.notifqueue.setSynchronous('trickWin', 1000);
            dojo.subscribe('giveAllCardsToPlayer', this, "notif_giveAllCardsToPlayer");
            
            // TODO: here, associate your game notifications with local methods
            
            // Example 1: standard notification handling
            // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
            
            // Example 2: standard notification handling + tell the user interface to wait
            //            during 3 seconds after calling the method in order to let the players
            //            see what is happening in the game.
            // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
            // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
            // 
        },  

        // TODO: from this point and below, you can write your game notifications handling methods

        notif_giveAllCardsToPlayer : function(notif) {
            // Move all cards on table to given table, then destroy them
            var winner_id = notif.args.player_id;
            for ( var player_id in this.gamedatas.players) {
                var anim = this.slideToObject('cardontable_' + player_id, 'overall_player_board_' + winner_id);
                dojo.connect(anim, 'onEnd', function(node) {
                    dojo.destroy(node);
                });
                anim.play();
            }
        },

        notif_newHand : function(notif) {
            // We received a new full hand of 8 cards.
            this.playerHand.removeAll();

            for ( var i in notif.args.cards) {
                var card = notif.args.cards[i];
                var color = card.type;
                var value = card.type_arg;
                this.playerHand.addToStockWithId(this.getCardUniqueId(color, value), card.id);
            }
        },

        notif_playCard : function(notif) {
            this.playCardOnTable(notif.args.player_id, notif.args.suit, notif.args.value, notif.args.card_id);
        },

        notif_trickWin : function(notif) {
            // We do nothing here (just wait so players can view the 4 cards played before they're gone).
        },
   });
});
