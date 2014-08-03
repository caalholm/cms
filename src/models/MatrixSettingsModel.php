<?php
namespace Craft;

/**
 * Matrix block model class.
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2014, Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license Craft License Agreement
 * @see       http://buildwithcraft.com
 * @package   craft.app.models
 * @since     1.3
 */
class MatrixSettingsModel extends BaseModel
{
	/**
	 * @var FieldModel|null
	 */
	private $_matrixField;

	/**
	 * @var
	 */
	private $_blockTypes;

	/**
	 * Constructor
	 *
	 * @param FieldModel|null $matrixField
	 *
	 * @return MatrixSettingsModel
	 */
	public function __construct(FieldModel $matrixField = null)
	{
		$this->_matrixField = $matrixField;
	}

	/**
	 * Defines this model's attributes.
	 *
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array(
			'maxBlocks' => AttributeType::Number,
		);
	}

	/**
	 * Returns the field associated with this.
	 *
	 * @return FieldModel
	 */
	public function getField()
	{
		return $this->_matrixField;
	}

	/**
	 * Returns the block types.
	 *
	 * @return array
	 */
	public function getBlockTypes()
	{
		if (!isset($this->_blockTypes))
		{
			if (!empty($this->_matrixField->id))
			{
				$this->_blockTypes = craft()->matrix->getBlockTypesByFieldId($this->_matrixField->id);
			}
			else
			{
				$this->_blockTypes = array();
			}
		}

		return $this->_blockTypes;
	}

	/**
	 * Sets the block types.
	 *
	 * @param array $blockTypes
	 *
	 * @return void
	 */
	public function setBlockTypes($blockTypes)
	{
		$this->_blockTypes = $blockTypes;
	}

	/**
	 * Validates the block type settings.
	 *
	 * @param array|null $attributes
	 * @param bool       $clearErrors
	 *
	 * @return bool
	 */
	public function validate($attributes = null, $clearErrors = true)
	{
		// Enforce $clearErrors without copying code if we don't have to
		$validates = parent::validate($attributes, $clearErrors);

		if (!craft()->matrix->validateFieldSettings($this))
		{
			$validates = false;
		}

		return $validates;
	}
}
