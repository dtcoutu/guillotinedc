<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once "GLTRoyaltyScorer.class.php";

final class GLTRoyaltyScorerTest extends TestCase {
  function testScore_emptyValues() {
    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->score([], []);

    $expected = [];

    $this->assertEquals($expected, $actual);
  }

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

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 30,
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

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => 10,
      2 => 0,
      3 => 0,
      4 => 20
    ];

    $this->assertEquals($expected, $actual);
  }

  function testRemainingPoints() {
    $players = [1,2,3,4];
    $won_cards = [];

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_QueenOfSpadesRemaining() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => SPADE, 'type_arg' => 9, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => JACK, 'location_arg' => 1],
      ['type' => HEART, 'type_arg' => KING, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => JACK, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => ACE, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 7, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => ACE, 'location_arg' => 1],
    ];

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_KingOfHeartsRemaining() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => SPADE, 'type_arg' => 9, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => JACK, 'location_arg' => 1],
      ['type' => SPADE, 'type_arg' => QUEEN, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => JACK, 'location_arg' => 1],
      ['type' => CLUB, 'type_arg' => ACE, 'location_arg' => 2],
      ['type' => DIAMOND, 'type_arg' => 7, 'location_arg' => 2],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 2],
      ['type' => DIAMOND, 'type_arg' => ACE, 'location_arg' => 2],
    ];

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_NoPointsRemaining() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => SPADE, 'type_arg' => 9, 'location_arg' => 3],
      ['type' => SPADE, 'type_arg' => QUEEN, 'location_arg' => 3],
      ['type' => HEART, 'type_arg' => KING, 'location_arg' => 3],
      ['type' => CLUB, 'type_arg' => JACK, 'location_arg' => 3],
      ['type' => CLUB, 'type_arg' => ACE, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 7, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 3],
      ['type' => DIAMOND, 'type_arg' => ACE, 'location_arg' => 3],
    ];

    $scorer = new GLTRoyaltyScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertFalse($actual);
  }
}