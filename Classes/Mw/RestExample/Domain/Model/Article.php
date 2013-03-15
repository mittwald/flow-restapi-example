<?php
namespace Mw\RestExample\Domain\Model;


/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mw.RestExample".        *
 * Copyright (C) 2013  Martin Helmich <m.helmich@mittwald.de>             *
 *                     Mittwald CM Service GmbH & Co. KG                  *
 *                                                                        *
 * This program is free software: you can redistribute it and/or modify   *
 * it under the terms of the GNU General Public License as published by   *
 * the Free Software Foundation, either version 3 of the License, or      *
 * (at your option) any later version.                                    *
 *                                                                        *
 * This program is distributed in the hope that it will be useful,        *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of         *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          *
 * GNU General Public License for more details.                           *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.  *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow,
    TYPO3\Flow\Configuration\ConfigurationManager,
    Doctrine\ORM\Mapping as ORM;


/**
 * Models a simple article.
 *
 * @author Martin Helmich <m.helmich@mittwald.de>
 *
 * @Flow\Entity
 */
class Article
{



    /**
     * The name.
     * @var string
     */
    protected $name;


    /**
     * The price.
     * @var float
     */
    protected $price;


    /**
     * An instance of Flow's persistence manager.
     *
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;


    /**
     * An instance of Flow's configuration manager.
     * @var \TYPO3\Flow\Configuration\ConfigurationManager
     * @Flow\Inject
     */
    protected $configurationManager;



    /**
     * Gets the article's name.
     *
     * @return string The article's name.
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * Sets this article's name.
     *
     * @param  string $name The article's name.
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }



    /**
     * Get the article's price.
     *
     * @return float The article's price.
     */
    public function getPrice()
    {
        return $this->price;
    }



    /**
     * Sets this article's price.
     *
     * @param  float $price The article's price.
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }



    /**
     * Gets this article's URI.
     *
     * @return string The article's URI.
     */
    public function getUri()
    {
        $config     = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
        $baseUri    = rtrim($config['TYPO3']['Flow']['http']['baseUri'], '/');
        $uriPattern = ltrim($config['Mw']['Articles']['UriPatterns'][get_class($this)], '/');

        return sprintf($baseUri . '/' . $uriPattern, $this->persistenceManager->getIdentifierByObject($this));
    }

}

