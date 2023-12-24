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
  'parliament' => [
      'id' => 1,
      'name' => clienttranslate('Parliament')
  ],
  'spades' => [
      'id' => 2,
      'name' => clienttranslate('Spades')
  ],
  'queens' => [
      'id' => 3,
      'name' => clienttranslate('Queens')
  ],
  'royalty' => [
      'id' => 4,
      'name' => clienttranslate('Royalty')
  ],
  'dominoes' => [
      'id' => 5,
      'name' => clienttranslate('Dominoes')
  ],
  'guillotine' => [
      'id' => 6,
      'name' => clienttranslate('Guillotine')
  ],
];