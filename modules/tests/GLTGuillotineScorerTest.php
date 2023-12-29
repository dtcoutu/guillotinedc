<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once "GLTGuillotineScorer.class.php";

final class GLTGuillotineScorerTest extends TestCase {
  function testScore_onePlayerTakesEverything() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => 1, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => 1, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => 1, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 1, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => 1, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => 2, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 2, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 2, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => 2, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => 2, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => 2, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 2, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => 2, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 3, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 3, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => 3, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => 4, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 4, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 4, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => 4, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => 4, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => 4, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 4, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => 4, 'type_arg' => 14, 'location_arg' => 1],
    ];

    $scorer = new GLTGuillotineScorer(1, 1);

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 100,
      2 => 0,
      3 => 0,
      4 => 0
    ];

    $this->assertEquals($expected, $actual);
  }

  function testScore_splitUpTrickWinning() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => 1, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => 1, 'type_arg' => 10, 'location_arg' => 3],
      ['type' => 1, 'type_arg' => 11, 'location_arg' => 2],
      ['type' => 1, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 1, 'type_arg' => 13, 'location_arg' => 3],
      ['type' => 1, 'type_arg' => 14, 'location_arg' => 2],
      ['type' => 2, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 2, 'type_arg' => 8,  'location_arg' => 4],
      ['type' => 2, 'type_arg' => 9,  'location_arg' => 4],
      ['type' => 2, 'type_arg' => 10, 'location_arg' => 2],
      ['type' => 2, 'type_arg' => 11, 'location_arg' => 2],
      ['type' => 2, 'type_arg' => 12, 'location_arg' => 2],
      ['type' => 2, 'type_arg' => 13, 'location_arg' => 4],
      ['type' => 2, 'type_arg' => 14, 'location_arg' => 4],
      ['type' => 3, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 3, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 3, 'type_arg' => 9,  'location_arg' => 2],
      ['type' => 3, 'type_arg' => 10, 'location_arg' => 2],
      ['type' => 3, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => 3, 'type_arg' => 14, 'location_arg' => 2],
      ['type' => 4, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => 4, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => 4, 'type_arg' => 9,  'location_arg' => 3],
      ['type' => 4, 'type_arg' => 10, 'location_arg' => 3],
      ['type' => 4, 'type_arg' => 11, 'location_arg' => 3],
      ['type' => 4, 'type_arg' => 12, 'location_arg' => 3],
      ['type' => 4, 'type_arg' => 13, 'location_arg' => 3],
      ['type' => 4, 'type_arg' => 14, 'location_arg' => 3],
    ];

    $scorer = new GLTGuillotineScorer(2, 4);

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 40,
      2 => 25,
      3 => 20,
      4 => 15
    ];

    $this->assertEquals($expected, $actual);
  }
}