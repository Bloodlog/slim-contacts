<?php
namespace App\controllers;


use Slim\Container;
use Slim\Views\Twig;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\core\Controller;
use App\models\Contacts;
use App\core\db\Adapter;
/**
* 
*/
class ContactsController extends Controller
{
	public function actionIndex(RequestInterface $request, ResponseInterface $response, $args){
    	$model = Contacts::models();
    	$this->view->render($response, 'contacts/index.twig', [
    		'title' => 'Менеджер контактов',
    		'contacts' => $model,
    	]);
	}

	public function actionView(RequestInterface $request, ResponseInterface $response, $args){
		$model = Contacts::model($args['id']);
		$this->view->render($response, 'contacts/view.twig', [
    		'title' => 'Просмотр контакта',
    		'contact' => $model,
    	]);
	}


	public function actionCreate(RequestInterface $request, ResponseInterface $response, $args){
		if($request->isPost()){
			$model = new Contacts();
			// Получаем данные из формы
			$model->__attributes = $request->getParsedBody('form')['form'];
			//Отправляем данные на сохранение
			$model->save();
			//Перенаправляем пользователя на главную
			$uri = $this->getBaseUrl($request);
			return $response->withRedirect((string)$uri, 200);
		}else{
			$this->view->render($response, 'contacts/form.twig', [
	    		'title' => 'Создание контакта',
	    		'action' => 'create',
    		]);
		}
		
	}

	public function actionUpdate(RequestInterface $request, ResponseInterface $response, $args){
		if($request->isPost()){
			$model = new Contacts();
			// Получаем данные из формы
			$model->__attributes = $request->getParsedBody('form')['form'];
			//Отправляем данные на сохранение
			$model->save();
			//Перенаправляем пользователя на главную
			$uri = $this->getBaseUrl($request);
			return $response->withRedirect((string)$uri, 200);
		}else{
			$model = Contacts::model($args['id']);
			$this->view->render($response, 'contacts/form.twig', [
	    		'title' => 'Редактирование контакта',
	    		// Для формирования маршрута
	    		'action' => 'update',
	    		// Данные для формы
	    		'contact' => $model,
	    	]);
		}
	}

	public function actionDelete(RequestInterface $request, ResponseInterface $response, $args){
		Contacts::delete($args['id']);
		//Перенаправляем пользователя на главную
		$uri = $this->getBaseUrl($request);
		return $response->withRedirect((string)$uri, 200);
	}


}