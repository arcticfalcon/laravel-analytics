<?php

use ArcticFalcon\LaravelAnalytics\Data\Hit;

class HitTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$hit = new Hit(Hit::Event, 'mycat', 'myact', 'mylabel', 321);
		$render = $hit->render();

		$this->assertContains('event', $render);
		$this->assertContains('eventCategory":"mycat"', $render);
		$this->assertContains('eventAction":"myact"', $render);
		$this->assertContains('eventLabel":"mylabel"', $render);
		$this->assertContains('eventValue":321', $render);
	}

	public function testSetters()
	{
		$hit = new Hit(Hit::Event, 'mycat', 'myact');

		$hit->setNonInteraction(true)
			->setCustomDimension(2, 'mydim')
			->setPage('/mypage')
			->setCustomDimension(4, 'myotherdim');

		$render = $hit->render();

		$this->assertContains('"nonInteraction":1', $render);
		$this->assertContains('"dimension2":"mydim"', $render);
		$this->assertContains('"dimension4":"myotherdim"', $render);
		$this->assertContains('"page":"/mypage"', $render);
	}
}

