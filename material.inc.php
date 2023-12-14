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
 * material.inc.php
 *
 * guillotinedc game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */

 $this->suits = [
  1 => ['name' => clienttranslate('spade'),
        'nametr' => self::_('spade')],
  2 => ['name' => clienttranslate('heart'),
        'nametr' => self::_('heart')],
  3 => ['name' => clienttranslate('club'),
        'nametr' => self::_('club')],
  4 => ['name' => clienttranslate('diamond'),
        'nametr' => self::_('diamon')],
 ];


$this->values_label = [
  7 => '7',
  8 => '8',
  9 => '9',
  10 => '10',
  11 => clienttranslate('J'),
  12 => clienttranslate('Q'),
  13 => clienttranslate('K'),
  14 => clienttranslate('A')
];