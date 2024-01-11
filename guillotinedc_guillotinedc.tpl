{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- guillotinedc implementation : © <Your name here> <Your email address here>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    guillotinedc_guillotinedc.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->
<div id="playertables" class="whiteblock">
    <!-- BEGIN player -->
    <div class="playertable playertable_{DIR}">
        <div class="playertablename" style="color:#{PLAYER_COLOR}">{PLAYER_NAME}</div>
        <div id="dealer_p{PLAYER_ID}" class="playertableselectedgame">{SELECTED_GAME}</div>
        <div id="playertablecard_{PLAYER_ID}" class="playertablecard"></div>
    </div>
    <!-- END player -->
    <div id="dominoesplayarea"></div>
</div>

<div id="myhand_wrap" class="whiteblock">
    <h3>{MY_HAND}</h3>
    <div id="myhand">
    </div>
</div>

<script type="text/javascript">

// Javascript HTML templates
var jstpl_card = '<div class="card cardontable" id="cardontable_${card_id}" style="background-position:-${x}px -${y}px"></div>';
var jstpl_game_display = '<div id="glt_game_${game_type}_${player_id}" class="game_display game_display_${game_type} ${played}">${game_abbr}</div>';
</script>  

{OVERALL_GAME_FOOTER}


