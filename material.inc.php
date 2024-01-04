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
  1 => ['name' => '<span style="color:black" class="suit_1">♠</span>'],
  2 => ['name' => '<span style="color:red" class="suit_2">♥</span>'],
  3 => ['name' => '<span style="color:black" class="suit_3">♣</span>'],
  4 => ['name' => '<span style="color:red" class="suit_4">♦</span>'],
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

$this->games = [
  1 => [
      'type' => 'parliament',
      'name' => clienttranslate('Parliament')
  ],
  2 => [
      'type' => 'spades',
      'name' => clienttranslate('Spades')
  ],
  3 => [
      'type' => 'queens',
      'name' => clienttranslate('Queens')
  ],
  4 => [
      'type' => 'royalty',
      'name' => clienttranslate('Royalty')
  ],
  5 => [
      'type' => 'dominoes',
      'name' => clienttranslate('Dominoes')
  ],
  6 => [
      'type' => 'guillotine',
      'name' => clienttranslate('Guillotine')
  ],
];