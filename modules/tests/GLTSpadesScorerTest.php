<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once "GLTSpadesScorer.class.php";

final class GLTSpadesScorerTest extends TestCase {
  function testScore_emptyValues() {
    $scorer = new GLTSpadesScorer();

    $actual = $scorer->score([], []);

    $expected = [];

    $this->assertEquals($expected, $actual);
  }

  function testScore_onePlayerGetsEverything() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => SPADE, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 14, 'location_arg' => 1],
    ];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 30,
      2 => 0,
      3 => 0,
      4 => 0
    ];

    $this->assertEquals($expected, $actual);
  }

  function testScore_distributedPointsOnePlayerOnlyGetsKingOfHearts() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => SPADE, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 9,  'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 10, 'location_arg' => 3],
      ['type' => SPADE, 'type_arg' => 11, 'location_arg' => 2],
      ['type' => SPADE, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => 13, 'location_arg' => 3],
      ['type' => SPADE, 'type_arg' => 14, 'location_arg' => 2],
      ['type' => HEART, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => HEART, 'type_arg' => 8,  'location_arg' => 4],
      ['type' => HEART, 'type_arg' => 9,  'location_arg' => 4],
      ['type' => HEART, 'type_arg' => 10, 'location_arg' => 2],
      ['type' => HEART, 'type_arg' => 11, 'location_arg' => 2],
      ['type' => HEART, 'type_arg' => 12, 'location_arg' => 2],
      ['type' => HEART, 'type_arg' => 13, 'location_arg' => 4],
      ['type' => HEART, 'type_arg' => 14, 'location_arg' => 4],
      ['type' => CLUB, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 9,  'location_arg' => 2],
      ['type' => CLUB, 'type_arg' => 10, 'location_arg' => 2],
      ['type' => CLUB, 'type_arg' => 11, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 12, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 13, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => 14, 'location_arg' => 2],
      ['type' => DIAMOND, 'type_arg' => 7,  'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 8,  'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 9,  'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 11, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 12, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 13, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 14, 'location_arg' => 3],
    ];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 20,
      2 => 10,
      3 => 10,
      4 => -10
    ];

    $this->assertEquals($expected, $actual);
  }

  function testRemainingPoints() {
    $cards_in_hands = [];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->remainingPoints($cards_in_hands);

    $this->assertFalse($actual);
  }

  function testRemainingPoints_SomeSpadesRemaining() {
    $cards_in_hands = [
      ['type' => SPADE, 'type_arg' => 9],
      ['type' => SPADE, 'type_arg' => 12],
      ['type' => HEART, 'type_arg' => 9],
      ['type' => CLUB, 'type_arg' => 11],
      ['type' => CLUB, 'type_arg' => 14],
      ['type' => DIAMOND, 'type_arg' => 7],
      ['type' => DIAMOND, 'type_arg' => 10],
      ['type' => DIAMOND, 'type_arg' => 14],
    ];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->remainingPoints($cards_in_hands);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_OnlyKingOfHeartsRemaining() {
    $cards_in_hands = [
      ['type' => CLUB, 'type_arg' => 14],
      ['type' => DIAMOND, 'type_arg' => 7],
      ['type' => DIAMOND, 'type_arg' => 10],
      ['type' => HEART, 'type_arg' => 13],
    ];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->remainingPoints($cards_in_hands);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_NoPointsRemaining() {
    $cards_in_hands = [
      ['type' => CLUB, 'type_arg' => 14],
      ['type' => DIAMOND, 'type_arg' => 7],
      ['type' => DIAMOND, 'type_arg' => 10],
      ['type' => DIAMOND, 'type_arg' => 14],
    ];

    $scorer = new GLTSpadesScorer();

    $actual = $scorer->remainingPoints($cards_in_hands);

    $this->assertFalse($actual);
  }
}