<?php

require_once('GLTScorer.interface.php');

class GLTParliamentScorer implements GLTScorer {
  function score(array $player_ids, array $won_cards) {
    $player_to_points = [];
    $player_card_counts = [];
    foreach ($player_ids as $id) {
      $player_to_points[$id] = 0;
      $player_card_counts[$id] = 0;
    }
    
    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      // Find K of hearts
      if ($card['type'] == HEART && $card['type_arg'] == 13) {
        $player_to_points[$player_id] -= 10;
      }

      $player_card_counts[$player_id] += 1;
    }

    foreach ($player_card_counts as $player_id => $count) {
      $player_to_points[$player_id] -= ($count / 4) * 5;
    }

    return $player_to_points;
  }
}