<?php

require_once('GLTScorer.interface.php');
require_once('constants.inc.php');

class GLTGuillotineScorer implements GLTScorer {
  function gameStat(): string {
    return POINTS_FROM_GUILLOTINE;
  }

  function remainingPoints(array $player_ids, array $won_cards): bool {
    if (count($won_cards) < 32) {
      return true;
    }
    return false;
  }

  function score(array $player_ids, array $won_cards, array $trick_winners = null): array {
    $player_to_points = [];
    foreach ($player_ids as $player_id) {
      $player_to_points[$player_id] = 0;
    }

    $player_to_points[$trick_winners[FIRST_TRICK_WINNER]] += 5;
    $player_to_points[$trick_winners[LAST_TRICK_WINNER]] += 5;

    foreach ($won_cards as $card) {
      $player_id = $card['location_arg'];

      if ($card['type'] == SPADE) {
        $player_to_points[$player_id] += 5;
      }

      if ($card['type_arg'] == QUEEN) {
        $player_to_points[$player_id] += 10;
      }

      if ($card['type'] == HEART && $card['type_arg'] == KING) {
        $player_to_points[$player_id] += 10;
      }
    }

    return $player_to_points;
  }

  function scoreTotal(): int {
    return 100;
  }
}