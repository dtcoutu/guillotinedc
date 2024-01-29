<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once "GLTParliamentScorer.class.php";

final class GLTParliamentScorerTest extends TestCase {
  function testScore_emptyValues() {
    $scorer = new GLTParliamentScorer();

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

    $scorer = new GLTParliamentScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => -50,
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

    $scorer = new GLTParliamentScorer();

    $actual = $scorer->score($players, $won_cards);

    $expected = [
      1 => -15,
      2 => -10,
      3 => -10,
      4 => -15
    ];

    $this->assertEquals($expected, $actual);
  }

  function testRemainingPoints() {
    $players = [1,2,3,4];
    $won_cards = [];

    $scorer = new GLTParliamentScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertTrue($actual);
  }

  function testRemainingPoints_AnyCardsRemaining() {
    $players = [1,2,3,4];
    $won_cards = [
      ['type' => CLUB, 'type_arg' => 14, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 7, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 10, 'location_arg' => 1],
      ['type' => DIAMOND, 'type_arg' => 14, 'location_arg' => 1],
    ];

    $scorer = new GLTParliamentScorer();

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

    $scorer = new GLTParliamentScorer();

    $actual = $scorer->remainingPoints($players, $won_cards);

    $this->assertFalse($actual);
  }
}