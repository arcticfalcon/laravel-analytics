<?php

use ArcticFalcon\LaravelAnalytics\Contracts\TrackingBagInterface;

class TrackingBagMock implements TrackingBagInterface
{
	protected $bag = [];
	/**
	 * adds a tracking
	 *
	 * @param string $tracking
	 * @return void
	 */
	public function add($tracking)
	{
		$this->bag[] = $tracking;
	}

	/**
	 * returns all trackings
	 *
	 * @return array
	 */
	public function get()
	{
		return $this->bag;
	}


} 