<?php

namespace Frt;

use Frt\Console;

class App
{
	/**
	 * @var array
	 */
	private $possibilities = [];

	/**
	 * @var integer
	 */
	private $correct;

	/**
	 * @var integer
	 */
	private $attempts = 0;

	/**
	 * @var integer
	 */
	private $possibilitiesCount = 10;

	/**
	 * @var integer
	 */
	private $maxAttempts = 5;
	
	public function __construct()
	{
		$this->possibilities = $this->generatePossibilities();
		$this->correct = $this->possibilities[array_rand($this->possibilities)];
		$this->init();
	}

	/**
	 * Gets all possible passwords
	 *
	 * @return array
	 */
	public function getAllPossible(): array
	{
		return $this->possibilities;
	}

	/**
	 * Checks password
	 *
	 * @param integer $password
	 * @return integer
	 */
	public function attempt(int $password): int
	{
		Console::log("Attempts remaining: " . $this->attemptsRemaining(), true, true);
		$this->attempts++;
		sleep(1);

		if ($this->attempts > $this->maxAttempts) {
			sleep(1);
			Console::logColored("[BLOCKED]", true, false, 'red', 'black');
			Console::log(" No more attempts available!", false, true);
			Console::log("Correct password: " . $this->correct, true, true);
			die();
		}

		Console::log("Checking password: ", true);
		Console::logColored($password, false, false, 'yellow', 'black');
		sleep(1);

		if (!in_array($password, $this->possibilities)) {
			Console::logColored("[Error]", true, false, 'red', 'black');
			Console::log(" The password does not match any of the possible variants!", false, true);
			die();
		}

		if ($password === $this->correct) {
			Console::logColored("<<<CORRECT>>>", true, false, 'white', 'green');
			Console::log("https://tinyurl.com/yc7gck6a", true, true);
			die();
		}

		$matches = $this->findMatchingChars($password);

		Console::logColored("[ENTRY DENIED]", true, false, 'red', 'black');
		Console::log(" Likeness: " . $matches, false, true);
		sleep(1);

		return $matches;
	}

	private function init()
	{
		Console::logColored("=============================", true, false, 'green', null, 0);
		Console::logColored("|>", true, false, 'green', null, 0);
		Console::logColored(" Welcome to FRT terminal ", false, false, 'green');
		Console::logColored("<|", false, false, 'green', null, 0);
		Console::logColored("=============================", true, true, 'green', null, 0);
		sleep(1);
		Console::logColored("Password required!" , true, true, 'yellow');

		$this->showPossibilities();
		
		register_shutdown_function(function() {
			if ($this->attempts === 0) {
				Console::log('Enter your code in \'index.php\' ;)', true, true);
			}
		});
	}

	/**
	 * Generates possible passwords
	 *
	 * @return array
	 */
	private function generatePossibilities(): array
	{
		$possibilities = [];

		for ($i = 0; $i < $this->possibilitiesCount; $i++) {
			$possibilities[] = mt_rand(10000, 99999);
		}

		return $possibilities;
	}

	/**
	 * Shows passwords
	 */
	private function showPossibilities()
	{
		Console::log("Possible passwords:", true, true);
		usleep(500000);

		foreach ($this->possibilities as $possibility) {
			Console::log($possibility, true);
			usleep(500000);
		}

		echo Console::$EOF;
	}

	/**
	 * Finds matched characters
	 *
	 * @param integer $pass
	 * @return integer
	 */
	private function findMatchingChars(int $pass): int
	{
		$matched = 0;
		$correctArr = str_split($this->correct);

		foreach (str_split($pass) as $key => $letter) {
			if ($letter === $correctArr[$key]) {
				$matched++;
			}
		}

		return $matched;
	}

	/**
	 * Gets remaining attepmts
	 *
	 * @return integer
	 */
	private function attemptsRemaining(): int
	{
		return $this->maxAttempts - $this->attempts;
	}
}