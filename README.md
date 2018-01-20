# wrossmann/pc-iters

Memory-efficient PHP permutation and combination generators.

Both classes are generators that should incur no additional memory requirements beyond roughly one extra copy of the input set.

This library was written in response to a question regarding permuatation/combination generation in ##php on FreeNode, and published after a brief survey of alternatives showed only solutions that recursively generated incresasingly larger sets of results in-memory.

I would also like to include the word 'combinatorics' in this document so that search engines find it. :)

## Caveats

* The input array to the interators *must* be numerically-indexed with no gaps in the indexes. [see: `array_values()`]
* Neither generator makes allowances for gaps or repetitions, all elements are assumed to be unique.
* If you store the results of these generators you're still going to have memory issues.
* This is not an ideal method to calculate the number of possible permutations and combinations. [see: Math]
* This is not an ideal method to generate something like "all possible non-sequential, non-repeating IDs" [see: Linear-Feedback Shift Registers or just use a UUID]

## Classes

* **CombinationIterator:** Generates all possible combinations of N elements from the input set.
	* Uses a recursive, Gray Code-ish method.
	* Stack depth should never be deeper than the number of element in the output set.
* **PermutationIterator:** Generates all possible arrangements of the input set.
	* Uses the non-recursive form of Heap's Algorithm.
	* Operates in-place on a copy of the input set.

## Installation

    composer require wrossmann/pc-iters
    
## Usage

### CombinationIterator

Function signature and docblock:

	/**
	 * Given a set of items, generate all unique combinations of the
	 * specified number of items using a Gray Code-ish method.
	 * 
	 * @param	array	$set	The set of items
	 * @param	int		$count	The number of items in the output set
	 * @param	int		$begin	Offset in the set to start.
	 * @param	int		$end	Offset in the set to end. [non-inclusive]
	 */
	public static function iterate($set, $count, $begin=NULL, $end=NULL)

Example:

	use wrossmann\PCIters\CombinationIterator;
	
	foreach( CombinationIterator::iterate([1,2,3,4,5], 3) as $comb ) {
		printf("%s\n", json_encode($comb));
	}
	
Output:

	[1,2,3]
	[1,2,4]
	[1,2,5]
	[1,3,4]
	[1,3,5]
	[1,4,5]
	[2,3,4]
	[2,3,5]
	[2,4,5]
	[3,4,5]

### PermutationIterator

Function signature and docblock:

	/**
	 * Given a set of items generate all possible unique arrangements
	 * of items. Uses Heap's Algorithm.
	 * 
	 * @param	array	$set	The set of items on which to operate.
	 */
	public static function iterate($set)

Example:

	use wrossmann\PCIters\PermutationIterator;
	
	foreach( PermutationIterator::iterate([1,2,3]) as $comb ) {
		printf("%s\n", json_encode($comb));
	}
	
Output:

	[1,2,3]
	[2,1,3]
	[3,1,2]
	[1,3,2]
	[2,3,1]
	[3,2,1]
