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

    $trick_winners = [
      FIRST_TRICK_WINNER => 1,
      LAST_TRICK_WINNER => 1
    ];

    $scorer = new GLTGuillotineScorer();

    $actual = $scorer->score($players, $won_cards, $trick_winners);

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

    $trick_winners = [
      FIRST_TRICK_WINNER => 2,
      LAST_TRICK_WINNER => 4
    ];

    $scorer = new GLTGuillotineScorer();

    $actual = $scorer->score($players, $won_cards, $trick_winners);

    $expected = [
      1 => 40,
      2 => 25,
      3 => 20,
      4 => 15
    ];

    $this->assertEquals($expected, $actual);
  }

  function testRemainingPoints() {
    $players = [1,2,3,4];
    $won_cards = [];

    $scorer = new GLTGuillotineScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_AnyCardsRemaining() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => CLUB, 'type_arg' => 14],
      ['type' => DIAMOND, 'type_arg' => 7],
      ['type' => DIAMOND, 'type_arg' => 10],
      ['type' => DIAMOND, 'type_arg' => 14],
    ];

    $scorer = new GLTGuillotineScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_NoCardsRemaining() {
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

    $scorer = new GLTGuillotineScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertFalse($actual);
  }
}