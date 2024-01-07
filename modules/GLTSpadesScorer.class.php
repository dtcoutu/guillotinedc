<?php

require_once('GLTScorer.interface.php');
require_once('constants.inc.php');

class GLTSpadesScorer implements GLTScorer {
  function remainingPoints(array $cards_in_hands): bool {
    foreach ($cards_in_hands as $card) {
      if ($card['type'] == SPADE || ($card['type'] == HEART && $card['type_arg'] == 13)) {
        return true;
      }
    }

    return false;
  }

  function score(array $player_ids, array $won_cards): array {
    $player_to_points = [];
    foreach ($player_ids as $id) {
      $player_to_points[$id] = 0;
    }
    
    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      if ($card['type'] == SPADE) {
        $player_to_points[$player_id] += 5;
      } else if ($card['type'] == HEART && $card['type_arg'] == KING) {
        $player_to_points[$player_id] -= 10;
      }
    }

    return $player_to_points;
  }
}