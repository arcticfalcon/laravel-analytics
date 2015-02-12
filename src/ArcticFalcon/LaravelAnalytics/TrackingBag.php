<?php
/**
 * @author arcticfalcon
 * @since 1.1.0
 */

namespace ArcticFalcon\LaravelAnalytics;
use ArcticFalcon\LaravelAnalytics\Contracts\TrackingBagInterface;
use Session;

class TrackingBag implements TrackingBagInterface {

	/**
	 * session identifier
	 *
	 * @var string
	 */
	private $sessionIdentifier = 'analytics.tracking';

	/**
	 * adds a tracking
	 *
	 * @param string $tracking
	 */
	public function add($tracking)
	{
		$sessionTracks = [];
		if (Session::has($this->sessionIdentifier))
		{
			$sessionTracks = Session::get($this->sessionIdentifier);
		}

		$sessionTracks[] = $tracking;

		Session::flash($this->sessionIdentifier, $sessionTracks);
	}

	/**
	 * returns all trackings
	 *
	 * @return array
	 */
	public function get()
	{
		if (Session::has($this->sessionIdentifier))
		{
			return Session::pull($this->sessionIdentifier);
		}

		return [];
	}
}