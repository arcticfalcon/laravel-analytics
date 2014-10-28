<?php

require('TrackingBagMock.php');
use ArcticFalcon\LaravelAnalytics\Data\Hit;
use ArcticFalcon\LaravelAnalytics\Providers\GoogleAnalytics;

class GoogleAnalyticsTest extends PHPUnit_Framework_TestCase
{
	protected $options = ['tracking_id' => 'UA-121312-12',
	                      'tracking_domain' => 'auto',
	                      'anonymize_ip' => true,
	                      'auto_track' => true,
	                      'sandbox' => true,
	];

	public function testConstructor()
	{
		$ga = new GoogleAnalytics($this->options, new TrackingBagMock);
		$render = $ga->render();

		$this->assertContains("'create', '{$this->options['tracking_id']}", $render);

		if($this->options['anonymize_ip'])
		{
			$this->assertContains("'set', 'anonymizeIp', true", $render);
		}
		if($this->options['auto_track'])
		{
			$this->assertContains("'send', 'pageview'", $render);
		}
	}

	public function testSetters()
	{
		$ga = new GoogleAnalytics($this->options, new TrackingBagMock);
		$ga->nonInteraction(true);
		$ga->setCustomDimension(3, '_cd1_');
		$render = $ga->render();

		$this->assertContains("'set', 'nonInteraction', true", $render);
		$this->assertContains("'set', 'dimension3', '_cd1_'", $render);
	}

	public function testHit()
	{
		$ga = new GoogleAnalytics($this->options, new TrackingBagMock);
		$ga->trackHit(
			(new Hit(Hit::PageView))
			->setPage('/mypage')
		);

		$render = $ga->render();

		$this->assertContains("ga('send', 'pageview',", $render);
		$this->assertContains("\"page\":\"/mypage\"", $render);

	}
}

