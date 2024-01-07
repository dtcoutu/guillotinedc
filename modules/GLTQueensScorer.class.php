<?php

require_once('GLTScorer.interface.php');

class GLTQueensScorer implements GLTScorer {
  function remainingPoints(array $cards_in_hands): bool {
    foreach ($cards_in_hands as $card) {
      if ($card['type_arg'] == QUEEN || ($card['type'] == HEART && $card['type_arg'] == KING)) {
        return true;
      }
    }

    return false;
  }

  function score(array $player_ids, array $won_cards): array {
    $player_to_points = [];
    foreach ($player_ids as $player_id) {
      $player_to_points[$player_id] = 0;
    }

    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      if ($card['type_arg'] == QUEEN) {
        $player_to_points[$player_id] += 10;
      } else if ($card['type'] == HEART && $card['type_arg'] == KING) {
        $player_to_points[$player_id] -= 10;
      }
    }

    return $player_to_points;
  }
}