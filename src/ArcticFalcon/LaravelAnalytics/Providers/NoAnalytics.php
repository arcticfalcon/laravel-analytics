<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 07.03.14
 */

namespace ArcticFalcon\LaravelAnalytics\Providers;


use ArcticFalcon\LaravelAnalytics\Contracts\AnalyticsProviderInterface;
use ArcticFalcon\LaravelAnalytics\Data\Campaign;
use ArcticFalcon\LaravelAnalytics\Data\Event;

class NoAnalytics implements AnalyticsProviderInterface {

	/**
	 * returns the javascript code for embedding the analytics stuff
	 *
	 * @return string
	 */
	public function render()
	{
		return '';
	}

	/**
	 * track an page view
	 *
	 * @param null|string $page
	 * @param null|string $title
	 * @param null|string $hittype
	 * @return void
	 */
	public function trackPage($page, $title, $hittype)
	{

	}

	/**
	 * track an event
	 *
	 * @param string $category
	 * @param string $action
	 * @param null|string $label
	 * @param null|int $value
	 * @return void
	 */
	public function trackEvent($category, $action, $label, $value)
	{

	}

	/**
	 * track any custom code
	 *
	 * @param string $customCode
	 * @return void
	 */
	public function trackCustom($customCode)
	{

	}

	/**
	 * enable auto tracking
	 *
	 * @return void
	 */
	public function enableAutoTracking()
	{

	}

	/**
	 * disable auto tracking
	 *
	 * @return void
	 */
	public function disableAutoTracking()
	{

	}

	/**
	 * assembles an url for tracking measurement without javascript
	 *
	 * e.g. for tracking email open events within a newsletter
	 *
	 * @param string $metricName
	 * @param mixed $metricValue
	 * @param \ArcticFalcon\LaravelAnalytics\Data\Event $event
	 * @param \ArcticFalcon\LaravelAnalytics\Data\Campaign $campaign
	 * @param string|null $clientId
	 * @param array $params
	 * @return string
	 */
	public function trackMeasurementUrl($metricName, $metricValue, Event $event, Campaign $campaign, $clientId = null, array $params = array())
	{
		return '';
	}

	public function nonInteraction($value)
	{

	}

	public function setCustomDimension($index, $value)
	{

	}


}