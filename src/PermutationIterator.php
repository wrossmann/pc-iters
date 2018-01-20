<?php
namespace wrossmann\PCIters;

class PermutationIterator {
	/**
	 * Given a set of items generate all possible unique arrangements
	 * of items. Uses Heap's Algorithm.
	 * 
	 * @param	array	$set	The set of items on which to operate.
	 */
	public static function iterate($set) {
		$state = array_fill(0, count($set), 0);
		
		yield $set;
		
		for($i=0, $c=count($set); $i<$c; ) {
			if($state[$i] < $i) {
				if($i % 2 == 0) {
					self::swap($set, 0, $i);
				} else {
					self::swap($set, $state[$i], $i);
				}
				yield $set;
				$state[$i]++;
				$i = 0;
			} else {
				$state[$i] = 0;
				$i++;
			}
		}
	}
	
	/**
	 * Swap array items.
	 * @ignore
	 */
	protected static function swap(&$arr, $a, $b) {
		$t = $arr[$a];
		$arr[$a] = $arr[$b];
		$arr[$b] = $t;
	}
}