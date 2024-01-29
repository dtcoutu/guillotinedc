<?php

require_once('GLTScorer.interface.php');
require_once('constants.inc.php');

class GLTQueensScorer implements GLTScorer {
  function gameStat(): string {
    return POINTS_FROM_QUEENS;
  }

  function remainingPoints(array $player_ids, array $won_cards): bool {
    $player_to_points = $this->score($player_ids, $won_cards);

    if (array_sum(array_values($player_to_points)) != $this->scoreTotal()) {
      return true;
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

  function scoreTotal(): int {
    return 30;
  }
}