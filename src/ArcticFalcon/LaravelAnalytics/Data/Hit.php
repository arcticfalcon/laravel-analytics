<?php   namespace ArcticFalcon\LaravelAnalytics\Data;
/**
 * laravel-analytics
 *
 * @author arcticfalcon
 * @since 1.1.0
 */

class Hit
{
	protected $allowedHitTypes = ['pageview', 'appview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'];

	/**
	 * event category
	 * @var string
	 */
	private $category = 'email';

	/**
	 * event action
	 * @var string
	 */
	private $action = 'open';

	/**
	 * event label
	 * @var string
	 */
	private $label = null;

	/**
	 * hit type
	 * @var string
	 */
	private $hitType = 'event';

	protected $page = null;

	protected $value = null;

	protected $nonInteraction = false;

	protected $customDimensions = [];

	function __construct($hitType, $category, $action, $label = null, $value = null)
	{
		$this->setHitType($hitType);
		$this->setCategory($category);
		$this->setAction($action);
		$this->setLabel($label);
		$this->setValue($value);

		return $this;
	}


	/**
	 * set action
	 * @param string $action
	 * @return Event
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
	 * @return Event
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
	 * @return Event
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
	 * @return Event
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

	public function render()
	{
		$command = '';
		if ($this->label !== null)
		{
			$command .= ", '{$this->label}'";
			if ($this->value !== null)
			{
				$command .= ", {$this->value}";
			}
		}

		$field = [];
		if($this->nonInteraction)
		{
			$field['nonInteraction'] = 1;
		}
		foreach($this->customDimensions as $index => $value)
		{
			$field['dimension'.$index] = $value;
		}
		if($this->page)
		{
			$field['page'] = $this->page;
		}

		$field = json_encode($field, JSON_FORCE_OBJECT + JSON_UNESCAPED_SLASHES);
		if($field != '{}')
		{
			$field = ', ' . $field;
		}
		else
		{
			$field = '';
		}

		return "ga('send', '{$this->hitType}', '{$this->category}', '{$this->action}'{$command}{$field});";
	}

}