<?php
namespace Mw\RestExample\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mw.RestExample".        *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Article
 *
 * @Flow\Entity
 */
class Article
{

    /**
     * The name
     * @var string
     */
    protected $name;

    /**
     * The price
     * @var double
     */
    protected $price;

    /**
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\Flow\Configuration\ConfigurationManager
     * @Flow\Inject
     */
    protected $configurationManager;


    /**
     * Get the Article's name
     *
     * @return string The Article's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets this Article's name
     *
     * @param string $name The Article's name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the Article's price
     *
     * @return double The Article's price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets this Article's price
     *
     * @param double $price The Article's price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getUri()
    {
        $config     = $this->configurationManager->getConfiguration(\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
        $uriPattern = $config['Mw']['Articles']['UriPatterns'][get_class($this)];

        return $config['TYPO3']['Flow']['http']['baseUri'] . sprintf($uriPattern, $this->persistenceManager->getIdentifierByObject($this));
    }

}

