<?php

declare(strict_types=1);

/**
 * @copyright 2018
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OC\FullTextSearch\Model;

use JsonSerializable;
use OCP\FullTextSearch\IFullTextSearchProvider;
use OCP\FullTextSearch\Model\ISearchOption;
use OCP\FullTextSearch\Model\ISearchTemplate;

/**
 * Class ISearchTemplate
 *
 * This is a data transfer object that should be created by Content Provider
 * when the getSearchTemplate() method is called.
 *
 * The object will contain templates to be displayed, and the list of the different
 * options to be available to the user when he start a new search.
 *
 * The display of the Options is generated by the FullTextSearch app and Options
 * can be displayed in 2 places:
 *
 * - the navigation page of the app that generate the indexed content.
 *   (files, bookmarks, deck, mails, ...)
 * - the navigation page of the FullTextSearch app.
 *
 * Both pages will have different Options, and only the first one can integrate
 * a specific template.
 *
 * @see IFullTextSearchProvider::getSearchTemplate
 *
 * @since 15.0.0
 *
 * @package OC\FullTextSearch\Model
 */
final class SearchTemplate implements ISearchTemplate, JsonSerializable {


	/** @var string */
	private $icon = '';

	/** @var string */
	private $css = '';

	/** @var string */
	private $template = '';

	/** @var SearchOption[] */
	private $panelOptions = [];

	/** @var SearchOption[] */
	private $navigationOptions = [];


	/**
	 * ISearchTemplate constructor.
	 *
	 * the class of the icon and the css file to be loaded can be set during the
	 * creation of the object.
	 *
	 * @since 15.0.0
	 *
	 * @param string $icon
	 * @param string $css
	 */
	public function __construct(string $icon = '', string $css = '') {
		$this->icon = $icon;
		$this->css = $css;
	}


	/**
	 * Set the class of the icon to be displayed in the left panel of the
	 * FullTextSearch navigation page, in front of the related Content Provider.
	 *
	 * @since 15.0.0
	 *
	 * @param string $class
	 *
	 * @return ISearchTemplate
	 */
	public function setIcon(string $class): ISearchTemplate {
		$this->icon = $class;

		return $this;
	}

	/**
	 * Get the class of the icon.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getIcon(): string {
		return $this->icon;
	}


	/**
	 * Set the path of a CSS file that will be loaded when needed.
	 *
	 * @since 15.0.0
	 *
	 * @param string $css
	 *
	 * @return ISearchTemplate
	 */
	public function setCss(string $css): ISearchTemplate {
		$this->css = $css;

		return $this;
	}

	/**
	 * Get the path of the CSS file.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getCss(): string {
		return $this->css;
	}


	/**
	 * Set the path of the file of a template that the HTML will be displayed
	 * below the Options.
	 * This should only be used if your Content Provider needs to set options in
	 * a way not generated by FullTextSearch
	 *
	 * @since 15.0.0
	 *
	 * @param string $template
	 *
	 * @return ISearchTemplate
	 */
	public function setTemplate(string $template): ISearchTemplate {
		$this->template = $template;

		return $this;
	}

	/**
	 * Get the path of the template file.
	 *
	 * @since 15.0.0
	 *
	 * @return string
	 */
	public function getTemplate(): string {
		return $this->template;
	}


	/**
	 * Add an option in the Panel that is displayed when the user start a search
	 * within the app that generate the content.
	 *
	 * @see ISearchOption
	 *
	 * @since 15.0.0
	 *
	 * @param ISearchOption $option
	 *
	 * @return ISearchTemplate
	 */
	public function addPanelOption(ISearchOption $option): ISearchTemplate {
		$this->panelOptions[] = $option;

		return $this;
	}

	/**
	 * Get all options to be displayed in the Panel.
	 *
	 * @since 15.0.0
	 *
	 * @return SearchOption[]
	 */
	public function getPanelOptions(): array {
		return $this->panelOptions;
	}


	/**
	 * Add an option in the left panel of the FullTextSearch navigation page.
	 *
	 * @see ISearchOption
	 *
	 * @since 15.0.0
	 *
	 * @param ISearchOption $option
	 *
	 * @return ISearchTemplate
	 */
	public function addNavigationOption(ISearchOption $option): ISearchTemplate {
		$this->navigationOptions[] = $option;

		return $this;
	}

	/**
	 * Get all options to be displayed in the FullTextSearch navigation page.
	 *
	 * @since 15.0.0
	 *
	 * @return array
	 */
	public function getNavigationOptions(): array {
		return $this->navigationOptions;
	}


	/**
	 * @since 15.0.0
	 *
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'icon' => $this->getIcon(),
			'css' => $this->getCss(),
			'template' => $this->getTemplate(),
			'panel' => $this->getPanelOptions(),
			'navigation' => $this->getNavigationOptions()
		];
	}
}
