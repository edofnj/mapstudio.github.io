<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @link   http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since  11.1
 */
class JFormFieldcookiehint extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'cookiehint';

	/**
	 * Name of the layout being used to render the field
	 *
	 * @var    string
	 * @since  3.7
	 */
	protected $layout = 'joomla.form.field.cookiehint';


	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JFormField::setup()
	 * @since   3.2
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$result = parent::setup($element, $value, $group);

		if ($result == true)
		{
		
		}

		return $result;
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		
		$display='display_'.$this->getAttribute('display','');

		if(method_exists($this,$display)) 
		{
			$output=$this->$display();
		}
		else
		{
			$ouput='';
		}
		
		return $output;
		
	}
	
	public function getAttribute($name,$value='') 
	{
		 if(isset($this->element[$name])) 
		 {
			 $value=$this->element[$name];
		 }
		 return $value;
	}	
	
	private function display_jtext() {
		$output='<p>'.JText::_($this->getAttribute('value')).'</p>';
		return $output;		
	}
	
	private function display_headline() 
	{
		
		$output='<h3>'.JText::_($this->getAttribute('description')).'</h3>';
		return $output;
		
	}		
	
	private function display_changelog() 
	{
		jimport( 'joomla.filesystem.file' );
		$output=JFile::read(JPATH_SITE.'/plugins/system/cookiehint/changelog.txt');
		$output=str_replace("\n",'<br />',$output);
		return $output;
		
	}			
	
	private function display_test() 
	{
			
		$uri = JURI::getInstance(JURI::root());	
		$uri->setVar('cookiehint','test');
		$output = $uri->toString();
		$output='<a class="btn" target="_blank" href="'.$output.'">'.JText::_($this->getAttribute('description')).'</a>';

		return $output;
		
	}


}
