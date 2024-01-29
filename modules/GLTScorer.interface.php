<?php

interface GLTScorer {
  public function gameStat(): string;
  public function remainingPoints(array $player_ids, array $won_cards): bool;
  public function score(array $player_ids, array $won_cards): array;
  public function scoreTotal(): int;
}