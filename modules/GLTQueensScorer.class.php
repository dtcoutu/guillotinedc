<?php

require_once('GLTScorer.interface.php');

class GLTQueensScorer implements GLTScorer {
  function score(array $player_ids, array $won_cards) {
    $player_to_points = [];
    foreach ($player_ids as $player_id) {
      $player_to_points[$player_id] = 0;
    }

    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      if ($card['type_arg'] == 12) {
        $player_to_points[$player_id] += 10;
      } else if ($card['type'] == HEART && $card['type_arg'] == 13) {
        $player_to_points[$player_id] -= 10;
      }
    }

    return $player_to_points;
  }
}