<?php

interface GLTScorer {
  public function remainingPoints(array $cards_in_hands): bool;
  public function score(array $player_ids, array $won_cards): array;
}