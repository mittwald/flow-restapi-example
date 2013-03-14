<?php
namespace Mw\Articles\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mw.Articles".           *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;

use Mw\Articles\Domain\Model\Article;


/**
 * Article controller for the Mw.Articles package
 *
 * @Flow\Scope("singleton")
 */
class ArticleController extends RestController
{

    /**
     * @var \Mw\Articles\Domain\Repository\ArticleRepository
     * @Flow\Inject
     */
    protected $articleRepository;

    protected $resourceArgumentName = 'article';

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

    /**
     * Index action
     *
     * @return void
     */
    public function listAction()
    {
        //$this->view->setVariablesToRender(array('articles'));
        $this->view->assign('articles', $this->articleRepository->findAll());
    }

    public function showAction(Article $article)
    {
        $this->view->setVariablesToRender(array('article'));
        $this->view->assign('article', $article);
    }

    public function createAction(Article $article)
    {
        $this->articleRepository->add($article);

        $this->response->setStatus(201);
        $this->response->setHeader('Location', $this->request->getHttpRequest()->getBaseUri() . $article->getUri());
    }

    public function updateAction(Article $article)
    {
        $this->articleRepository->update($article);
    }

    public function deleteAction(Article $article)
    {
        $this->articleRepository->remove($article);
    }

}
