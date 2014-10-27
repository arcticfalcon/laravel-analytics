<?php

use ArcticFalcon\LaravelAnalytics\Data\Hit;

class HitTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$hit = new Hit('event', 'mycat', 'myact', 'mylabel', 321);
		$render = $hit->render();

		$this->assertContains("'event',", $render);
		$this->assertContains("'mycat',", $render);
		$this->assertContains("'myact',", $render);
		$this->assertContains("'mylabel',", $render);
		$this->assertContains("321", $render);

	}

	public function testSetters()
	{
		$hit = new Hit('event', 'mycat', 'myact');

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

