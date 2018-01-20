<?php
namespace wrossmann\PCIters;

class CombinationIterator {
	/**
	 * Given a set of items, generate all unique combinations of the
	 * specified number of items using a Gray Code-ish method.
	 * 
	 * @param	array	$set	The set of items
	 * @param	int		$count	The number of items in the output set
	 * @param	int		$begin	Offset in the set to start.
	 * @param	int		$end	Offset in the set to end. [non-inclusive]
	 */
	public static function iterate($set, $count, $begin=NULL, $end=NULL) {
		if(is_null($begin)) { $begin = 0; }
		if(is_null($end)) { $end = count($set); }
		for($i=$begin; $i<=$end-$count; $i++) {
			if( $count == 1 ) {
				yield [$set[$i]];
			} else {
				foreach(self::iterate($set, $count-1, $i+1, $end) as $perm) {
					yield array_merge([$set[$i]], $perm);
				}
			}
		}
	}
}