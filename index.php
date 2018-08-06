<?php

// -----------------------------------------------------------------------------------------------------------
// Bootstrap the terminal itself.
//
// DO NOT DELETE THIS LINE.
// -----------------------------------------------------------------------------------------------------------
require_once __DIR__ . '/src/bootstrap.php';


// -----------------------------------------------------------------------------------------------------------
// Place your code below
// -----------------------------------------------------------------------------------------------------------


// Return the matching digits between two passCodes
function findMatchingChars(int $codeToCheck, int $nextCode): int {
   $matched = 0;
   $pass1Arr = str_split($codeToCheck);
   foreach (str_split($nextCode) as $key => $digit) {
      if ($digit === $pass1Arr[$key]) {
	     $matched++;
      }
   }
   return $matched;
}

// Get all possible codes
$possibleCodes = getAllPossible();

// Pick a code to check and remove it from all the codes
$codeToCheck = $possibleCodes[0];
$possibleCodes = array_values(array_diff($possibleCodes, array($codeToCheck)));

for ($attempt = 0; $attempt < 5; $attempt++) {
   // attempt to crack the code or get the similarity if we fail
   $similarity = attempt($codeToCheck);

   if ($similarity != 0) {
      // Remove unnecessary numbers
      for ($i = 0; $i < count($possibleCodes); $i++) {
         if (findMatchingChars($codeToCheck, $possibleCodes[$i]) < $similarity) {
            // Remove the code that has less similarity than 'codeToCheck' and the 'codeToCheck' itself
            $possibleCodes = array_diff($possibleCodes, array($possibleCodes[$i], $codeToCheck));
         }
      }
   }

   // Arrange the indexes of the codes in the array
   $possibleCodes = array_values($possibleCodes);

   // Pick a new code to check and remove it from all the codes
   $codeToCheck = $possibleCodes[0];
   $possibleCodes = array_values(array_diff($possibleCodes, array($codeToCheck)));
}
print_r("You have failed! \n\r");