<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_localise
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Languages View class for the Localise component
 *
 * @package     Extensions.Components
 * @subpackage  Localise
 */
class LocaliseViewLanguages extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $form;
	protected $state;

	/**
	 * Display the view
	 *
	 * @return  void
	 */
	function display($tpl = null) 
	{
		// Get the data
		$this->items      = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state      = $this->get('State');
		$this->form       = $this->get('Form');

		LocaliseHelper::addSubmenu('languages');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Set the toolbar
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		// Prepare the document
		$this->prepareDocument();

		// Display the view
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar() 
	{
		$canDo = LocaliseHelper::getActions();

		JToolbarHelper::title(JText::sprintf('COM_LOCALISE_HEADER_MANAGER', JText::_('COM_LOCALISE_HEADER_LANGUAGES')), 'langmanager.png');

		if ($canDo->get('localise.create')) 
		{
			JToolbarHelper::addNew('language.add');
			JToolbarHelper::divider();
		}

		if ($canDo->get('core.admin')) 
		{
			JToolbarHelper::preferences('com_localise');
			JToolbarHelper::divider();
		}

		JToolBarHelper::help('screen.languages', true);

		JSubMenuHelper::setAction('index.php?option=com_localise&view=languages');
	}

	protected function prepareDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::sprintf('COM_LOCALISE_TITLE', JText::_('COM_LOCALISE_TITLE_LANGUAGES')));
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since 3.0
	 */
	protected function getSortFields()
	{
		return array(
			'tag'    => JText::_('COM_LOCALISE_HEADING_LANGUAGES_NAME'),
			'client' => JText::_('COM_LOCALISE_HEADING_LANGUAGES_CLIENT'),
		);
	}
}
