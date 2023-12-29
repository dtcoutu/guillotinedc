<?php

require_once('GLTScorer.interface.php');

class GLTGuillotineScorer implements GLTScorer {
  private int $first_trick_winner;
  private int $last_trick_winner;

  function __construct(int $first_trick_winner, int $last_trick_winner) {
    $this->first_trick_winner = $first_trick_winner;
    $this->last_trick_winner = $last_trick_winner;
  }

  function score(array $player_ids, array $won_cards) {
    $player_to_points = [];
    foreach ($player_ids as $player_id) {
      $player_to_points[$player_id] = 0;
    }

    $player_to_points[$this->first_trick_winner] += 5;
    $player_to_points[$this->last_trick_winner] += 5;

    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      if ($card['type'] == SPADE) {
        $player_to_points[$player_id] += 5;
      }

      if ($card['type_arg'] == 12) {
        $player_to_points[$player_id] += 10;
      }

      if ($card['type'] == HEART && $card['type_arg'] == 13) {
        $player_to_points[$player_id] += 10;
      }
    }

    return $player_to_points;
  }
}