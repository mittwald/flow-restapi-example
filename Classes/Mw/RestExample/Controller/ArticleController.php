<?php
namespace Mw\RestExample\Controller;


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
    TYPO3\Flow\Mvc\Controller\RestController,
    TYPO3\Flow\Mvc\View\JsonView;

use Mw\RestExample\Domain\Model\Article;


/**
 * Controller for managing articles.
 *
 * @author Martin Helmich <m.helmich@mittwald.de>
 *
 * @Flow\Scope("singleton")
 */
class ArticleController extends RestController
{



    /**
     * @var \Mw\RestExample\Domain\Repository\ArticleRepository
     * @Flow\Inject
     */
    protected $articleRepository;


    /**
     * The default argument name.
     * @var string
     */
    protected $resourceArgumentName = 'article';


    /**
     * Supported content types. Needed for HTTP content negotiation.
     * @var array
     */
    protected $supportedMediaTypes = array('application/json', 'application/xml');



    protected function resolveViewObjectName()
    {
        $contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
        switch ($contentType)
        {
            case 'application/xml':
                $this->request->setFormat('xml');
                $this->response->setHeader('Content-Type', 'application/xml');

                return parent::resolveViewObjectName();
            case 'application/json':
            default:
                return 'TYPO3\\Flow\\Mvc\\View\\JsonView';
        }
    }



    public function initializeListAction()
    {
        if ($this->view instanceof JsonView)
        {
            $this->view->setVariablesToRender(array('articles'));
        }
    }



    /**
     * Lists all articles.
     *
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('articles', $this->articleRepository->findAll());
    }



    /**
     * Initializes the show action.
     *
     * @return void
     */
    public function initializeShowAction()
    {
        if ($this->view instanceof JsonView)
        {
            $this->view->setVariablesToRender(array('article'));
        }
    }



    /**
     * Displays a single article.
     *
     * @param  Article $article The article to be displayed.
     * @return void
     */
    public function showAction(Article $article)
    {
        $this->view->assign('article', $article);
    }



    /**
     * Creates a new article.
     *
     * The reponse contains a location header to the created article's URI.
     *
     * @param  Article $article The article to be created.
     * @return void
     */
    public function createAction(Article $article)
    {
        $this->articleRepository->add($article);

        $this->response->setStatus(201);
        $this->response->setHeader('Location', $article->getUri());
    }



    /**
     * Updates an existing article.
     *
     * @param  Article $article The article to be updated.
     * @return void
     */
    public function updateAction(Article $article)
    {
        $this->articleRepository->update($article);
    }



    /**
     * Deletes an article.
     *
     * @param  Article $article The article to be deleted.
     * @return void
     */
    public function deleteAction(Article $article)
    {
        $this->articleRepository->remove($article);
    }

}
