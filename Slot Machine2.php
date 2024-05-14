<?php

function spin($boardSize, $symbols) {
    $result = [];
    for ($i = 0; $i < $boardSize; $i++) {
        $result[] = $symbols[array_rand($symbols)];
    }
    return $result;
}

function calculateWin($result, $betAmount, $winConditions) {
    $winAmount = 0;
    foreach ($winConditions as $condition) {
        $matches = array_count_values($result);
        foreach ($condition as $element => $multiplier) {
            if (isset($matches[$element])) {
                $winAmount += $multiplier * $matches[$element] * $betAmount;
            }
        }
    }
    return $winAmount;
}

function displayResult($result) {
    for ($i = 0; $i < count($result); $i++) {
        echo $result[$i] . " ";
    }
    echo "\n";
}

function play($startAmount, $betAmount, $boardSize, $symbols, $winConditions) {
    $coins = $startAmount;

    while ($coins >= $betAmount) {
        $result = spin($boardSize, $symbols);
        $winAmount = calculateWin($result, $betAmount, $winConditions);
        $coins += $winAmount - $betAmount;
        echo "Result:\n";
        for ($i = 0; $i < 3; $i++) {
            displayResult(array_slice($result, $i * 3, 3));
        }
        echo "Win: " . $winAmount . ". Coins: " . $coins . "\n";

        echo "Do you want to continue playing? (yes/no): ";
        $continue = trim(fgets(STDIN));
        if (strtolower($continue) !== 'yes') {
            break;
        }
    }

    echo "Game over. You ran out of coins.\n";
}

echo "Enter the starting amount of coins: ";
$startAmount = intval(trim(fgets(STDIN)));

echo "Enter the bet amount per spin: ";
$betAmount = intval(trim(fgets(STDIN)));

$boardSize = 9;
$symbols = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
$winConditions = [
    ["A" => 5],
];

play($startAmount, $betAmount, $boardSize, $symbols, $winConditions);