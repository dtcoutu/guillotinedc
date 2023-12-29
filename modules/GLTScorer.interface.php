<?php

interface GLTScorer {
  public function score(array $player_ids, array $won_cards);
}