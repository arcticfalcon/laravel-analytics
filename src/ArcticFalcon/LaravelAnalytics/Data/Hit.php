<?php   namespace ArcticFalcon\LaravelAnalytics\Data;
/**
 * laravel-analytics
 *
 * @author arcticfalcon
 * @since 1.1.0
 */

class Hit
{
	const PageView = 'pageview';
	const AppView = 'appview';
	const Event = 'event';
	const Transaction = 'transaction';
	const Item = 'item';
	const Social = 'social';
	const Exception = 'exception';
	const Timing = 'timing';

	protected $allowedHitTypes = ['pageview', 'appview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'];

	/**
	 * event category
	 * @var string
	 */
	protected $category = null;

	/**
	 * event action
	 * @var string
	 */
	protected $action = null;

	/**
	 * event label
	 * @var string
	 */
	protected $label = null;

	protected $title = null;

	/**
	 * hit type
	 * @var string
	 */
	protected $hitType = null;

	protected $page = null;

	protected $value = null;

	protected $nonInteraction = false;

	protected $customDimensions = [];

	protected $hitCallback = null;

	function __construct($hitType, $categoryOrPage = null, $actionOrTitle = null, $label = null, $value = null)
	{
		$this->setHitType($hitType);
		if($this->hitType == static::PageView)
		{
			$this->setPage($categoryOrPage)
				->setTitle($actionOrTitle);
		}
		if($this->hitType == static::Event)
		{
			$this->setCategory($categoryOrPage)
				->setAction($actionOrTitle);
		}

		$this->setLabel($label)
			->setValue($value);

		return $this;
	}


	/**
	 * set action
	 * @param string $action
	 * @return Hit
	 */
	public function setAction($action)
	{
		$this->action = $action;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * set category
	 *
	 * @param string $category
	 *
	 * @return Hit
	 */
	public function setCategory($category)
	{
		$this->category = $category;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * set hitType
	 *
	 * @param string $hitType
	 *
	 * @return Hit
	 */
	public function setHitType($hitType)
	{
		if (!in_array($hitType, $this->allowedHitTypes))
		{
			throw new \InvalidArgumentException("$hitType is not a valid Hit type");
		}
		$this->hitType = $hitType;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHitType()
	{
		return $this->hitType;
	}

	/**
	 * set label
	 *
	 * @param string $label
	 *
	 * @return Hit
	 */
	public function setLabel($label)
	{
		$this->label = $label;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		if ($value !== null && is_numeric($value))
		{
			$this->value = $value;
		}

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPage()
	{
		return $this->page;
	}

	/**
	 * @param string $page
	 */
	public function setPage($page)
	{
		$this->page = $page;

		return $this;
	}

	/**
	 * @return null
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param null $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}




	/**
	 * @return boolean
	 */
	public function isNonInteraction()
	{
		return $this->nonInteraction;
	}

	/**
	 * @param boolean $nonInteraction
	 */
	public function setNonInteraction($nonInteraction)
	{
		$this->nonInteraction = $nonInteraction;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCustomDimensions()
	{
		return $this->customDimensions;
	}

	/**
	 * @param array $customDimensions
	 */
	public function setCustomDimension($index, $value)
	{
		if(!is_int($index) || $index < 1 || $index > 200)
		{
			throw new \InvalidArgumentException("index must be a positive integer between 1 and 200");
		}

		$this->customDimensions[$index] = $value;

		return $this;
	}

	public function getCustomDimension($index)
	{
		return $this->customDimensions[$index];
	}

	/**
	 * @return null|string
	 */
	public function getHitCallback()
	{
		return $this->hitCallback;
	}

	/**
	 * @param string $hitCallback
	 */
	public function setHitCallback($hitCallback)
	{
		$this->hitCallback = $hitCallback;

		return $this;
	}



	public function render()
	{
		$field = [];
		if($this->nonInteraction == true)
		{
			$field['nonInteraction'] = 1;
		}
		if($this->page !== null)
		{
			$field['page'] = $this->page;
		}
		if($this->title !== null)
		{
			$field['title'] = $this->title;
		}
		if($this->category !== null)
		{
			$field['eventCategory'] = $this->category;
		}
		if($this->action !== null)
		{
			$field['eventAction'] = $this->action;
		}
		if ($this->label !== null)
		{
			$field['eventLabel'] = $this->label;
		}
		if ($this->value !== null)
		{
			$field['eventValue'] = $this->value;
		}
		foreach($this->customDimensions as $index => $value)
		{
			$field['dimension'.$index] = $value;
		}

		$field = json_encode($field, JSON_FORCE_OBJECT + JSON_UNESCAPED_SLASHES);

		if($this->hitCallback !== null)
		{
			$field = rtrim($field, '}');
			if($field != '{')
			{
				$field .= ',';
			}
			$field .= '"hitCallback":'. $this->hitCallback . '}';
		}

		if($field != '{}')
		{
			$field = ', ' . $field;
		}
		else
		{
			$field = '';
		}

		return "ga('send', '{$this->hitType}'{$field});";
	}

}